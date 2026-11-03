<?php
/**
 * Fetches Commerce7 route SEO from the external SEO service and prints it.
 *
 * The plugin signs the request, caches the response, and escapes the HTML.
 * Title, schema, and wine-list rules live on the service.
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.8.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SEO bridge for Commerce7 front-end routes.
 */
class C7WP_SEO_Bridge {

	const FRESH_TTL = 1800;
	const STALE_TTL = 43200;
	const TIMEOUT   = 3;
	const MAX_BODY  = 32768;

	/**
	 * Bump when the cached JSON shape changes. Old transients are ignored.
	 */
	const CACHE_VERSION = '2';

	/**
	 * Cached payload for the current request.
	 *
	 * @var array<string, mixed>|null
	 */
	private static $payload = null;

	/**
	 * Cache key that should be refreshed after the response is sent.
	 *
	 * @var string
	 */
	private static $refresh_key = '';

	/**
	 * Whether the collection list has already been printed.
	 *
	 * @var bool
	 */
	private static $list_printed = false;

	/**
	 * Register hooks.
	 */
	public static function register() {
		add_action( 'template_redirect', array( __CLASS__, 'prepare' ), 0 );
		add_action( 'wp_head', array( __CLASS__, 'print_head' ), 1 );
		add_filter( 'the_content', array( __CLASS__, 'insert_list' ), 8 );
		add_action( 'wp_footer', array( __CLASS__, 'enqueue_list_script' ), 1 );
		add_action( 'shutdown', array( __CLASS__, 'refresh_stale' ) );

		add_filter( 'pre_get_document_title', array( __CLASS__, 'filter_title' ) );
		add_filter( 'wpseo_title', array( __CLASS__, 'filter_title' ) );
		add_filter( 'wpseo_metadesc', array( __CLASS__, 'filter_description' ) );
		add_filter( 'wpseo_json_ld_output', array( __CLASS__, 'filter_yoast_schema' ) );
		add_filter( 'wpseo_frontend_presenter_classes', array( __CLASS__, 'filter_yoast_social' ) );
		add_filter( 'wpseo_robots', array( __CLASS__, 'filter_robots_string' ) );

		add_filter( 'rank_math/frontend/title', array( __CLASS__, 'filter_title' ) );
		add_filter( 'rank_math/frontend/description', array( __CLASS__, 'filter_description' ) );
		add_filter( 'rank_math/frontend/robots', array( __CLASS__, 'filter_rank_math_robots' ) );
		add_filter( 'rank_math/json_ld', array( __CLASS__, 'filter_rank_math_schema' ), 99 );

		add_filter( 'aioseo_title', array( __CLASS__, 'filter_title' ) );
		add_filter( 'aioseo_description', array( __CLASS__, 'filter_description' ) );

		add_filter( 'seopress_titles_title', array( __CLASS__, 'filter_title' ) );
		add_filter( 'seopress_titles_desc', array( __CLASS__, 'filter_description' ) );
	}

	/**
	 * Worker endpoint. Override with the c7wp_seo_worker_url filter.
	 *
	 * @return string
	 */
	public static function worker_url() {
		$url = apply_filters( 'c7wp_seo_worker_url', 'https://seo.c7wp.com/v1/meta' );
		return is_string( $url ) ? $url : '';
	}

	/**
	 * Load a cached or live payload for this request.
	 */
	public static function prepare() {
		if ( ! self::should_request() ) {
			return;
		}

		$context = self::request_context();
		if ( null === $context ) {
			return;
		}

		$key    = self::cache_key( $context );
		$cached = get_transient( $key );

		if ( is_array( $cached ) && isset( $cached['stored_at'] ) ) {
			self::$payload = $cached;
			$age           = time() - (int) $cached['stored_at'];
			if ( $age >= self::FRESH_TTL && $age < self::STALE_TTL ) {
				self::$refresh_key = $key;
			}
			self::suppress_core_robots();
			return;
		}

		$live = self::fetch( $context );
		if ( is_array( $live ) ) {
			set_transient( $key, $live, self::STALE_TTL );
			self::$payload = $live;
			self::suppress_core_robots();
			return;
		}

		$negative = array(
			'stored_at'   => time(),
			'title'       => '',
			'description' => '',
			'head'        => '',
			'list'        => '',
		);
		set_transient( $key, $negative, 2 * MINUTE_IN_SECONDS );
	}

	/**
	 * Print sanitized head tags.
	 */
	public static function print_head() {
		$payload = self::payload();
		if ( ! is_array( $payload ) || '' === $payload['head'] ) {
			return;
		}

		echo $payload['head']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitized in sanitize_head().
	}

	/**
	 * Place the wine list after the Commerce7 mount.
	 *
	 * The list stays in the HTML for crawlers that do not run JavaScript.
	 * It is clipped out of the layout, then removed once Commerce7 fills #c7-content.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public static function insert_list( $content ) {
		if ( self::$list_printed || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$payload = self::payload();
		if ( ! is_array( $payload ) || '' === $payload['list'] ) {
			return $content;
		}

		self::$list_printed = true;
		$list               = self::list_markup( $payload['list'] );
		$pattern            = '/<div\b[^>]*\bid=(["\'])c7-content\1[^>]*>\s*<\/div>/i';
		$updated            = preg_replace_callback(
			$pattern,
			static function ( $matches ) use ( $list ) {
				return $matches[0] . $list;
			},
			$content,
			1,
			$count
		);

		if ( is_string( $updated ) && $count > 0 ) {
			return $updated;
		}

		return $content . $list;
	}

	/**
	 * Visually hide the crawler list without removing it from the HTML.
	 *
	 * @param string $list Sanitized list markup.
	 * @return string
	 */
	private static function list_markup( $list ) {
		$style = '<style>.c7wp-seo-wines{border:0;clip:rect(1px,1px,1px,1px);clip-path:inset(50%);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;white-space:nowrap}</style>';
		return $style . $list;
	}

	/**
	 * Enqueue the script that removes the crawler list after Commerce7 renders.
	 *
	 * Runs on wp_footer before footer scripts print, because the list is only
	 * known once the_content has run.
	 */
	public static function enqueue_list_script() {
		if ( ! self::$list_printed ) {
			return;
		}

		wp_enqueue_script(
			'c7wp-seo-list',
			C7WP_URI . 'assets/public/js/c7wp-seo-list.js',
			array(),
			C7WP_VERSION,
			true
		);
	}

	/**
	 * Refresh a stale cache entry after the page has been sent.
	 */
	public static function refresh_stale() {
		if ( '' === self::$refresh_key || ! self::should_request() ) {
			return;
		}

		$lock = 'c7wp_seo_lock_' . self::$refresh_key;
		if ( get_transient( $lock ) ) {
			return;
		}
		set_transient( $lock, 1, MINUTE_IN_SECONDS );

		$context = self::request_context();
		if ( null === $context ) {
			return;
		}

		$live = self::fetch( $context );
		if ( is_array( $live ) ) {
			set_transient( self::$refresh_key, $live, self::STALE_TTL );
		}
	}

	/**
	 * Replace the document title when the service sent one.
	 *
	 * @param string $title Existing title.
	 * @return string
	 */
	public static function filter_title( $title ) {
		$payload = self::payload();
		if ( ! is_array( $payload ) || '' === $payload['title'] ) {
			return $title;
		}
		return $payload['title'];
	}

	/**
	 * Replace the meta description when the service sent one.
	 *
	 * @param string $description Existing description.
	 * @return string
	 */
	public static function filter_description( $description ) {
		$payload = self::payload();
		if ( ! is_array( $payload ) || '' === $payload['description'] ) {
			return $description;
		}
		return $payload['description'];
	}

	/**
	 * Skip Yoast schema when the service sent JSON-LD.
	 *
	 * @param mixed $output Yoast schema output.
	 * @return mixed
	 */
	public static function filter_yoast_schema( $output ) {
		if ( self::head_contains( 'application/ld+json' ) ) {
			return false;
		}
		return $output;
	}

	/**
	 * Skip Yoast Open Graph and Twitter tags when the service sent them.
	 *
	 * @param array $presenters Yoast presenter class names.
	 * @return array
	 */
	public static function filter_yoast_social( $presenters ) {
		if ( ! self::head_contains( 'property="og:' ) && ! self::head_contains( 'name="twitter:' ) ) {
			return $presenters;
		}

		$kept = array();
		foreach ( (array) $presenters as $presenter ) {
			if ( ! is_string( $presenter ) ) {
				$kept[] = $presenter;
				continue;
			}
			if ( false !== strpos( $presenter, 'Open_Graph' ) || false !== strpos( $presenter, 'Twitter' ) ) {
				continue;
			}
			$kept[] = $presenter;
		}
		return $kept;
	}

	/**
	 * Force a noindex robots string when the service asked for one.
	 *
	 * @param string $robots Existing robots value.
	 * @return string
	 */
	public static function filter_robots_string( $robots ) {
		if ( self::head_contains( 'noindex' ) ) {
			return 'noindex, nofollow';
		}
		return $robots;
	}

	/**
	 * Force Rank Math robots when the service asked for noindex.
	 *
	 * @param array $robots Rank Math robots directives.
	 * @return array
	 */
	public static function filter_rank_math_robots( $robots ) {
		if ( ! self::head_contains( 'noindex' ) ) {
			return $robots;
		}
		return array(
			'index'  => 'noindex',
			'follow' => 'nofollow',
		);
	}

	/**
	 * Skip Rank Math schema when the service sent JSON-LD.
	 *
	 * @param array $data Rank Math schema graph.
	 * @return array
	 */
	public static function filter_rank_math_schema( $data ) {
		if ( self::head_contains( 'application/ld+json' ) ) {
			return array();
		}
		return $data;
	}

	/**
	 * Current sanitized payload.
	 *
	 * @return array<string, mixed>|null
	 */
	private static function payload() {
		return self::$payload;
	}

	/**
	 * Whether the sanitized head contains a marker.
	 *
	 * @param string $needle Marker.
	 * @return bool
	 */
	private static function head_contains( $needle ) {
		$payload = self::payload();
		return is_array( $payload ) && '' !== $payload['head'] && false !== strpos( $payload['head'], $needle );
	}

	/**
	 * Whether this request should call the SEO service.
	 *
	 * @return bool
	 */
	private static function should_request() {
		if ( is_admin() || is_feed() || is_preview() || wp_doing_ajax() || wp_doing_cron() ) {
			return false;
		}
		if ( function_exists( 'wp_is_json_request' ) && wp_is_json_request() ) {
			return false;
		}

		$options = c7wp_get_settings();
		if ( 'yes' !== ( $options['c7wp_enable_seo_bridge'] ?? 'no' ) ) {
			return false;
		}
		if ( '' === ( $options['c7wp_seo_site_token'] ?? '' ) || '' === ( $options['c7wp_tenant'] ?? '' ) ) {
			return false;
		}
		if ( '' === self::worker_url() ) {
			return false;
		}

		return c7wp_is_frontend_route_request( self::requested_url() );
	}

	/**
	 * Tenant, path, and page used for the signature.
	 *
	 * @return array<string, mixed>|null
	 */
	private static function request_context() {
		$options = c7wp_get_settings();
		$tenant  = isset( $options['c7wp_tenant'] ) ? (string) $options['c7wp_tenant'] : '';
		$token   = isset( $options['c7wp_seo_site_token'] ) ? (string) $options['c7wp_seo_site_token'] : '';
		$path    = self::request_path();

		if ( '' === $tenant || '' === $token || '/' === $path ) {
			return null;
		}

		return array(
			'tenant' => $tenant,
			'token'  => $token,
			'path'   => rawurldecode( $path ),
			'page'   => c7wp_has_commerce7_pagination_query() ? (int) wp_unslash( $_GET['page'] ) : 0, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'type'   => self::route_type( $path ),
			'site'   => untrailingslashit( home_url() ),
		);
	}

	/**
	 * Public request URL.
	 *
	 * @return string
	 */
	private static function requested_url() {
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		return home_url( $uri );
	}

	/**
	 * Path sent to the Worker, with a leading slash and no trailing slash.
	 *
	 * @return string
	 */
	private static function request_path() {
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
		$home = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );

		if ( '' !== $home && '/' !== $home && 0 === strpos( $path, $home ) ) {
			$path = substr( $path, strlen( $home ) );
		}

		$path = '/' . trim( $path, '/' );
		return '/' === $path ? '/' : untrailingslashit( $path );
	}

	/**
	 * Commerce7 route key for a public path.
	 *
	 * Uses the saved custom slugs only when custom routes are enabled.
	 *
	 * @param string $path Request path.
	 * @return string
	 */
	private static function route_type( $path ) {
		$options = c7wp_get_settings();
		$routes  = c7wp_get_default_frontend_routes();

		if ( 'yes' === ( $options['c7wp_enable_custom_routes'] ?? 'no' ) && isset( $options['c7wp_frontend_routes'] ) && is_array( $options['c7wp_frontend_routes'] ) ) {
			$routes = $options['c7wp_frontend_routes'];
		}

		$first = strtok( trim( $path, '/' ), '/' );
		$key   = false !== $first ? array_search( $first, $routes, true ) : false;

		return false === $key ? '' : (string) $key;
	}

	/**
	 * Transient key for a request context.
	 *
	 * @param array<string, mixed> $context Request context.
	 * @return string
	 */
	private static function cache_key( $context ) {
		return 'c7wp_seo_' . self::CACHE_VERSION . '_' . md5( $context['tenant'] . '|' . $context['path'] . '|' . $context['page'] . '|' . $context['type'] . '|' . $context['site'] );
	}

	/**
	 * Signed GET to the Worker.
	 *
	 * @param array<string, mixed> $context Request context.
	 * @return array<string, mixed>|null
	 */
	private static function fetch( $context ) {
		$timestamp = time();
		// Sign the decoded values. add_query_arg encodes them once for the query string.
		$payload   = implode(
			'|',
			array(
				$context['tenant'],
				$context['path'],
				$context['page'],
				$context['type'],
				$timestamp,
				$context['site'],
			)
		);
		$signature = hash_hmac( 'sha256', $payload, $context['token'] );

		$response = wp_remote_get(
			add_query_arg(
				array(
					'tenant' => $context['tenant'],
					'path'   => $context['path'],
					'page'   => $context['page'],
					'type'   => $context['type'],
					'ts'     => $timestamp,
					'site'   => $context['site'],
					'sig'    => $signature,
				),
				self::worker_url()
			),
			array(
				'timeout' => self::TIMEOUT,
				'headers' => array(
					'Accept' => 'application/json',
				),
			)
		);

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			return null;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( ! is_string( $body ) || strlen( $body ) > self::MAX_BODY ) {
			return null;
		}

		$data = json_decode( $body, true );
		if ( ! is_array( $data ) ) {
			return null;
		}

		return array(
			'stored_at'   => time(),
			'title'       => self::plain_text( $data['title'] ?? '', 180 ),
			'description' => self::plain_text( $data['description'] ?? '', 320 ),
			'head'        => self::sanitize_head( isset( $data['head'] ) ? (string) $data['head'] : '' ),
			'list'        => self::sanitize_list( isset( $data['list'] ) ? (string) $data['list'] : '' ),
		);
	}

	/**
	 * Single-line plain text with a maximum length.
	 *
	 * @param mixed $value Raw value.
	 * @param int   $length Maximum length.
	 * @return string
	 */
	private static function plain_text( $value, $length ) {
		$text = sanitize_text_field( (string) $value );
		if ( strlen( $text ) > $length ) {
			$text = substr( $text, 0, $length );
		}
		return $text;
	}

	/**
	 * Keep only canonical, meta, and JSON-LD tags.
	 *
	 * @param string $html Raw head fragment.
	 * @return string
	 */
	private static function sanitize_head( $html ) {
		if ( '' === $html ) {
			return '';
		}
		if ( strlen( $html ) > self::MAX_BODY ) {
			$html = substr( $html, 0, self::MAX_BODY );
		}

		$out    = '';
		$offset = 0;
		$length = strlen( $html );

		while ( $offset < $length && preg_match( '/<\s*(link|meta|script)\b([^>]*?)>/i', $html, $matches, PREG_OFFSET_CAPTURE, $offset ) ) {
			$tag     = strtolower( $matches[1][0] );
			$tag_end = $matches[0][1] + strlen( $matches[0][0] );
			$inner   = '';

			if ( 'script' === $tag ) {
				$close = stripos( $html, '</script>', $tag_end );
				if ( false === $close ) {
					break;
				}
				$inner  = substr( $html, $tag_end, $close - $tag_end );
				$offset = $close + strlen( '</script>' );
			} else {
				$offset = $tag_end;
			}

			$piece = self::sanitize_head_tag( $tag, self::parse_attrs( $matches[2][0] ), $inner );
			if ( '' !== $piece ) {
				$out .= $piece;
			}
			if ( strlen( $out ) > self::MAX_BODY ) {
				break;
			}
		}

		return $out;
	}

	/**
	 * Rebuild one allowed head tag.
	 *
	 * @param string               $tag Tag name.
	 * @param array<string,string> $attrs Attributes.
	 * @param string               $inner Script body.
	 * @return string
	 */
	private static function sanitize_head_tag( $tag, $attrs, $inner ) {
		if ( 'link' === $tag ) {
			$rel  = isset( $attrs['rel'] ) ? strtolower( $attrs['rel'] ) : '';
			$href = isset( $attrs['href'] ) ? $attrs['href'] : '';
			if ( 'canonical' !== $rel || ! self::is_safe_href( $href ) ) {
				return '';
			}
			return '<link rel="canonical" href="' . esc_url( $href ) . '">';
		}

		if ( 'meta' === $tag ) {
			$name     = isset( $attrs['name'] ) ? strtolower( $attrs['name'] ) : '';
			$property = isset( $attrs['property'] ) ? strtolower( $attrs['property'] ) : '';
			$content  = isset( $attrs['content'] ) ? self::plain_text( $attrs['content'], 2000 ) : '';
			if ( '' === $content ) {
				return '';
			}

			if ( 'robots' === $name ) {
				if ( ! preg_match( '/^(noindex|nofollow|index|follow|none|all)(,\s*(noindex|nofollow|index|follow|none|all))*$/', $content ) ) {
					return '';
				}
				return '<meta name="robots" content="' . esc_attr( $content ) . '">';
			}

			if ( 'description' === $name ) {
				return '<meta name="description" content="' . esc_attr( $content ) . '">';
			}

			if ( 0 === strpos( $name, 'twitter:' ) && preg_match( '/^twitter:[a-z0-9_:-]+$/', $name ) ) {
				return '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $content ) . '">';
			}

			if ( 0 === strpos( $property, 'og:' ) && preg_match( '/^og:[a-z0-9_:-]+$/', $property ) ) {
				return '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $content ) . '">';
			}

			return '';
		}

		if ( 'script' === $tag ) {
			$type = isset( $attrs['type'] ) ? strtolower( trim( $attrs['type'] ) ) : '';
			if ( 'application/ld+json' !== $type ) {
				return '';
			}
			$json = json_decode( $inner, true );
			if ( ! is_array( $json ) ) {
				return '';
			}
			return '<script type="application/ld+json">' . wp_json_encode( $json ) . '</script>';
		}

		return '';
	}

	/**
	 * Keep the crawler block: one heading, paragraphs, and a same-site wine list.
	 *
	 * @param string $html Raw list fragment.
	 * @return string
	 */
	private static function sanitize_list( $html ) {
		if ( '' === $html ) {
			return '';
		}

		$html = wp_kses(
			$html,
			array(
				'div' => array(
					'class' => true,
				),
				'h1'  => array(),
				'p'   => array(),
				'ul'  => array(
					'class' => true,
				),
				'li'  => array(),
				'a'   => array(
					'href' => true,
				),
			)
		);

		$cleaned_class = preg_replace_callback(
			'/ class=(["\'])(.*?)\1/i',
			static function ( $matches ) {
				return 'c7wp-seo-wines' === $matches[2] ? ' class="c7wp-seo-wines"' : '';
			},
			$html
		);
		if ( is_string( $cleaned_class ) ) {
			$html = $cleaned_class;
		}

		$clean = preg_replace_callback(
			'/href=(["\'])(.*?)\1/i',
			static function ( $matches ) {
				$href = html_entity_decode( $matches[2], ENT_QUOTES );
				if ( ! self::is_safe_href( $href ) ) {
					return 'href="#"';
				}
				return 'href="' . esc_url( $href ) . '"';
			},
			$html
		);

		return is_string( $clean ) ? $clean : '';
	}

	/**
	 * Relative path or same host as the site.
	 *
	 * @param string $href URL.
	 * @return bool
	 */
	private static function is_safe_href( $href ) {
		if ( '' === $href || '#' === $href[0] ) {
			return false;
		}
		if ( '/' === $href[0] ) {
			return ! isset( $href[1] ) || '/' !== $href[1];
		}

		$host = wp_parse_url( $href, PHP_URL_HOST );
		$home = wp_parse_url( home_url(), PHP_URL_HOST );
		return is_string( $host ) && is_string( $home ) && strtolower( $host ) === strtolower( $home );
	}

	/**
	 * Parse a tag's attributes. Event-handler attributes are dropped.
	 *
	 * @param string $raw Raw attribute string.
	 * @return array<string, string>
	 */
	private static function parse_attrs( $raw ) {
		$attrs = array();
		if ( ! preg_match_all( '/([a-zA-Z_:][-a-zA-Z0-9_:.]*)\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s"\'=<>`]+))/', $raw, $found, PREG_SET_ORDER ) ) {
			return $attrs;
		}

		foreach ( $found as $attr ) {
			$name = strtolower( $attr[1] );
			if ( 0 === strpos( $name, 'on' ) ) {
				continue;
			}
			$value = '' !== $attr[2] ? $attr[2] : ( '' !== $attr[3] ? $attr[3] : $attr[4] );
			$attrs[ $name ] = html_entity_decode( $value, ENT_QUOTES );
		}

		return $attrs;
	}

	/**
	 * Core also prints a robots tag. Remove it when the service sent one.
	 */
	private static function suppress_core_robots() {
		if ( self::head_contains( 'name="robots"' ) ) {
			remove_action( 'wp_head', 'wp_robots', 1 );
		}
	}
}
