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

                        <img src="<?php echo esc_url( C7WP_URI . '/assets/heroheader.png' ); ?>" alt="Commerce7 for WordPress" style="max-width: 100%;" />

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
                                        <h4 class="c7wp-box-content-title"><?php esc_html_e( 'Add your tenant ID', 'wp-commerce7' ); ?></h4>
                                        <span class="c7wp-box-content-text">
                                            <?php
                                            $tags = wp_kses_allowed_html();
                                            /* translators: Options page step 1. KSES set to a, br, strong, and em.  */
                                            echo sprintf(
                                                wp_kses(
                                                    __( 'Visit your <a href="%s" target="_blank">Commerce7 Dashboard</a>. After logging in, note the URL in your address bar. The first part of the url is your Tenant ID. <br>For example: <strong>https://crazy-wines.admin.platform.commerce7.com</strong> would mean <strong>crazy-wines</strong> is the Tenant ID. Type that ID in the setting above to enable the integration.', 'wp-commerce7' ),
                                                    $tags
                                                ),
                                                esc_url( 'https://admin.platform.commerce7.com/login' )
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
                                            esc_html_e( 'The Cart Box will contain a magic login/logut link, as well as the cart totals and a link for the flyout shopping cart. You should disable it here if you would prefer to place the login/logout link and cart link in your header with the shortcodes below.', 'wp-commerce7' );
                                            ?>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="c7wp-box-feature-icon">
                                        <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCAyODYuMDU0IDI4Ni4wNTQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI4Ni4wNTQgMjg2LjA1NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6IzIzOTRCQzsiIGQ9Ik0xNDMuMDI3LDBDNjQuMDQsMCwwLDY0LjA0LDAsMTQzLjAyN2MwLDc4Ljk5Niw2NC4wNCwxNDMuMDI3LDE0My4wMjcsMTQzLjAyNyAgIHMxNDMuMDI3LTY0LjAzMSwxNDMuMDI3LTE0My4wMjdDMjg2LjA1NCw2NC4wNCwyMjIuMDE0LDAsMTQzLjAyNywweiBNMTQzLjAyNywyNTkuMjM2Yy02NC4xODMsMC0xMTYuMjA5LTUyLjAyNi0xMTYuMjA5LTExNi4yMDkgICBTNzguODQ0LDI2LjgxOCwxNDMuMDI3LDI2LjgxOHMxMTYuMjA5LDUyLjAyNiwxMTYuMjA5LDExNi4yMDlTMjA3LjIxLDI1OS4yMzYsMTQzLjAyNywyNTkuMjM2eiBNMTY3LjcxNywxMzcuNjM3ICAgYzguOTY2LTUuOTM2LDEzLjM2NC0xNS4yNzcsMTMuMzY0LTI1Ljk3N2MwLTEzLjIzOS0xMS4yNTQtMzEuMDgyLTM0LjcyOS0zMS4wODJjLTE4LjA5MywwLTM1LjU0MiwxNC4yNzYtMzUuNTQyLDI3LjUxNSAgIGMwLDYuMjg0LDMuOTE1LDEyLjU2LDEwLjYwMiwxMi41NmMxMS4wODUsMCw4Ljk2Ni0xNi42MzYsMjQuNDQ5LTE2LjYzNmM3LjMzOSwwLDExLjczNyw0LjkyNSwxMS43MzcsMTEuMzcxICAgYzAsMTguODUzLTIzLjE1Miw2Ljc5NC0yMy4xNTIsMjQuNjI3YzAsMjAuMDMzLDI3LjcyLDIuNTQ4LDI3LjcyLDI2LjMxN2MwLDkuMDAyLTYuODU2LDE1Ljc5Ni0xNS4zMzEsMTUuNzk2ICAgYy0xOC40MjQsMC0xNS44MTMtMTkuODcyLTI2Ljg5OC0xOS44NzJjLTUuODczLDAtMTIuNTUxLDQuNzU2LTEyLjU1MSwxMS4zOGMwLDEzLjQxOCwxNSwzMS45MjIsMzkuMTI3LDMxLjkyMiAgIGMyMy4xNTIsMCw0MS4wODQtMTcuMTU0LDQxLjA4NC0zNy41MjdDMTg3LjU5OCwxNTQuNjIxLDE3OS40NDUsMTQzLjI1LDE2Ny43MTcsMTM3LjYzN3oiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
                                    </div>
                                    <div class="c7wp-box-feature-info">
                                        <h4 class="c7wp-box-content-title"><?php esc_html_e( 'Choose the position of your Cart Box', 'wp-commerce7' ); ?></h4>
                                        <span class="c7wp-box-content-text">
                                            <?php
                                            /* translators: Options page step 3.   */
                                            esc_html_e( 'The Cart Box can be positioned to any corner of the screen to accomodate different design layouts. Try all of them to find your preferred placement.', 'wp-commerce7' );
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
                            <p>If you are looking for a professional agency to hire for your website build, contact us at 5FORESTS for a consultation.</p>
                            <a href="https://c7wp.com/" target="_blank" style="display: block; color:#fff; background: #333; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Read the Docs</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="c7wp-sidebar">

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box">
                        <div class="c7wp-box-content ">
                            <img src="<?php echo esc_url( C7WP_URI . '/assets/5forests-logo-horizontal.png' ); ?>" alt="5forests" style="max-width: 100%;" />

                            <h2>Digital wine marketing has been too hard for too long.</h2>
                            <p>Ecommerce, social media, newsletters, digital advertising, analytics, SEO, data… there’s always something new to learn, when all you want to do is make great wine. That’s where 5forests comes in.</p>
                            <p>We work with wine businesses around the world to develop proﬁtable strategies and digital solutions to today’s wine environment. With an approach based in research, learning, and growth, we build wine businesses that are here for the long run.</p>
                            <a href="http://5f.re/FC74WP" target="_blank" style="display: block; color:#fff; background: #007291; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Get In Touch</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box">
                        <div class="c7wp-box-content ">
                            <img src="<?php echo esc_url( C7WP_URI . '/assets/fbct.png' ); ?>" alt="5forests" style="max-width: 100%;" />
                            <h2>Using Facebook?</h2>
                            <p>Facebook and Instagram advertising has proven very effective for many wineries. But not being able to properly track all your website and tasting room conversions limits your ability to generate effective lookalike audiences and stops you from reporting accurate ROI on your efforts.</p>
                            <p>5forests has teamed up with Treefrog Digital to launch our new <strong>Facebook Conversion Track</strong> app to overcome those obstacles. Install it directly from your Commerce7 account under <em>Apps</em>.</p>
                            <a href="https://commerce7.treefrogdigital.com/facebook-conversion-tracking/" target="_blank" style="display: block; color:#fff; background: #1778f2; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box">
                        <div class="c7wp-box-content ">
                            <img src="<?php echo esc_url( C7WP_URI . '/assets/5fpromo.jpg' ); ?>" alt="5forests" style="max-width: 100%;" />
                            <h2>Ready to take Commerce 7 to the next level?</h2>
                            <p>Our Enhanced Commerce7 for WordPress Plugin comes packed with features that will put your winery ahead of the competition.</p>
                            <p>With unmatched SEO, accessibility, and user experience enhancements, our Commerce7 websites stand out above the rest.</p>
                            <a href="https://5forests.com/services/commerce7-websites/" target="_blank" style="display: block; color:#fff; background: #333; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">See the Difference</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c7wp-cta">
                <p class="c7wp-cta-note">Plugin created by URSA6 and 5FORESTS and is provided free to Commerce7 customers and WordPress Users.</p>
                <hr class="c7wp-cta-spacing">
                <p class="c7wp-cta-note">We recommend <a href="https://kinsta.com/?kaid=PBYVIJQKUDTT" tagret="_blank">Kinsta</a> hosting to our WordPress clients.</p>
            </div>
        </div>



    </div>
</div>
