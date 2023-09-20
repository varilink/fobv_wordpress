<?php

function text_content_to_id ( $text_content ) {

    $id = preg_replace(
        '/[^a-zA-Z0-9-_]/',
        '',
        str_replace( '–', '-',
            str_replace( ' ', '_',
                strtolower( $text_content )
            )
        )
    );

    return $id;

}

// Filter that automatically adds an id attribute to all h2 and h3 tags in pages
// that contain an in-page navigation menu.

function fobv_index_page ( $content ) {

    if ( is_page() && $content ) {

        # Load the content of the page into a DOMDocument object
    
        $doc = new \DOMDocument();
        libxml_use_internal_errors( true );
        $doc->loadHTML( $content );
        libxml_clear_errors();
    
        if ( $page_content = $doc->getElementById( 'fobv-page-content' ) ) {
    
            # The pages that contain an in-page navigation menu will contain a
            # column block that has been assigned the id 'fobv-page-content'.
            # This is in the "Page with a page menu" theme pattern.
    
            $nodes = $page_content->childNodes;
            $headers = [];
    
            # Parse the DOMDocument for the h2 and h3 level headers within the
            # column whose id is 'fobv-page-content'.
    
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
    
                $has_id = False;
                $tag_name = $header->tagName;
                $text_content = $header->textContent;
                $preg_text_content = preg_quote(
                    strtr( htmlentities( $text_content ), [
                        '&ldquo;' => '&#8220;',
                        '&rdquo;' => '&#8221;',
                        '&ndash;' => '&#8211;'
                    ]),
                    '/'
                );
    
                # Determine if the header already has an id attribute.
    
                foreach ( $header->attributes as $attribute ) {
                    if ( $attribute->name === 'id' ) {
                        $has_id = True;
                        break;
                    }
                }
    
                if ( $has_id ) {
    
                    # The heading tag already has an id attribute so just make
                    # sure that it's value is what we want.
    
                    $pre_id = "<$tag_name.*?id=\"";
                    $id = '[\w-]+';
                    $post_id = "\".*?>$preg_text_content<\\/$tag_name>";
    
                    $content = preg_replace(
                        "/($pre_id)$id($post_id)/",
                        '$1' . text_content_to_id( $text_content ) . '$2',
                        $content
                    );
    
                } else {
    
                    # The heading tag doesn't have an id attribute so add one.
    
                    $content = preg_replace(
                        "/(<$tag_name.*?)(>$preg_text_content<\\/$tag_name>)/",
                        '$1 id="' . text_content_to_id( $text_content ) . '"$2',
                        $content
                    );
    
                }
            }
            
        }

    }

    return $content;

};

add_filter( 'the_content', 'fobv_index_page' );

// Short code to output a link to the top of a page.

function fobv_page_top_link() {

$page_title = get_the_title();
return "<a href=\"#\">$page_title</a>";

}

add_action( 'init', function() {

add_shortcode('fobv-page-top-link', 'fobv_page_top_link');

});

// Short code to output a navigation menu for all h2 and h3 headers within a
// page.

function fobv_page_navigation() {

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

                # Output a h2 link that starts a submenu

                $output .= <<<END
<li class="wp-block-navigation-item has-child wp-block-navigation-submenu">
<a class="wp-block-navigation-item__content" href="$link_href">$link_text</a>
<div class="submenu-break"></div>
<ul class="wp-block-navigation__submenu-container wp-block-navigation-submenu">
END;

            } elseif (
                $header->tagName === 'h3'
                && (! $next_header || $next_header->tagName === 'h2')
            ) {

                # Output a h3 link that ends a submenu 

                $output .= <<<END
<li class="wp-block-navigation-item wp-block-navigation-link">
<a class="wp-block-navigation-item__content" href="$link_href">
<span class="wp-block-navigation-item__label">$link_text</span>
</a>
</li>
</ul>
</li>
END;

            } else {

                # Output a h2 or h3 link that neither starts nor closes a
                # submenu
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
