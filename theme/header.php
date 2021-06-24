<?php
/**
 * Customized header for our child theme
 *
 * This is a customized version of header.php from the wp-bootstrap-starter
 * theme, used by our wp-bootrap-starter-child theme.
 *
 * Relative to the parent theme's header.php, the customisations are as follows:
 * - Removed check on theme mod header_banner_visibility for display of the
 *   page-sub-header, we always display the header.
 * - Replaced tagline display in page-sub-header with a customer lead paragraph
 *   to put top level menu options in context followed by a paragraph that
 *   summarises the calls to action.
 * - Removed captions from carousel display and moved carousel further down the
 *   page.
 * - Removed call to action buttons from the main navbar and made them display
 *   in a container near the top of all pages except the home page.
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>

<?php

    // WordPress 5.2 wp_body_open implementation
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }

?>

    <div id="page" class="site">
      <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>

<?php if (
  !is_page_template('blank-page.php') &&
  !is_page_template('blank-page-with-container.php')
): ?>

<?php if(is_front_page()): ?>
      <div class="min-vh-100">
<?php endif; ?>

      <header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div class="container">
          <nav class="navbar navbar-expand-lg p-0">
            <div class="navbar-brand">

<?php if ( get_theme_mod('wp_bootstrap_starter_logo') ): ?>

              <a href="<?php echo esc_url( home_url( '/' )); ?>">
                <img src="<?php echo esc_url(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
              </a>

<?php else : ?>

              <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>

<?php endif; ?>

            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <?php
            wp_nav_menu(array(
            'theme_location'    => 'primary',
            'container'       => 'div',
            'container_id'    => 'main-nav',
            'container_class' => 'collapse navbar-collapse justify-content-end',
            'menu_id'         => false,
            'menu_class'      => 'navbar-nav',
            'depth'           => 3,
            'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
            'walker'          => new wp_bootstrap_navwalker()
            ));
            ?>

          </nav>
        </div>
      </header><!-- #masthead -->

<?php if(is_front_page()): ?>

      <div class="pb-1 pt-4" id="page-sub-header" <?php if(has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
            <div class="container">
                <h1>
                    <?php
                    if(get_theme_mod( 'header_banner_title_setting' )){
                        echo esc_attr( get_theme_mod( 'header_banner_title_setting' ) );
                    }else{
                        echo 'WordPress + Bootstrap';
                    }
                    ?>
                </h1>
                <p class="text-justify">
                  The Friends of Bennerley Viaduct (<a href="<?php echo get_page_link ( FOBV_THE_FOBV_PAGE_ID ) ; ?>">The FoBV</a>) are dedicated to restoring, conserving and celebrating <a href="<?php echo get_page_link ( FOBV_THE_VIADUCT_PAGE_ID ) ; ?>">Bennerley Viaduct</a>. In 2021 <a href="<?php echo get_page_link ( FOBV_THE_PROJECT_PAGE_ID) ; ?>">Our Project</a> goal is to re-open Bennerley Viaduct to the public after 50 years of closure. Please support us by <a href="<?php echo get_page_link ( FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID ) ; ?>">becoming a Friend of Bennerley Viaduct</a> or by <a href="<?php echo get_page_link ( FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID ) ; ?>">donating to Our Project</a> or by selecting us in <a href="<?php echo get_page_link ( FOBV_DONATE_VIA_AMAZON_SMILE_PAGE_ID ) ; ?>">Amazon Smile</a> as your favourite charity. <a href="<?php echo get_page_link ( FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID ) ; ?>">Subscribe to our email bulletin</a> to be kept up to date with our latest news.
                </p>
                <a href="#homepageCarousel" class="page-scroller"><i class="fa fa-fw fa-angle-down"></i></a>
            </div>
      </div>

      </div>

        <div class="container-fluid pl-0 pr-0 mb-1 pb-0">
          <div id="homepageCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner">

              <!-- The FoBV Carousel Item -->
              <div class="carousel-item active">
                <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-1.jpg" alt="The FoBV">
                <div class="carousel-caption d-none d-md-block">
                  <p><a href="<?php echo get_page_link ( FOBV_THE_FOBV_PAGE_ID ) ; ?>">
                    Become a Friend of Bennerley Viaduct
                  </a></p>
                </div>
              </div>
              <!-- /The FoBV Carousel Item -->

              <!-- Bennerley Viaduct Carousel Item -->
              <div class="carousel-item">
                <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-2.png" alt="Bennerley Viaduct">
                <div class="carousel-caption d-none d-md-block">
                  <p><a href="<?php echo get_page_link ( FOBV_THE_VIADUCT_PAGE_ID ) ; ?>">
                    Find out how and why to visit Bennerley Viaduct
                  </a></p>
                </div>
              </div>
              <!-- /Bennerley Viaduct Carousel Item -->

              <!-- Our Project Carousel Item -->
              <div class="carousel-item">
                <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-3.png" alt="Our Project">
                <div class="carousel-caption d-none d-md-block">
                  <p><a href="<?php echo get_page_link ( FOBV_THE_PROJECT_PAGE_ID) ; ?>">
                    Learn about Our Project to save the &quot;Iron Giant&quot
                  </a></p>
                </div>
              </div>
              <!-- /Our Project Carousel Item -->

              <!-- The FoBV Carousel Item -->
              <div class="carousel-item">
                <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-4.png" alt="The FoBV">
                <div class="carousel-caption d-none d-md-block">
                  <p><a href="<?php echo get_page_link ( FOBV_THE_FOBV_PAGE_ID ) ; ?>">
                    Become a Friend of Bennerley Viaduct
                  </a></p>
                </div>
              </div>
              <!-- /The FoBV Carousel Item -->

              <!-- Bennerley Viaduct Carousel Item -->
              <div class="carousel-item">
                <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-5.png" alt="Bennerley Viaduct">
                <div class="carousel-caption d-none d-md-block">
                  <p><a href="<?php echo get_page_link ( FOBV_THE_VIADUCT_PAGE_ID ) ; ?>">
                    Find out how and why to visit Bennerley Viaduct
                  </a></p>
                </div>
              </div>
              <!-- /Bennerley Viaduct Carousel Item -->

              <!-- Our Project Carousel Item -->
              <div class="carousel-item">
                <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-6.png" alt="Our Project">
                <div class="carousel-caption d-none d-md-block">
                  <p><a href="<?php echo get_page_link ( FOBV_THE_PROJECT_PAGE_ID) ; ?>">
                    Learn about Our Project to save the &quot;Iron Giant&quot
                  </a></p>
                </div>
              </div>
              <!-- /Our Project Carousel Item -->

            </div>
            <a class="carousel-control-prev" href="#homepageCarousel" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#homepageCarousel" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
        <div id="content" class="site-content mt-0 pt-0">
<?php else: ?>
  <div class="container-fluid text-center bg-light d-none d-md-block">
    <a class="btn btn-outline-primary btn-sm mr-5" href="<?php echo get_page_link ( FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID ) ; ?>">
      Become a Friend of Bennerley Viaduct
    </a>
    <a class="btn btn-outline-primary btn-sm" href="<?php echo get_page_link ( FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID ) ; ?>">
      Donate to Our Project
    </a>
    <a class="btn btn-outline-primary btn-sm ml-5" href="<?php echo get_page_link ( FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID ) ; ?>">
      Subscribe to Our Mailing List
    </a>
  </div>
  <div class="container-fluid text-center bg-light d-block d-md-none">
    <a class="btn btn-outline-primary btn-sm mr-3" href="<?php echo get_page_link ( FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID ) ; ?>">
      Become a Friend
    </a>
    <a class="btn btn-outline-primary btn-sm" href="<?php echo get_page_link ( FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID ) ; ?>">
      Donate
    </a>
    <a class="btn btn-outline-primary btn-sm ml-3" href="<?php echo get_page_link ( FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID ) ; ?>">
      Subscribe
    </a>
  </div>
  <div id="content" class="site-content">

<?php endif; ?>
		<div class="container">
			<div class="row">
                <?php endif; ?>
