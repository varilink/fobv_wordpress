<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
<?php
  if (
    !is_page_template ( 'blank-page.php' ) &&
    !is_page_template ( 'blank-page-with-container.php' )
  ) :
?>
          </div><!-- .row -->
        </div><!-- .container -->
      </div><!-- #content -->
      <?php get_template_part( 'footer-widget' ) ; ?>

      <footer id="colophon" class="site-footer" role="contentinfo" style="background-image: url(<?php echo home_url ( ) . "/wp-content/themes/wp-bootstrap-starter-child/assets/img/footer.jpg"?>);">
        <div class="container">
          <div class="row">
            <div class="col-sm-6">
              <img width="175px" class="float-left" src="<?php echo home_url ( ) . '/wp-content/themes/wp-bootstrap-starter-child/assets/img/logo-footer.png' ?>">
              <p class="d-none d-lg-block" style="position: relative ; top: 70px ;">
                Dedicated to restoring, conserving and celebrating Bennerley Viaduct. Registered in England and Wales with charity number 1187044.
              </p>
              <div style="clear: left">
                &copy; <?php echo date( 'Y' ) ?>

                <?php echo '<a href="' . home_url ( ) . '">' . get_bloginfo ( 'name' ) .'</a>' ; ?>

                <br>
                <a class="credits" href="<?php echo get_page_link ( FOBV_PRIVACY_POLICY_PAGE_ID ) ; ?>" target="_blank">Privacy Policy</a>
                <!-- sep or br dependent on screen size -->
                <span class="sep d-xs-inline d-sm-none d-lg-inline">|</span>
                <br class="d-none d-sm-block d-lg-none">
                <!-- / sep or break dependent on screen size -->
                Site by
                <a class="credits" href="https://www.varilink.co.uk" target="_blank" alt="Varilink Computing Ltd" title="Site Design, Build and Hosting">
                  Varilink Computing Ltd
                </a>
              </div>
            </div>
            <div class="d-none d-lg col-lg-2">&nbsp;</div>
            <div class="col-sm-6 col-lg-4">
              <p class="lead font-weight-bold">
                Contact and Social Media
              </p>
              <p>
                Castledine House<br>
                5-9 Heanor Road<br>
                Ilkeston<br>
                DE7 8DY
              </p>
              <p>
                <i class="fas fa-at fa-2x"></i>
                <a style="position: relative; top: -0.4rem ;" href="mailto:info@bennerleyviaduct.org.uk">
                  info@bennerleyviaduct.org.uk
                </a>
              </p>
              <p>
                <i class="fab fa-facebook fa-2x"></i>
                <a style="position: relative; top: -0.4rem ;" href="https://www.facebook.com/bennerleyviaduct/">
                  Bennerley Viaduct Friends Group
                </a>
              </p>
              <p>
                <i class="fab fa-twitter-square fa-2x"></i>
                <a style="position: relative; top: -0.4rem ;" href="https://twitter.com/theirongiant_">
                  Bennerley Viaduct Twitter Account
                </a>
              </p>
            </div>
          </div>
        </div><!-- #colophon .container -->
      </footer><!-- #colophon -->
<?php endif; ?>
    </div><!-- #page -->

<!-- php wp_footer -->
<?php wp_footer ( ) ; ?>

<!-- php wp_footer -->

  </body>
</html>
