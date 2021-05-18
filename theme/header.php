<?php
    /**
    * Overrides header.php in the parent theme wp-bootstrap-starter.
    * The customisations in this child theme are all commented.
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
  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content">
      <?php
        esc_html_e ( 'Skip to content' , 'wp-bootstrap-starter' ) ;
        print "\n" ;
      ?>
    </a>
<?php
    if ( !is_page_template ( 'blank-page.php' ) &&
    !is_page_template ( 'blank-page-with-container.php' ) )
: ?>

    <!-- masthead -->
    <header id="masthead" class="site-header <?php echo wp_bootstrap_starter_bg_class ( ) ; ?>" role="banner">

      <nav class="navbar navbar-expand-lg p-0 navbar-light">

        <div class="navbar-brand text-center">
          <a href="<?php echo esc_url( home_url( '/' )); ?>">
            <img src="<?php echo esc_url ( get_theme_mod ( 'wp_bootstrap_starter_logo' ) ) ; ?>" alt="<?php echo esc_attr ( get_bloginfo ( 'name' ) ) ; ?>" width="125px">
          </a>
        </div>

        <!-- #main-nav -->
        <div id="main-nav" class="collapse navbar-collapse">
          <div class="container">
            <div class="row">
              <div class="col-sm">
              </div>
              <div class="col-sm-auto">
                <!-- start of menu items from navwalker -->
                <?php wp_nav_menu ( array (
                  'theme_location' => 'primary' ,
                  'container'      => false ,
                  'menu_id'        => false ,
                  'menu_class'     => 'navbar-nav' ,
                  'depth'          => 3 ,
                  'fallback_cb'    => 'wp_bootstrap_navwalker::fallback' ,
                  'walker'         => new wp_bootstrap_navwalker ( )
                ) ) ; ?>
                <!-- end of menu items from navwalker -->
              </div>
            </div>

            <div class="row">
              <div class="col-sm">
              </div>
              <div class="col-sm-auto">
                <form class="form-inline">

                  <div class="btn-group d-none d-lg-block" role="group">
                    <a class="btn btn-outline-secondary btn-sm" href="<?php echo get_page_link ( FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID ) ; ?>">
                      Donate to Our Cause
                    </a>
                    <a class="btn btn-outline-secondary btn-sm ml-3 mr-3" href="<?php echo get_page_link ( FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID ) ; ?>">
                      Join Us or Renew Your Membership
                    </a>
                    <a class="btn btn-outline-secondary btn-sm" href="<?php echo get_page_link ( FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID ) ; ?>">
                      Subscribe to Our Mailing List
                    </a>
                  </div>

                  <div class="btn-group-vertical d-lg-none" role="group">
                    <a class="btn btn-outline-secondary btn-sm" href="<?php echo get_page_link ( FOBV_DONATE_TO_OUR_CAUSE_PAGE_ID ) ; ?>">
                      Donate to Our Cause
                    </a>
                    <a class="btn btn-outline-secondary btn-sm mt-2 mb-2" href="<?php echo get_page_link ( FOBV_JOIN_US_OR_RENEW_YOUR_MEMBERSHIP_PAGE_ID ) ; ?>">
                      Join Us or Renew Your Membership
                    </a>
                    <a class="btn btn-outline-secondary btn-sm" href="<?php echo get_page_link ( FOBV_SUBSCRIBE_TO_OUR_MAILING_LIST_PAGE_ID ) ; ?>">
                      Subscribe to Our Mailing List
                    </a>
                  </div>

                </form>
              </div>
            </div>

          </div>
        </div>
        <!-- /#main-nav -->

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      </nav>
    </header>
    <!-- /#masthead -->

<?php
if ( is_front_page ( ) && !get_theme_mod ( 'header_banner_visibility' ) ) :
?>

    <!-- Page Sub Header -->
    <div id="page-sub-header">
      <div id="homepageCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
        <ol class="carousel-indicators">
          <li data-target="#homepageCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#homepageCarousel" data-slide-to="1"></li>
          <li data-target="#homepageCarousel" data-slide-to="2"></li>
          <li data-target="#homepageCarousel" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">

          <!-- Home Page Carousel Item -->
          <div class="carousel-item active">
            <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/home.jpg" alt="Home">
            <div class="carousel-caption d-none d-md-block">
              <?php
                echo esc_html ( bloginfo ( 'description' ) ) ;
              ?>
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php get_home_url ( ) ; ?>/#content" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
          </div>
          <!-- /Home Page Carousel Item -->

          <!-- The Viaduct Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/the_viaduct.png" alt="The Viaduct">
            <div class="carousel-caption d-none d-md-block">
              How and why to visit the <span class="font-weight-bolder">Viaduct</span>, its history and cultural significance
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php echo get_page_link ( FOBV_THE_VIADUCT_PAGE_ID ) ?>" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
            <div class="carousel-caption d-md-none">
              The Viaduct
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php echo get_page_link ( FOBV_THE_VIADUCT_PAGE_ID ) ?>" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
          </div>
          <!-- /The Viaduct Carousel Item -->

          <!-- The Project Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/the_project.png" alt="The Project">
            <div class="carousel-caption d-none d-md-block">
              An exciting and innovative <span class="font-weight-bolder">Project</span> to give this "iron giant" a new lease of life
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php echo get_page_link ( FOBV_THE_PROJECT_PAGE_ID ) ?>" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
            <div class="carousel-caption d-md-none">
              The Project
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php echo get_page_link ( FOBV_THE_PROJECT_PAGE_ID ) ?>" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
          </div>
          <!-- /The Project Carousel Item -->

          <!-- The FoBV Carousel Item -->
          <div class="carousel-item">
            <img class="d-block w-100" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/the_fobv.png" alt="The Friends of Bennerley Viaduct">
            <div class="carousel-caption d-none d-md-block">
              The Friends of Bennerley Viaduct (<span class="font-weight-bolder">FoBV</span>) continue to make an immense contribution
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php echo get_page_link ( FOBV_THE_FOBV_PAGE_ID ) ?>" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
            <div class="carousel-caption d-md-none">
              The FoBV
              <br>
              <a class="btn btn-outline-primary btn-block btn-lg" href="<?php echo get_page_link ( FOBV_THE_FOBV_PAGE_ID ) ?>" role="button">
                <span class="font-weight-bold">Read More</span>
              </a>
            </div>
          </div>
          <!-- /The FoBV Carousel Item -->

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
    <!-- Page Sub Header -->

<?php endif ; ?>
        <div id="content" class="site-content">
            <div class="container">
                <div class="row">
<?php endif ; ?>
