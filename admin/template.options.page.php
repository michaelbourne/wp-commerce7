<?php
/**
 * Options Page
 *
 * @package   wp-commerce7
 * @author    Michael Bourne
 * @license   GPL3
 * @link      https://ursa6.com
 * @since     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    return;
}


?>
<div class="c7wp-reset c7wp-wrap c7wp-wrap-about">
    <div class="c7wp-content">
        <div class="c7wp-main">

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box">

                        <img src="<?php echo esc_url( C7WP_URI . 'assets/heroheader2023.jpg' ); ?>" alt="Commerce7 for WordPress" style="max-width: 100%;" />

                        <div class="c7wp-box-content">
                            <form method="post" action="options.php">
                                <?php
                                settings_fields( 'commerce7' );
                                do_settings_sections( 'commerce7' );
                                submit_button();
                                ?>
                            </form>
                        </div>


                    </div>
                </div>
            </div>


            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box c7wp-box-min-height">

                        <header class="c7wp-box-header">
                            <h2 class="c7wp-box-title"><?php esc_html_e( 'Settings Instructions', 'wp-commerce7' ); ?></h2>
                        </header>


                        <div class="c7wp-box-content">
                            <ul class="c7wp-box-features">
                                <li>
                                    <div class="c7wp-box-feature-icon">
                                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAyODYuMDU0IDI4Ni4wNTQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI4Ni4wNTQgMjg2LjA1NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzOTRCQzsiIGQ9Ik0xNDMuMDI3LDBDNjQuMDMxLDAsMCw2NC4wNCwwLDE0My4wMjdjMCw3OC45OTYsNjQuMDMxLDE0My4wMjcsMTQzLjAyNywxNDMuMDI3ICAgczE0My4wMjctNjQuMDMxLDE0My4wMjctMTQzLjAyN0MyODYuMDU0LDY0LjA0LDIyMi4wMjIsMCwxNDMuMDI3LDB6IE0xNDMuMDI3LDI1OS4yMzZjLTY0LjE4MywwLTExNi4yMDktNTIuMDI2LTExNi4yMDktMTE2LjIwOSAgIFM3OC44NDQsMjYuODE4LDE0My4wMjcsMjYuODE4czExNi4yMDksNTIuMDI2LDExNi4yMDksMTE2LjIwOVMyMDcuMjEsMjU5LjIzNiwxNDMuMDI3LDI1OS4yMzZ6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojMjM5NEJDOyIgZD0iTTE1MC4wMjYsODAuMzloLTIyLjg0Yy02LjkxLDAtMTAuOTMzLDcuMDQ0LTEwLjkzMywxMy4xNThjMCw1LjkzNiwzLjIwOSwxMy4xNTgsMTAuOTMzLDEzLjE1OCAgIGg3LjI1OXY4NS4zNmMwLDguNzM0LDYuMjU3LDEzLjYwNSwxMy4xNzYsMTMuNjA1czEzLjE4NS00Ljg4MSwxMy4xODUtMTMuNjA1VjkyLjc3MUMxNjAuNzk4LDg1Ljc4OSwxNTYuOTQ1LDgwLjM5LDE1MC4wMjYsODAuMzl6Ii8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                                    </div>
                                    <div class="c7wp-box-feature-info">
                                        <h4 class="c7wp-box-content-title"><?php esc_html_e( 'Add your Tenant ID', 'wp-commerce7' ); ?></h4>
                                        <span class="c7wp-box-content-text">
                                            <?php
                                            $tags = wp_kses_allowed_html();
                                            /* translators: Options page step 1. KSES set to a, br, strong, and em.  */
                                            echo sprintf(
                                                wp_kses(
                                                    __( 'Visit your <a href="%s" target="_blank">Commerce7 Dashboard</a>. After logging in, you will find your Tenant ID under <strong>Settings > General</strong>, the General settings first line that says <code>Tenant</code>.', 'wp-commerce7' ),
                                                    $tags
                                                ),
                                                esc_url( 'https://admin.platform.commerce7.com/setting/general' )
                                            );
                                            ?>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="c7wp-box-feature-icon">
                                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAyODYuMDU0IDI4Ni4wNTQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI4Ni4wNTQgMjg2LjA1NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzOTRCQzsiIGQ9Ik0xNDMuMDI3LDBDNjQuMDMxLDAsMCw2NC4wNCwwLDE0My4wMjdjMCw3OC45OTYsNjQuMDMxLDE0My4wMjcsMTQzLjAyNywxNDMuMDI3ICAgczE0My4wMjctNjQuMDMxLDE0My4wMjctMTQzLjAyN0MyODYuMDU0LDY0LjA0LDIyMi4wMjIsMCwxNDMuMDI3LDB6IE0xNDMuMDI3LDI1OS4yMzZjLTY0LjE4MywwLTExNi4yMDktNTIuMDI2LTExNi4yMDktMTE2LjIwOSAgIFM3OC44NDQsMjYuODE4LDE0My4wMjcsMjYuODE4czExNi4yMDksNTIuMDI2LDExNi4yMDksMTE2LjIwOVMyMDcuMjEsMjU5LjIzNiwxNDMuMDI3LDI1OS4yMzZ6IE0xNzMuMjMyLDE4MC4yMDVoLTMyLjAzOCAgIGMxNS42NjEtMTguNDU5LDQwLjg1Mi0zOS43NTMsNDAuODUyLTYzLjczNmMwLTIxLjkxLTE2LjU2NC0zNS44ODItMzkuMjE2LTM1Ljg4MmMtMjIuNjYxLDAtNDMuODQ3LDE3Ljk3Ny00My44NDcsMzkuNzE3ICAgYzAsNi43MzEsNC42MDQsMTIuNTg2LDEzLjQ0NSwxMi41ODZjMTcuNjkxLDAsOC4xMDgtMjguNDk4LDI5LjI5NC0yOC40OThjNy41NTQsMCwxMy4yNjYsNi4yMDQsMTMuMjY2LDEzLjI4NCAgIGMwLDYuMjA0LTMuMTM4LDExLjU1OC02LjQ1NCwxNi4wNDZjLTEzLjk5OSwxOC45NjktMzAuNTgxLDM0LjQ5Ni00NS44NjcsNTEuNTc5Yy0xLjg0MSwyLjA2NS00LjI0Niw1LjE3Ni00LjI0Niw4Ljc5NiAgIGMwLDcuOTM4LDYuMjY2LDExLjM4LDE0LjM2NSwxMS4zOGg2MS41MjhjNi45OTksMCwxMy4yNjYtNC41NjgsMTMuMjY2LTEyLjQ5N0MxODcuNTgsMTg1LjA1LDE4MS4zMzEsMTgwLjIwNSwxNzMuMjMyLDE4MC4yMDV6Ii8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                                    </div>
                                    <div class="c7wp-box-feature-info">
                                        <h4 class="c7wp-box-content-title"><?php esc_html_e( 'Choose whether or not to enable the Cart Box', 'wp-commerce7' ); ?></h4>
                                        <span class="c7wp-box-content-text">
                                            <?php
                                            /* translators: Options page step 2.  */
                                            esc_html_e( 'The Cart Box will contain a magic login/logut link, as well as the cart totals and a link for the flyout shopping cart. It is often preferrable to include this in your theme manually. You should disable it here if you would prefer to place the login/logout link and cart link in your header with the shortcodes below. The Cart Box can be positioned to any corner of the screen to accomodate different design layouts. Try all of them to find your preferred placement.', 'wp-commerce7' );
                                            ?>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="c7wp-box-feature-icon">
                                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAyODYuMDU0IDI4Ni4wNTQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI4Ni4wNTQgMjg2LjA1NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzOTRCQzsiIGQ9Ik0xNDMuMDI3LDBDNjQuMDQsMCwwLDY0LjA0LDAsMTQzLjAyN2MwLDc4Ljk5Niw2NC4wNCwxNDMuMDI3LDE0My4wMjcsMTQzLjAyNyAgIHMxNDMuMDI3LTY0LjAzMSwxNDMuMDI3LTE0My4wMjdDMjg2LjA1NCw2NC4wNCwyMjIuMDE0LDAsMTQzLjAyNywweiBNMTQzLjAyNywyNTkuMjM2Yy02NC4xODMsMC0xMTYuMjA5LTUyLjAyNi0xMTYuMjA5LTExNi4yMDkgICBTNzguODQ0LDI2LjgxOCwxNDMuMDI3LDI2LjgxOHMxMTYuMjA5LDUyLjAyNiwxMTYuMjA5LDExNi4yMDlTMjA3LjIxLDI1OS4yMzYsMTQzLjAyNywyNTkuMjM2eiBNMTY3LjcxNywxMzcuNjM3ICAgYzguOTY2LTUuOTM2LDEzLjM2NC0xNS4yNzcsMTMuMzY0LTI1Ljk3N2MwLTEzLjIzOS0xMS4yNTQtMzEuMDgyLTM0LjcyOS0zMS4wODJjLTE4LjA5MywwLTM1LjU0MiwxNC4yNzYtMzUuNTQyLDI3LjUxNSAgIGMwLDYuMjg0LDMuOTE1LDEyLjU2LDEwLjYwMiwxMi41NmMxMS4wODUsMCw4Ljk2Ni0xNi42MzYsMjQuNDQ5LTE2LjYzNmM3LjMzOSwwLDExLjczNyw0LjkyNSwxMS43MzcsMTEuMzcxICAgYzAsMTguODUzLTIzLjE1Miw2Ljc5NC0yMy4xNTIsMjQuNjI3YzAsMjAuMDMzLDI3LjcyLDIuNTQ4LDI3LjcyLDI2LjMxN2MwLDkuMDAyLTYuODU2LDE1Ljc5Ni0xNS4zMzEsMTUuNzk2ICAgYy0xOC40MjQsMC0xNS44MTMtMTkuODcyLTI2Ljg5OC0xOS44NzJjLTUuODczLDAtMTIuNTUxLDQuNzU2LTEyLjU1MSwxMS4zOGMwLDEzLjQxOCwxNSwzMS45MjIsMzkuMTI3LDMxLjkyMiAgIGMyMy4xNTIsMCw0MS4wODQtMTcuMTU0LDQxLjA4NC0zNy41MjdDMTg3LjU5OCwxNTQuNjIxLDE3OS40NDUsMTQzLjI1LDE2Ny43MTcsMTM3LjYzN3oiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                    </div>
                                    <div class="c7wp-box-feature-info">
                                        <h4 class="c7wp-box-content-title"><?php esc_html_e( 'Choose your front-end widgets version.', 'wp-commerce7' ); ?></h4>
                                        <span class="c7wp-box-content-text">
                                            <?php
                                            /* translators: Options page step 3.   */
                                            esc_html_e( 'The V2 front-end widgets launched officially on September 1, 2021, and are the default for all new tenants. V1 (also known as Beta) will be sunset in the near future; if you are still on V1, make a plan to migrate as soon as possible.', 'wp-commerce7' );
                                            ?>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box c7wp-box-min-height">

                        <header class="c7wp-box-header">
                            <h2 class="c7wp-box-title"><?php esc_html_e( 'Need a hand?', 'wp-commerce7' ); ?></h2>
                        </header>

                        <div class="c7wp-box-content ">
                            <p>Be sure to read the documentation first, as it covers everything from installation, to setup, and use of the plugins features.</p>
                            <p>If you are looking for a professional agency to hire for your website build, contact us at 5forests for a consultation.</p>
                            <a href="https://c7wp.com/" target="_blank" style="display: block; color:#fff; background: #333; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Read the Docs</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="c7wp-sidebar">

            <?php

                /**
                 * Filter: `c7wp_show_sidebar`
                 *
                 * Filter for hiding the sidebar in our plugin settings, which might include promotions for
                 * our services. This is a whitelabel as you're going to get.
                 *
                 * @param bool Should the sidebar be shown? Default: true
                 */
                if ( apply_filters( 'c7wp_show_sidebar', true ) ) :

                $gists = [
                    '95be9529b9ba6f9cc96336e085a4b122',
                    '902913bb4b5623f945c9ebe30dfbc0b6',
                    'fb980c8d769a96f169250a79ca278f74',
                ];

                $allowed_html = wp_kses_allowed_html( 'post' );
                $allowed_protocols = [
                    'https',
                    'data',
                ];

                $args = [
                    'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
                ];

                foreach ( $gists as $gist ) {
                    $callout = get_transient( 'c7wp_' . $gist );

                    if ( empty( $callout ) ) {
                        $response = wp_remote_get( 'https://api.github.com/gists/' . $gist, $args );

                        if ( is_array( $response ) && ! is_wp_error( $response ) && '200' == wp_remote_retrieve_response_code( $response ) ) {
                            $headers = $response['headers']; // array of http header lines
                            $body    = json_decode( $response['body'], true ); // use the content

                            $callout = stripslashes( $body['files']['index.html']['content'] );

                            $trans = set_transient( 'c7wp_' . $gist, $callout, WEEK_IN_SECONDS );
                        } else {
                            continue;
                        }
                    }

                    echo wp_kses( $callout, $allowed_html, $allowed_protocols );
                }

                endif;
            ?>

            <div class="c7wp-cta">
                <p class="c7wp-cta-note">Plugin created by URSA6 & 5forests. Provided free to Commerce7 customers and agencies.</p>
                <hr class="c7wp-cta-spacing">
                <p class="c7wp-cta-note">We offer unbeatable<a href="https://5forests.com/services/technology/website-care-plans/" target="_blank">sustainble hosting and care plans</a> to our WordPress clients.</p>
            </div>
        </div>



    </div>
</div>
