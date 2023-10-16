<?php
/**
 * Automatically generates menus for within page navigation.
 */

function text_content_to_id ( $text_content ) {

    // Generate HTML ids for heading tags that are based on the text content of
    // those heading tags; for example "I am a header" -> "i_am_a_header".

    $id = preg_replace(
        '/[^a-zA-Z0-9-_]/', # not a letter, digit, hyphen or underscore
        '', # is removed
        str_replace( '–', '-', # dashes replaced by hyphens 
            str_replace( ' ', '_', # spaces replaced by underscores
                strtolower( $text_content ) # lowercase
            )
        )
    );

    return $id;

}

function fobv_index_page ( $content ) {

    // This function automatically adds an id attribute to all h2 and h3 tags in
    // pages that contain an in-page navigation menu.

    if ( is_page() && $content ) {

        // Load the content of the page into a DOMDocument object

        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $content );
        libxml_clear_errors();

        if ( $page_content = $doc->getElementById( 'fobv-page-content' ) ) {

            // The pages that contain an in-page navigation menu will contain a
            // column block that has been assigned the id 'fobv-page-content'.
            // This is in the "Page with a page menu" theme pattern.

            $nodes = $page_content->childNodes;
            $headers = [];

            // Parse the DOMDocument for the h2 and h3 level headers within the
            // column whose id is 'fobv-page-content'.

            for ( $i = 0; $i < $nodes->length; $i++ ) {
                $node = $nodes->item($i);
                if (
                    $node->nodeType === XML_ELEMENT_NODE
                    && ( $node->tagName === 'h2' || $node->tagName === 'h3' )
                ) {
                    array_push( $headers, $node );
                }
            }

            foreach ( $headers as $header ) {

                $has_id = FALSE;    # Posit no id attribute
                $has_class = FALSE; # Posit no class attribute

                $tag_name = $header->tagName; # h2 or h3
                $text_content = $header->textContent;

                // The text content from the DOMDocument is not HTML encoded.
                // The HTML that was loaded to create it is HTML encoded, using
                // numeric HTML entities that are generated when WordPress
                // renders any characters that it encodes. Below we're going to
                // do a regex search and replace on that HTML, so we need the
                // text in its original form to search for it.

                $preg_text_content = preg_quote(

                    // The htmlentities function outputs named HTML entities.
                    // WordPress uses numeric HTML entities so convert named
                    // HTML entities that might be used in headings to their
                    // numeric equivalents.

                    strtr( htmlentities( $text_content ), [
                        '&ldquo;' => '&#8220;',
                        '&rdquo;' => '&#8221;',
                        '&ndash;' => '&#8211;'
                    ]),
                    '/' # also preg_quote '/' as it's the delimiter we use below

                );

                // Determine if the header already has an id attribute and/or a
                // a class attribute.

                foreach ( $header->attributes as $attribute ) {
                    if ( $attribute->name === 'id' ) {
                        $has_id = TRUE;
                    } elseif ( $attribute->name === 'class' ) {
                        $has_class = TRUE;
                    }
                }

                if ( $tag_name === 'h2' ) {
                    // Wrap the h2 tag in a div that contains a link back to the
                    // top of the page.
                    $prepend  = '<div style="display: flex; align-items: ';
                    $prepend .= 'center; justify-content: space-between;">';
                    $append   = '<span class="fobv-hide-on-desktop">';
                    $append  .= '<i class="fa-solid fa-arrow-up"></i>&nbsp;';
                    $append  .= '<a href="#fobv-page-top-link">Contents</a>';
                    $append  .= '</span></div>';
                } else {
                    // Don't wrap a h3 tag in a div containing a link back to
                    // the top of the page.
                    $prepend = '';
                    $append = '';
                }

                if ( $has_id ) {

                    // The heading tag already has an id attribute so just make
                    // sure that its value is what we want, i.e. change it to
                    // what we want.

                    // The tag split into what comes before the id attribute's
                    // value, the id attribute's value itself and what comes
                    // after the id attribute's value.

                    $pre_id = "<$tag_name.*?id=\"";
                    $id = '[\w-]+';  # The chars I use in ids
                    $post_id = "\".*?>$preg_text_content<\\/$tag_name>";

                    // Replace the id with the value that will correspond to our
                    // automatically generated page menus.

                    $content = preg_replace(
                        "/($pre_id)$id($post_id)/",
                        $prepend . '$1' . text_content_to_id( $text_content ) .
                        '$2' . $append,
                        $content
                    );

                } else {

                    // The heading tag doesn't have an id attribute so add one.

                    $content = preg_replace(
                        "/(<$tag_name.*?)(>$preg_text_content<\\/$tag_name>)/",
                        $prepend . '$1 id="' .
                        text_content_to_id( $text_content ) . '"$2' . $append,
                        $content
                    );

                }

                if ( $has_class ) {

                    // The heading tag already has a class attribute. Add a
                    // class to the existing classes to hide the header on a
                    // mobile display.

                    $pre_class = "<$tag_name.*?class=\"";
                    $class = '[\w\- ]'; # The chars I use in class attributes
                    $post_class = "\".*?>$preg_text_content<\\/$tag_name>";



                    // Append the class fobv-hide-on-mobile to the other
                    // classes set for this heading tag.

                    $content = preg_replace(
                        "/($pre_class)$class($post_class)/",
                        '$1' . "$class fobv-hide-on-mobile" . '$2',
                        $content
                    );

                } else {

                    // The heading tag doesn't have a class attribute so add
                    // one for the fobv-hide-on-mobile class.

                    $content = preg_replace(
                        "/(<$tag_name.*?)(>$preg_text_content<\\/$tag_name>)/",
                        '$1 class="fobv-hide-on-mobile"$2',
                        $content
                    );

                }

            }
            
        }

    }

    return $content;

};

add_filter( 'the_content', 'fobv_index_page' );

function fobv_page_top_link() {

    // This function outputs a link to the top of a page that we use as the top
    // bar for all the in-page menus by invoking it via a shortcode.

    $page_title = get_the_title();
    return "<a href=\"#\">$page_title</a>";

}

add_action( 'init', function() {
    add_shortcode('fobv-page-top-link', 'fobv_page_top_link');
} );

function fobv_page_navigation() {

    // This function outputs a navigation menu for all h2 and h3 headers within
    // a page. We invoke it within those pages via a shortcode.

    $output = <<<'END'
<nav class="has-background has-tertiary-background-color is-vertical
wp-block-navigation is-layout-flex wp-block-navigation-is-layout-flex"
aria-label="Generated Page Menu">
<ul class="wp-block-navigation__container has-background
has-tertiary-background-color is-vertical wp-block-navigation">
END;

    if ( $content = get_the_content() ) {

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($content);
        libxml_clear_errors();

        if ( $page_content = $doc->getElementById( 'fobv-page-content' ) ) {

            $nodes = $page_content->childNodes;
            $headers = [];

            for ( $i = 0; $i < $nodes->length; $i++ ) {

                $node = $nodes->item($i);

                if (
                    $node->nodeType === XML_ELEMENT_NODE
                    && ($node->tagName === 'h2' || $node->tagName === 'h3')
                ) {
                    array_push($headers, $node);
                }

            }

            for ( $i = 0; $i < count($headers); $i++ ) {

                $header = $headers[$i];
                $next_header = NULL;

                if ( $i+1 < count($headers) ) {
                    $next_header = $headers[$i+1];
                }

                $link_text = $header->textContent;
                $link_href = '#' . text_content_to_id ( $link_text );

                if (
                    $header->tagName === 'h2'
                    && $next_header && $next_header->tagName === 'h3'
                ) {

                    // Output a h2 link that starts a submenu.

                    $output .= <<<END
<!-- Displays if not showing submenus -->
<li class="wp-block-navigation-item wp-block-navigation-link fobv-hide-submenus">
<a class="wp-block-navigation-item__content" href="$link_href">
<span class="wp-block-navigation-item__label">$link_text</span>
</a>
</li>
<!-- /Displays if not showing submenus -->
<!-- Displays if showing submenus -->
<li class="wp-block-navigation-item has-child wp-block-navigation-submenu fobv-show-submenus">
<a class="wp-block-navigation-item__content" href="$link_href">$link_text</a>
<div class="submenu-break"></div>
<ul class="wp-block-navigation__submenu-container wp-block-navigation-submenu">
END;

                } elseif (
                    $header->tagName === 'h3'
                    && (! $next_header || $next_header->tagName === 'h2')
                ) {

                    // Output a h3 link that ends a submenu 

                    $output .= <<<END
<li class="wp-block-navigation-item wp-block-navigation-link">
<a class="wp-block-navigation-item__content" href="$link_href">
<span class="wp-block-navigation-item__label">$link_text</span>
</a>
</li>
</ul>
</li>
<!-- /Display if showing submenus -->
END;

                } elseif (
                    $header->tagName === 'h3' && $next_header
                    && $next_header->tagName === 'h3'
                ) {

                    // Output a h3 link that does not end a submenu

                    $output .= <<<END
<li class="wp-block-navigation-item wp-block-navigation-link fobv-show-submenus">
<a class="wp-block-navigation-item__content" href="$link_href">
<span class="wp-block-navigation-item__label">$link_text</span>
</a>
</li>
END;

                } else {

                    // Output a h2 link that does not start a submenu

                    $output .= <<<END
<li class="wp-block-navigation-item wp-block-navigation-link">
<a class="wp-block-navigation-item__content" href="$link_href">
<span class="wp-block-navigation-item__label">$link_text</span>
</a>
</li>
END;

                }

            }

            $output .= <<<'END'
</ul>
</nav>
END;

            return $output;

        }

    }

}

add_action( 'init', function() {
    add_shortcode('fobv-page-navigation', 'fobv_page_navigation');
});
