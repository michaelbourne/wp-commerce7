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

                    <div class="c7wp-box gradient header">

                        <div class="c7wp-box-content cols-2">
                            <div class="c7wp-box-content-left">
                                <h1 class="c7wp-box-title"><?php esc_html_e( 'Commerce7 for WordPress', 'wp-commerce7' ); ?></h1>
                                <p class="c7wp-box-content-text"><?php esc_html_e( 'Built for wineries that want more control, better performance, and smarter marketing.', 'wp-commerce7' ); ?></p>
                            </div>

                            <div class="c7wp-box-content-right">
                                <a href="https://c7wp.com/documentation/" target="_blank" class="c7wp-btn c7wp-btn-primary c7wp-btn-large">
                                    <svg width="800px" height="800px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm23.744 191.488c-52.096 0-92.928 14.784-123.2 44.352-30.976 29.568-45.76 70.4-45.76 122.496h80.256c0-29.568 5.632-52.8 17.6-68.992 13.376-19.712 35.2-28.864 66.176-28.864 23.936 0 42.944 6.336 56.32 19.712 12.672 13.376 19.712 31.68 19.712 54.912 0 17.6-6.336 34.496-19.008 49.984l-8.448 9.856c-45.76 40.832-73.216 70.4-82.368 89.408-9.856 19.008-14.08 42.24-14.08 68.992v9.856h80.96v-9.856c0-16.896 3.52-31.68 10.56-45.76 6.336-12.672 15.488-24.64 28.16-35.2 33.792-29.568 54.208-48.576 60.544-55.616 16.896-22.528 26.048-51.392 26.048-86.592 0-42.944-14.08-76.736-42.24-101.376-28.16-25.344-65.472-37.312-111.232-37.312zm-12.672 406.208a54.272 54.272 0 0 0-38.72 14.784 49.408 49.408 0 0 0-15.488 38.016c0 15.488 4.928 28.16 15.488 38.016A54.848 54.848 0 0 0 523.072 768c15.488 0 28.16-4.928 38.72-14.784a51.52 51.52 0 0 0 16.192-38.72 51.968 51.968 0 0 0-15.488-38.016 55.936 55.936 0 0 0-39.424-14.784z"/></svg>
                                    <?php esc_html_e( 'Documentation', 'wp-commerce7' ); ?>
                                </a>
                            </div>

                        </div>

                    </div>

                    <div class="c7wp-box">

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
                <p class="c7wp-cta-note">Plugin created by URSA6 & 5forests. Provided free to Commerce7 customers and agencies around the world.</p>
                <hr class="c7wp-cta-spacing">
                <p class="c7wp-cta-note">We offer unbeatable <a href="https://5forests.com/services/technology/website-care-plans/" target="_blank">sustainble hosting and care plans</a> to our WordPress clients.</p>
            </div>
        </div>



    </div>
</div>
