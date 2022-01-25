#!/usr/bin/env bash

# Remove header header_image theme mod
wp --allow-root --path=/usr/local/share/nginx/bennerleyviaduct.org.uk theme mod remove header_image

# Revise home page content
wp --allow-root --path=/usr/local/share/nginx/bennerleyviaduct.org.uk post update 24 - <<EOF
<!-- wp:paragraph -->
<p>The Friends of Bennerley Viaduct (<a href="/?page_id=1760" data-type="URL" data-id="/?page_id=1760">The FoBV</a>) are dedicated to restoring, conserving and celebrating <a href="/?page_id=22" data-type="URL" data-id="/?page_id=22">Bennerley Viaduct</a>. In 2021 <a href="/?page_id=1537" data-type="URL" data-id="/?page_id=1537">Our Project</a> goal is to re-open Bennerley Viaduct to the public after 50 years of closure. Please support us by <a href="https://test.bennerleyviaduct.org.uk/?page_id=1832" data-type="page" data-id="1832">becoming a Friend of Bennerley Viaduct</a> or by <a href="/?page_id=1975" data-type="URL" data-id="/?page_id=1975">donating to Our Project</a>. <a href="/?page_id=2007" data-type="URL" data-id="/?page_id=2007">Subscribe to our email bulletin</a> to be kept up to date with our latest news.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Bennerley Viaduct is a grade 2* listed  railway viaduct built in 1877 by the Great Northern Railway Company.  At over quarter of a mile long, it is the longest wrought iron viaduct in the country. It straddles the River Erewash connecting Ilkeston in Derbyshire with Awsworth in Nottinghamshire. The "Iron Giant" has been described by the World Monuments Fund as being an "extraordinary monument"  meriting inclusion  in the <a href="https://www.wmf.org/2020Watch">2020 World Monuments Watch</a>, one of only 25 sites chosen globally.  Historic England consider the viaduct is a “stunning example of the genius of British Engineering”</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The Friends of Bennerley Viaduct are dedicated to give our "Iron Giant" a new lease of life.  Working in partnership with the owners, Railway Paths Limited, an inspiring community driven project is bringing the iconic structure  back to life.  In 2021, Bennerley Viaduct should be re-opened to the public following fifty years of closure following a £1.4 million investment.  </p>
<!-- /wp:paragraph -->
EOF

# Revise donate page content
wp --allow-root --path=/usr/local/share/nginx/bennerleyviaduct.org.uk post update 1975 - <<EOF
<!-- wp:paragraph -->
<p>If you wish to make a donation to The Friends of Bennerley Viaduct to  support our project you can do so here. We accept donations up to £30 online. If you wish to make a larger donation then please <a href="https://test.bennerleyviaduct.org.uk/?page_id=1193">Contact Us</a>. All donations are very gratefully received, whatever the value.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[fobv_donations_form]
<!-- /wp:shortcode -->

<!-- wp:image {"id":2455,"sizeSlug":"large","className":"mt-5"} -->
<figure class="wp-block-image size-large mt-5"><img src="https://test.bennerleyviaduct.org.uk/wp-content/uploads/2020/11/amazon-smile.jpg" alt="" class="wp-image-2455"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Now you can also donate to The Friends of Bennerley Viaduct at no cost to yourself via Amazon Smile. If you shop via Amazon then the steps to donate to The Friends of Bennerley Viaduct as you do so are:</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol><li>Join AmazonSmile and select "Friends of Bennerley Viaduct" as your favourite charity.</li><li>Shop via AmazonSmile when you make purchases from Amazon.</li></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>And that's it! Amazon will donate 0.5% of the purchase value of anything you buy from AmazonSmile to The Friends of Bennerley Viaduct!</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>If you are not already an AmazonSmile member then you must <a href="https://smile.amazon.co.uk/ref=smi_se_mht_l1_sign_mob_mkt">sign-up</a> on you web browser. It is not possible to join AmazonSmile using the Amazon Shopping mobile app. When selecting your favourite charity, search for "Friends of Bennerley Viaduct".</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>If you are already an AmazonSmile member and wish to change your selected charity to "Friends of Bennerley Viaduct", then you can do so via <a href="https://smile.amazon.co.uk/gp/chpf/change/ref=smi_se_rspo_change_cycsc">Your Account &gt; Change Your Charity</a> on your web browser. It is not possible to change your selected charity via the Amazon Shopping mobile app. Again, search for "Friends of Bennerley Viaduct".</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>To shop using AmazonSmile on your web browser, you must go to <a href="https://smile.amazon.co.uk/">smile.amazon.co.uk</a> instead of amazon.co.uk. Amazon provide <a href="https://www.amazon.co.uk/b?ie=UTF8&amp;node=17337655031">instructions for shopping via AmazonSmile in the Amazon Shopping mobile app</a>.</p>
<!-- /wp:paragraph -->

EOF
