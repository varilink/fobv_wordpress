<?php
/**
 * Title: Page with a page menu
 * Slug: fobv/page-with-page-menu
 */
?>
<!-- wp:group {"lock":{"move":true,"remove":true},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">

    <!-- wp:columns {"lock":{"move":true,"remove":true},"align":"wide"} -->
    <div class="wp-block-columns alignwide">

        <!-- wp:column {"width":"25%","templateLock":"all","lock":{"move":true,"remove":true}} -->
        <div class="wp-block-column" style="flex-basis:25%" id="fobv-page-top-link">

            <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"className":"fobv-page-menu","layout":{"type":"constrained"}} -->
            <div class="wp-block-group fobv-page-menu">

                <!-- wp:group {"className":"fobv-page-menu-header","layout":{"type":"default"}} -->
                <div class="wp-block-group fobv-page-menu-header">

                    <!-- wp:shortcode -->[fobv-page-top-link]<!-- /wp:shortcode -->

                </div>
                <!-- /wp:group -->

                <!-- wp:shortcode -->[fobv-page-navigation]<!-- /wp:shortcode -->

            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"75%","lock":{"move":true,"remove":true}} -->
        <div class="wp-block-column" style="flex-basis:75%" id="fobv-page-content">

            <!-- wp:paragraph -->
            <p>Replace with the page content.</p>
            <!-- /wp:paragraph -->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</div>
<!-- /wp:group -->
