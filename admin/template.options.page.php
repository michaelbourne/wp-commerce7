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
                            <svg width="124" height="16" viewBox="0 0 124 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.357148 13.0162L0.607148 12.7262C0.649225 12.6722 0.703073 12.6285 0.764592 12.5985C0.826111 12.5684 0.893678 12.5528 0.962148 12.5528C1.03062 12.5528 1.09818 12.5684 1.1597 12.5985C1.22122 12.6285 1.27507 12.6722 1.31715 12.7262C1.68307 13.1459 2.13503 13.4819 2.64233 13.7114C3.14962 13.9409 3.70036 14.0585 4.25715 14.0562C4.72518 14.0771 5.19254 14.0023 5.63074 13.8366C6.06894 13.6709 6.4688 13.4177 6.80594 13.0923C7.14307 12.767 7.41042 12.3765 7.59169 11.9445C7.77295 11.5125 7.86432 11.0481 7.86024 10.5796C7.85616 10.1111 7.75671 9.6484 7.56796 9.21962C7.3792 8.79084 7.10509 8.40499 6.76234 8.08561C6.41959 7.76623 6.01538 7.52 5.57436 7.36194C5.13334 7.20388 4.66474 7.13729 4.19715 7.16625C3.38543 7.18492 2.58996 7.3975 1.87715 7.78625C1.77656 7.84878 1.66305 7.88758 1.54522 7.89971C1.4274 7.91184 1.30837 7.89697 1.19715 7.85625H1.05715C0.93311 7.81728 0.826885 7.73564 0.757321 7.6258C0.687758 7.51597 0.659353 7.38504 0.677148 7.25625L1.35715 1.02625C1.35661 0.95783 1.37071 0.890089 1.39849 0.827565C1.42627 0.765041 1.4671 0.709179 1.51824 0.663724C1.56938 0.618269 1.62964 0.584271 1.69499 0.56401C1.76034 0.543749 1.82927 0.537693 1.89715 0.546247H7.89715C7.96737 0.538278 8.03848 0.546247 8.1052 0.569562C8.17191 0.592877 8.23251 0.630937 8.28249 0.680909C8.33246 0.730882 8.37052 0.791481 8.39383 0.858196C8.41715 0.924912 8.42512 0.996026 8.41715 1.06625V1.29625C8.42512 1.36647 8.41715 1.43758 8.39383 1.5043C8.37052 1.57101 8.33246 1.63161 8.28249 1.68158C8.23251 1.73156 8.17191 1.76962 8.1052 1.79293C8.03848 1.81625 7.96737 1.82422 7.89715 1.81625H2.65715L2.24715 5.58625C2.2182 5.86631 2.16805 6.14377 2.09715 6.41625C2.77796 6.04505 3.54172 5.85239 4.31715 5.85625C4.96111 5.82798 5.60415 5.92997 6.20776 6.15612C6.81136 6.38227 7.36312 6.72791 7.82997 7.17236C8.29682 7.6168 8.66917 8.1509 8.92471 8.74266C9.18025 9.33442 9.31373 9.97168 9.31715 10.6162C9.30943 11.2618 9.17342 11.8994 8.91705 12.4919C8.66067 13.0844 8.28904 13.6201 7.82378 14.0676C7.35851 14.5152 6.80889 14.8658 6.20689 15.0991C5.60489 15.3323 4.96252 15.4435 4.31715 15.4262C3.56792 15.4366 2.82485 15.2898 2.13587 14.9953C1.44689 14.7008 0.827323 14.265 0.317148 13.7162C0.270371 13.6694 0.234015 13.6132 0.210458 13.5514C0.186902 13.4895 0.176677 13.4234 0.180453 13.3573C0.184229 13.2912 0.201921 13.2267 0.232371 13.1679C0.262821 13.1091 0.305341 13.0574 0.357148 13.0162Z" fill="#ED1C24"/>
                                <path d="M16.5672 1.06608C16.5578 0.99732 16.5641 0.927335 16.5856 0.861361C16.6072 0.795388 16.6433 0.735135 16.6914 0.685115C16.7395 0.635096 16.7983 0.596606 16.8634 0.572527C16.9284 0.548448 16.9981 0.539405 17.0672 0.546075H23.7172C23.7842 0.544266 23.8508 0.556808 23.9126 0.582858C23.9743 0.608908 24.0298 0.647864 24.0752 0.697112C24.1207 0.746361 24.1551 0.804763 24.1761 0.8684C24.1972 0.932036 24.2044 0.999435 24.1972 1.06608V1.29608C24.2049 1.36537 24.1971 1.43552 24.1743 1.50143C24.1516 1.56733 24.1145 1.62735 24.0656 1.67713C24.0168 1.72691 23.9575 1.76521 23.8921 1.78924C23.8266 1.81327 23.7566 1.82244 23.6872 1.81608H17.9972V7.29608H22.8472C22.9144 7.28767 22.9827 7.2949 23.0467 7.31721C23.1107 7.33953 23.1686 7.37631 23.216 7.42471C23.2635 7.4731 23.2991 7.53179 23.3201 7.59621C23.3411 7.66063 23.347 7.72902 23.3372 7.79608V8.07608C23.3372 8.40608 23.1772 8.59608 22.8472 8.59608H17.9972V14.5961C18.0047 14.6645 17.9971 14.7337 17.9749 14.7988C17.9527 14.8639 17.9165 14.9234 17.8688 14.973C17.8211 15.0226 17.7631 15.0611 17.6989 15.0858C17.6347 15.1105 17.5658 15.1209 17.4972 15.1161H17.0672C16.9981 15.1227 16.9284 15.1137 16.8634 15.0896C16.7983 15.0655 16.7395 15.0271 16.6914 14.977C16.6433 14.927 16.6072 14.8668 16.5856 14.8008C16.5641 14.7348 16.5578 14.6648 16.5672 14.5961V1.06608Z" fill="#ED1C24"/>
                                <path d="M37.4371 0.296191C38.4199 0.279709 39.3958 0.462119 40.3062 0.832453C41.2166 1.20279 42.0428 1.7534 42.7349 2.45118C43.4271 3.14897 43.9711 3.97952 44.334 4.8929C44.697 5.80628 44.8716 6.78363 44.8471 7.76619C44.8471 9.73145 44.0665 11.6162 42.6768 13.0059C41.2872 14.3955 39.4024 15.1762 37.4371 15.1762C35.4719 15.1762 33.5871 14.3955 32.1975 13.0059C30.8078 11.6162 30.0271 9.73145 30.0271 7.76619C30.0042 6.784 30.1797 5.80728 30.5431 4.89453C30.9066 3.98179 31.4506 3.15181 32.1425 2.45431C32.8344 1.75681 33.66 1.20615 34.5697 0.83532C35.4795 0.46449 36.4548 0.281118 37.4371 0.296191ZM37.4371 14.0762C38.2451 14.0665 39.0428 13.8937 39.7823 13.5682C40.5219 13.2427 41.188 12.7712 41.7409 12.1819C42.2937 11.5926 42.7219 10.8977 42.9996 10.139C43.2773 9.38018 43.399 8.57312 43.3571 7.76619C43.3571 6.19611 42.7334 4.69033 41.6232 3.58012C40.513 2.4699 39.0072 1.84619 37.4371 1.84619C35.8671 1.84619 34.3613 2.4699 33.2511 3.58012C32.1409 4.69033 31.5171 6.19611 31.5171 7.76619C31.4753 8.57312 31.597 9.38018 31.8747 10.139C32.1524 10.8977 32.5806 11.5926 33.1334 12.1819C33.6863 12.7712 34.3524 13.2427 35.092 13.5682C35.8315 13.8937 36.6292 14.0665 37.4371 14.0762Z" fill="#ED1C24"/>
                                <path d="M52.0672 1.0661C52.0578 0.997347 52.0641 0.927362 52.0856 0.861388C52.1072 0.795414 52.1433 0.735162 52.1914 0.685142C52.2395 0.635123 52.2983 0.596632 52.3634 0.572554C52.4284 0.548475 52.4981 0.539432 52.5672 0.546102H56.4972C57.4175 0.476576 58.3415 0.620302 59.1972 0.966102C59.8784 1.29473 60.447 1.81769 60.8314 2.46903C61.2158 3.12037 61.3988 3.87093 61.3572 4.6261C61.4001 5.50337 61.1531 6.37038 60.6543 7.0933C60.1555 7.81623 59.4326 8.35487 58.5972 8.6261C58.7355 8.81157 58.8624 9.00526 58.9772 9.2061L61.8072 14.4961C61.9972 14.8461 61.8072 15.0961 61.4572 15.0961H60.9172C60.7939 15.103 60.6713 15.0735 60.5646 15.0113C60.4579 14.949 60.3719 14.8568 60.3172 14.7461L57.1972 9.0161H53.4972V14.6561C53.5047 14.7245 53.4971 14.7937 53.4749 14.8588C53.4527 14.924 53.4165 14.9834 53.3688 15.033C53.3211 15.0826 53.2631 15.1211 53.1989 15.1459C53.1347 15.1706 53.0658 15.1809 52.9972 15.1761H52.5672C52.4981 15.1828 52.4284 15.1737 52.3634 15.1497C52.2983 15.1256 52.2395 15.0871 52.1914 15.0371C52.1433 14.987 52.1072 14.9268 52.0856 14.8608C52.0641 14.7948 52.0578 14.7249 52.0672 14.6561V1.0661ZM56.9572 7.7261C57.3545 7.7392 57.7501 7.66754 58.1175 7.5159C58.485 7.36427 58.816 7.13612 59.0884 6.84664C59.3609 6.55717 59.5685 6.21299 59.6977 5.83702C59.8268 5.46105 59.8743 5.06189 59.8372 4.6661C59.8636 4.13472 59.7313 3.60751 59.457 3.15161C59.1828 2.69571 58.779 2.33176 58.2972 2.1061C57.6933 1.87032 57.0429 1.7779 56.3972 1.8361H53.4972V7.7261H56.9572Z" fill="#ED1C24"/>
                                <path d="M68.8172 1.06623C68.8058 0.997113 68.8106 0.926281 68.8314 0.859372C68.8521 0.792462 68.8882 0.731324 68.9368 0.680826C68.9853 0.630327 69.045 0.591863 69.1111 0.568495C69.1771 0.545128 69.2477 0.537503 69.3172 0.546228H76.4972C76.5674 0.538259 76.6385 0.546229 76.7052 0.569543C76.772 0.592858 76.8326 0.630918 76.8825 0.68089C76.9325 0.730863 76.9706 0.791462 76.9939 0.858177C77.0172 0.924893 77.0252 0.996007 77.0172 1.06623V1.29623C77.0252 1.36645 77.0172 1.43756 76.9939 1.50428C76.9706 1.57099 76.9325 1.63159 76.8825 1.68157C76.8326 1.73154 76.772 1.7696 76.7052 1.79291C76.6385 1.81623 76.5674 1.8242 76.4972 1.81623H70.2472V7.16623H75.2472C75.3163 7.15479 75.3871 7.15964 75.4541 7.1804C75.521 7.20116 75.5821 7.23725 75.6326 7.28581C75.6831 7.33437 75.7216 7.39404 75.7449 7.46009C75.7683 7.52613 75.7759 7.59672 75.7672 7.66623V7.93623C75.7752 8.00645 75.7672 8.07756 75.7439 8.14428C75.7206 8.21099 75.6825 8.27159 75.6325 8.32157C75.5826 8.37154 75.522 8.4096 75.4552 8.43291C75.3885 8.45623 75.3174 8.4642 75.2472 8.45623H70.2472V13.8862H76.8672C76.9374 13.8783 77.0085 13.8862 77.0753 13.9095C77.142 13.9329 77.2026 13.9709 77.2525 14.0209C77.3025 14.0709 77.3406 14.1315 77.3639 14.1982C77.3872 14.2649 77.3952 14.336 77.3872 14.4062V14.6562C77.3952 14.7264 77.3872 14.7976 77.3639 14.8643C77.3406 14.931 77.3025 14.9916 77.2525 15.0416C77.2026 15.0915 77.142 15.1296 77.0753 15.1529C77.0085 15.1762 76.9374 15.1842 76.8672 15.1762H69.3172C69.2477 15.185 69.1771 15.1773 69.1111 15.154C69.045 15.1306 68.9853 15.0921 68.9368 15.0416C68.8882 14.9911 68.8521 14.93 68.8314 14.8631C68.8106 14.7962 68.8058 14.7253 68.8172 14.6562V1.06623Z" fill="#ED1C24"/>
                                <path d="M83.5371 13.1561L83.7871 12.8461C83.8255 12.7881 83.8765 12.7395 83.9363 12.7041C83.9962 12.6687 84.0633 12.6472 84.1326 12.6415C84.2019 12.6357 84.2716 12.6457 84.3365 12.6708C84.4013 12.6958 84.4597 12.7352 84.5071 12.7861C85.4475 13.5769 86.6288 14.0247 87.8571 14.0561C89.5971 14.0561 90.8571 13.0561 90.8571 11.5561C90.8571 7.87608 83.6071 8.74608 83.6071 4.20608C83.6071 1.81608 85.6071 0.296084 88.1571 0.296084C89.4305 0.285973 90.6728 0.689534 91.6971 1.44608C91.7537 1.47923 91.8025 1.52408 91.8403 1.57763C91.8781 1.63118 91.9041 1.6922 91.9164 1.75659C91.9287 1.82098 91.9271 1.88726 91.9117 1.95099C91.8963 2.01471 91.8675 2.07441 91.8271 2.12608L91.6371 2.45608C91.6068 2.52065 91.5619 2.57729 91.5059 2.6215C91.4499 2.66572 91.3844 2.69631 91.3146 2.71086C91.2447 2.72541 91.1725 2.72352 91.1035 2.70534C91.0345 2.68715 90.9707 2.65317 90.9171 2.60608C90.1024 2.0128 89.1248 1.68462 88.1171 1.66608C86.4671 1.66608 85.1171 2.58608 85.1171 4.12608C85.1171 7.64608 92.3671 6.70608 92.3671 11.4061C92.3671 13.6561 90.7071 15.4061 87.9271 15.4061C86.3728 15.3947 84.8694 14.8512 83.6671 13.8661C83.6108 13.8289 83.5626 13.7808 83.5255 13.7246C83.4883 13.6683 83.4628 13.6051 83.4507 13.5388C83.4385 13.4725 83.4399 13.4044 83.4548 13.3386C83.4696 13.2728 83.4976 13.2108 83.5371 13.1561Z" fill="#ED1C24"/>
                                <path d="M102.747 1.83621H98.0471C97.975 1.84483 97.9019 1.83661 97.8334 1.8122C97.765 1.7878 97.7032 1.74786 97.6528 1.69554C97.6024 1.64322 97.5649 1.57993 97.543 1.51064C97.5212 1.44136 97.5158 1.36796 97.5271 1.29621V1.06621C97.5191 0.995989 97.5271 0.924875 97.5504 0.85816C97.5737 0.791444 97.6118 0.730845 97.6618 0.680873C97.7117 0.6309 97.7724 0.59284 97.8391 0.569526C97.9058 0.546211 97.9769 0.538242 98.0471 0.546211H108.897C108.967 0.538242 109.038 0.546211 109.105 0.569526C109.172 0.59284 109.232 0.6309 109.282 0.680873C109.332 0.730845 109.37 0.791444 109.394 0.85816C109.417 0.924875 109.425 0.995989 109.417 1.06621V1.29621C109.425 1.36643 109.417 1.43755 109.394 1.50426C109.37 1.57098 109.332 1.63158 109.282 1.68155C109.232 1.73152 109.172 1.76958 109.105 1.7929C109.038 1.81621 108.967 1.82418 108.897 1.81621H104.197V14.6562C104.206 14.725 104.2 14.795 104.179 14.8609C104.157 14.9269 104.121 14.9872 104.073 15.0372C104.025 15.0872 103.966 15.1257 103.901 15.1498C103.836 15.1738 103.766 15.1829 103.697 15.1762H103.287C103.217 15.1842 103.146 15.1762 103.079 15.1529C103.012 15.1296 102.952 15.0915 102.902 15.0415C102.852 14.9916 102.814 14.931 102.79 14.8643C102.767 14.7975 102.759 14.7264 102.767 14.6562L102.747 1.83621Z" fill="#ED1C24"/>
                                <path d="M114.837 13.1563L115.077 12.8463C115.117 12.7881 115.168 12.7395 115.229 12.704C115.29 12.6686 115.358 12.6472 115.428 12.6414C115.498 12.6357 115.568 12.6457 115.634 12.6708C115.7 12.6958 115.759 12.7353 115.807 12.7863C116.758 13.5856 117.955 14.034 119.197 14.0563C120.937 14.0563 122.197 13.0563 122.197 11.5563C122.197 7.87628 114.957 8.74628 114.957 4.20628C114.957 1.81628 116.957 0.296279 119.507 0.296279C120.78 0.287611 122.022 0.691026 123.047 1.44628C123.104 1.47942 123.152 1.52427 123.19 1.57783C123.228 1.63138 123.254 1.6924 123.266 1.75679C123.279 1.82118 123.277 1.88746 123.262 1.95119C123.246 2.01491 123.217 2.07461 123.177 2.12628L122.987 2.45628C122.957 2.52085 122.912 2.57748 122.856 2.6217C122.8 2.66592 122.734 2.69651 122.665 2.71106C122.595 2.72561 122.522 2.72372 122.453 2.70553C122.385 2.68735 122.321 2.65337 122.267 2.60628C121.452 2.013 120.475 1.68481 119.467 1.66628C117.807 1.66628 116.467 2.58628 116.467 4.12628C116.467 7.64628 123.707 6.70628 123.707 11.4063C123.707 13.6563 122.057 15.4063 119.277 15.4063C117.723 15.3949 116.219 14.8514 115.017 13.8663C114.957 13.8333 114.904 13.7882 114.862 13.7339C114.82 13.6796 114.789 13.6171 114.772 13.5505C114.756 13.4839 114.753 13.4145 114.764 13.3466C114.775 13.2788 114.8 13.214 114.837 13.1563Z" fill="#ED1C24"/>
                            </svg>


                            <h2>Wasting money sucks.</h2>
                            <p>Do your wine marketing decisions feel like expensive guesswork? Without a clear understanding of your customers, messaging, and goals, you might be leaving success or failure to chance.</p>
                            <p>5forests workshops are built to guide you through the challenges facing today’s crowded wine market and provide the insights that simplify your day-to-day wine marketing decisions.</p>
                            <a href="http://bit.ly/2tVFfuV" target="_blank" style="display: block; color:#fff; background: #F60003; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Find Out More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box">
                        <div class="c7wp-box-content ">
                            <h2>Using Facebook?</h2>
                            <p>Facebook and Instagram advertising has proven very effective for many wineries. But not being able to properly track all your website and tasting room conversions limits your ability to generate effective lookalike audiences and stops you from reporting accurate ROI on your efforts.</p>
                            <p>5forests has teamed up with Treefrog Digital to launch our new <strong>Facebook Conversion Track</strong> app to overcome those obstacles.</p>
                            <a href="https://commerce7.treefrogdigital.com/facebook-conversion-tracking/" target="_blank" style="display: block; color:#fff; background: #4267B2; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c7wp-row">
                <div class="c7wp-column">
                    <div class="c7wp-box">
                        <div class="c7wp-box-content ">
                            <h2>Looking for the very best?</h2>
                            <p>5forests has stepped up the Commerce7 web design world with an all new, fully integrated solution for our clients.</p>
                            <p>With unmatched SEO, accessibility, and user experience enhancements, our Commerce7 websites stand out above the rest.</p>
                            <a href="https://5forests.com/services/commerce7-websites/" target="_blank" style="display: block; color:#fff; background: #333; text-align: center; padding: 1em; font-weight: bold; text-decoration: none; margin-top: 3em;">Tell me more!</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c7wp-cta">
                <p class="c7wp-cta-note">Plugin created by URSA6 and 5FORESTS and is provided free to Commerce7 customers and WordPress Users.</p>
                <hr class="c7wp-cta-spacing">
                <p class="c7wp-cta-note">We recommend <a href="https://kinsta.com/?kaid=PBYVIJQKUDTT" tagret="_blank">Kinsta</a> managed hosting to our WordPress clients.</p>
            </div>
        </div>



    </div>
</div>
