<?php

  /**
  * Template Name: Home
  */

  get_header();

?>

<section id="primary" class="content-area col-sm-12">
  <main id="main" class="site-main" role="main">

<?php
  while ( have_posts ( ) ) : the_post ( ) ;

    get_template_part ( 'template-parts/content' , 'page' ) ;

    // If comments are open or we have at least one comment, load up the
    // comment template.
    if ( comments_open ( ) || get_comments_number ( ) ) :
      comments_template ( ) ;
    endif ;

  endwhile; // End of the loop.
?>

  </main><!-- #main -->
</section><!-- #primary -->

<!-- Start of Latest News container -->
<div class="container">
  <h2>Latest News</h2>
<?php

  $posts = get_posts ( array ( 'numberposts' => 6 ) ) ;

  foreach ( array ( 'small' , 'medium' , 'large' ) as $display ) {

    $i = 0 ;

    if ( $display == 'small' ) {

			print '  <div class="d-md-none">' ;

		} elseif ( $display == 'medium' ) {

      print '  <div class="d-none d-md-block d-lg-none">' ;

		} elseif ( $display == 'large' ) {

			print '  <div class="d-none d-lg-block">' ;

		}

		print '
    <div class="row">' ;

		foreach ( $posts as $post ) {

      $title = $post -> post_title ;
			$excerpt = wp_strip_all_tags (
				$post -> post_excerpt ? $post -> post_excerpt : 'THIS POST NEEDS AN EXCERPT WRITTEN'
			) ;
			$guid = $post -> guid ;
			$image = get_the_post_thumbnail_url ( $post ) ;

			if ( $display == 'small' ) {
				print '
      <div class="col-12">' ;
			} elseif ( $display == 'medium' ) {
				print '
      <div class="col-6">' ;
			} elseif ( $display == 'large' ) {
				print '
      <div class="col-4">' ;
			}

			print "
        <div class=\"card\">
          <div class=\"card-body\">
            <h5 class=\"card-title\">$title</h5>
            <img src=\"$image\" class=\"card-img-top\">
            <div class=\"card-text\">
              $excerpt <br><a href=\"$guid\">Read More</a>
            </div>
          </div>
        </div> <!-- End of card -->
        &nbsp;<br>" ;

			print '
      </div> <!-- End of col -->' ;
			$i++ ;
			if (
				( $display == 'small' && $i != 6 )
				||
				( $display == 'medium' && ( $i == 2 || $i == 4 ) )
				||
				( $display == 'large' && $i == 3 )
			) {
				print '
    </div> <!-- End of row -->
    <div class="row">' ;
			} elseif ( $i == 6 ) {
				print '
    </div> <!-- End of row -->' ;
			}

		} # End of post foreach

		print '
  </div> <!-- End of visibility block -->' ;

	} # End of display foreach

?>

</div>
<!-- End of Latest News container -->

<!-- Financial Backers -->
<div class="container">

  <!-- Key Financial Backers -->
	<h2>Our Key Financial Backers</h2>
  <div class="row">
    <div class="col text-md-center">
      <a href="http://railwayheritagetrust.co.uk/" target="_blank">
        <img style="height: auto ; width: 90px ;" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/RHT-Logo-RGB-Small.jpg">
      </a>
    </div>
    <div class="col">
      <a href="https://www.heritagefund.org.uk/" target="_blank">
        <img style="height: auto ; width: 175px ;" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/heritage_trust_logo_en_2.png">
      </a>
    </div>
    <div class="w-100 mt-4 d-md-none"></div>
    <div class="col">
      <a href="https://historicengland.org.uk/" target="_blank">
        <img style="height: auto ; width: 220px ;" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/Historic England.png">
      </a>
    </div>
    <div class="col">
      <a href="https://www.wmf.org/" target="_blank">
        <img style="height: auto ; width: 220px ;" src="/wp-content/themes/wp-bootstrap-starter-child/assets/img/wmf-logo.png">
      </a>
    </div>
  </div>
  <!-- / Key Financial Backers -->

  <!-- Other Backers -->
  <div class="row d-none d-md-block">
    <div class="col-12">
      <div class="card mt-4">
        <div class="card-header">
          <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#otherBackers" aria-expanded="true" aria-controls="collapseOne">
              Other Financial Backers
            </button>
          </h2>
        </div>
        <div id="otherBackers" class="collapse" aria-labelledby="headingOne">
          <!-- Other Backers Single Row -->
          <div class="card-body d-none d-lg-block">
            <div class="row">
              <div class="col text-center">
                <a href="http://www.hballenct.org.uk/" target="_blank">
                  <img style="height: auto ; width: 150px ;" src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/key_visual2.gif">
                  <br>
                  The H.B. Allen Charitable Trust
                </a>
              </div>
              <div class="col">
                <a href="http://www.charleshaywardfoundation.org.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/charles_haywood_logo.png">
                </a>
              </div>
              <div class="col">
                <a href="https://www.broxtowe.gov.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/broxtowe_logo.png">
                </a>
              </div>
              <div class="col">
                <a href="https://www.thepilgrimtrust.org.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/the_pilgrim_trust.png">
                </a>
              </div>
              <div class="col text-center">
                <a href="http://www.railwayramblers.org.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/rr_logo_82h.jpg">
                  <br>
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/rr_name_82h.jpg">
                </a>
              </div>
            </div>
          </div>
          <!-- / Other Backers Single Row -->
          <div class="card-body d-none d-md-block d-lg-none">
            <!-- Other Backers Row 1 of 2 -->
            <div class="row">
              <div class="col text-center">
                <a href="http://www.hballenct.org.uk/" target="_blank">
                  <img style="height: auto ; width: 150px ;" src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/key_visual2.gif">
                  <br>
                  The H.B. Allen Charitable Trust
                </a>
              </div>
              <div class="col">
                <a href="http://www.charleshaywardfoundation.org.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/charles_haywood_logo.png">
                </a>
              </div>
              <div class="col">
                <a href="https://www.broxtowe.gov.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/broxtowe_logo.png">
                </a>
              </div>
            </div>
            <!-- / Other Backers Row 1 of 2 -->
            <!-- Other Backers Row 2 of 2 -->
            <div class="row">
              <div class="col">
                <a href="https://www.thepilgrimtrust.org.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/the_pilgrim_trust.png">
                </a>
              </div>
              <div class="col text-center">
                <a href="http://www.railwayramblers.org.uk/" target="_blank">
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/rr_logo_82h.jpg">
                  <br>
                  <img src="<?php get_site_url ( ) ?>wp-content/themes/wp-bootstrap-starter-child/assets/img/rr_name_82h.jpg">
                </a>
              </div>
            </div>
            <!-- / Other Backers Row 1 of 2 -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- / Other Backers -->

</div>
<!-- / Financial Bakcers -->

<?php
get_footer();
