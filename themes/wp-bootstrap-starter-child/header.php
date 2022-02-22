<?php
/**
 * Customized header for our child theme
 *
 * This is a customized version of header.php from the wp-bootstrap-starter
 * theme, used by our wp-bootrap-starter-child theme.
 *
 * Here is the commit point that the starting header.php it is taken from:
 * a08665a8fe6b828db553885f5ebdb960bae4b37c
 *
 * In this repository:
 * https://github.com/afterimagedesigns/wp-bootstrap-starter
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
<!-- wp_head -->
<?php wp_head(); ?>
<!-- /wp_head -->
  </head>
  <body <?php body_class(); ?>>
<?php
  // WordPress 5.2 wp_body_open implementation
  if (function_exists('wp_body_open')) {
    wp_body_open();
  } else {
    do_action('wp_body_open');
  }
?>
    <div id="page" class="site">
      <a class="skip-link screen-reader-text" href="#content">
        <?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?>
      </a>
<?php if (
  !is_page_template('blank-page.php') &&
  !is_page_template('blank-page-with-container.php')
): ?>
    <div>
      <header id="masthead" role="banner"
      class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>">
        <div class="container">
          <nav class="navbar navbar-expand-lg p-0">
            <div class="navbar-brand">
<?php if ( get_theme_mod('wp_bootstrap_starter_logo') ): ?>
              <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url(get_theme_mod('wp_bootstrap_starter_logo')); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
              </a>
<?php else : ?>
              <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>">
                <?php esc_url(bloginfo('name')); ?>
              </a>
<?php endif; ?>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <?php
              wp_nav_menu(array(
                'theme_location'  => 'primary',
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
    </div>
<?php if(is_front_page()): ?>
    <div class="container-fluid pl-0 pr-0 mb-1 pb-0">
      <!-- homepageCarousel -->
      <div id="homepageCarousel" class="carousel slide" data-ride="carousel"
      data-interval="10000">
        <div class="carousel-inner">
          <!-- The FoBV Carousel Item -->
          <div class="carousel-item active">
            <img class="d-block w-100" alt="The FoBV"
            src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-1.jpg">
            <div class="carousel-caption d-block">
              <p>
                <a href="<?php echo get_page_link(FOBV_THE_FOBV_PAGE_ID); ?>">
                  Become a Friend of Bennerley Viaduct
                </a>
              </p>
            </div>
          </div>
          <!-- /The FoBV Carousel Item -->
          <!-- Bennerley Viaduct Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" alt="Bennerley Viaduct"
            src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-2.png">
            <div class="carousel-caption d-block">
              <p>
                <a href="<?php echo get_page_link(FOBV_THE_VIADUCT_PAGE_ID); ?>">
                  Find out how and why to visit Bennerley Viaduct
                </a>
              </p>
            </div>
          </div>
          <!-- /Bennerley Viaduct Carousel Item -->
          <!-- Our Project Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" alt="Our Project"
            src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-3.png">
            <div class="carousel-caption d-block">
              <p>
                <a href="<?php echo get_page_link(FOBV_THE_PROJECT_PAGE_ID); ?>">
                  Learn about Our Project to save the &quot;Iron Giant&quot
                </a>
              </p>
            </div>
          </div>
          <!-- /Our Project Carousel Item -->
          <!-- The FoBV Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" alt="The FoBV"
            src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-4.png">
            <div class="carousel-caption d-block">
              <p>
                <a href="<?php echo get_page_link(FOBV_THE_FOBV_PAGE_ID); ?>">
                  Become a Friend of Bennerley Viaduct
                </a>
              </p>
            </div>
          </div>
          <!-- /The FoBV Carousel Item -->
          <!-- Bennerley Viaduct Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" alt="Bennerley Viaduct"
            src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-5.png">
            <div class="carousel-caption d-block">
              <p>
                <a href="<?php echo get_page_link(FOBV_THE_VIADUCT_PAGE_ID); ?>">
                  Find out how and why to visit Bennerley Viaduct
                </a>
              </p>
            </div>
          </div>
          <!-- /Bennerley Viaduct Carousel Item -->
          <!-- Our Project Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" alt="Our Project"
            src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/viaduct-panorama-6.png">
            <div class="carousel-caption d-block">
              <p>
                <a href="<?php echo get_page_link(FOBV_THE_PROJECT_PAGE_ID); ?>">
                  Learn about Our Project to save the &quot;Iron Giant&quot
                </a>
              </p>
            </div>
          </div>
          <!-- /Our Project Carousel Item -->
        </div>
		      <div class="d-none d-sm-block">
            <a class="carousel-control-prev" href="#homepageCarousel"
            role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#homepageCarousel"
            role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
		      </div>
        </div>
      </div>
      <!-- /homepageCarousel -->
      <div class="pb-1 pt-4" id="page-sub-header" <?php if(has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
        <div class="container">
          <h1>
            <?php
            if (get_theme_mod('header_banner_title_setting')) {
              echo esc_attr(get_theme_mod('header_banner_title_setting'));
            } else {
              echo 'WordPress + Bootstrap';
            }
            ?>

          </h1>
        </div>
      </div>
      <div id="content" class="site-content mt-0 pt-0">
<?php else: # not the front page ?>
      <div class="container-fluid text-center bg-light d-none d-md-block">
        <a class="btn btn-outline-primary btn-sm mr-5"
        href="<?php echo get_page_link(FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID); ?>">
          Become a Friend of Bennerley Viaduct
        </a>
        <a class="btn btn-outline-primary btn-sm"
        href="<?php echo get_page_link(FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID); ?>">
          Donate to Our Project
        </a>
        <a class="btn btn-outline-primary btn-sm ml-5"
        href="<?php echo get_page_link(FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID); ?>">
          Subscribe to Our Mailing List
        </a>
      </div>
      <div class="container-fluid text-center bg-light d-block d-md-none">
        <a class="btn btn-outline-primary btn-sm mr-3"
        href="<?php echo get_page_link(FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID); ?>">
          Become a Friend
        </a>
        <a class="btn btn-outline-primary btn-sm"
        href="<?php echo get_page_link(FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID); ?>">
          Donate
        </a>
        <a class="btn btn-outline-primary btn-sm ml-3" href="<?php echo get_page_link(FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID); ?>">
          Subscribe
        </a>
      </div>
      <div id="content" class="site-content">
<?php endif; # end... if front page... else... ?>
		    <div class="container">
			    <div class="row">
<?php endif; ?>
