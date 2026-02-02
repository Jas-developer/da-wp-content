<?php
/**
 * GWT Breadcrumbs
 */
function gwt_wp_breadcrumb() {
    global $post;
    $option = get_option('govph_options');

    if(isset($option['govph_breadcrumbs_enable']) && $option['govph_breadcrumbs_enable'] != 'true'){
        return false;
    }
    
    $separator = isset($option['govph_breadcrumbs_separator']) && $option['govph_breadcrumbs_separator'] ? $option['govph_breadcrumbs_separator'] : ' / ';
    $separator_block = '<span class="separator">'.$separator.'</span>';
    
    // -----------------------------------------------------------------
    // BLOCK 1: Handling Non-Home Pages (Inner Pages)
    // -----------------------------------------------------------------
    if (!is_home()) {
        echo '<ul class="breadcrumbs">';
    
        // Check if we should show the "Home" link
        if ( isset($option['govph_breadcrumbs_show_home']) && $option['govph_breadcrumbs_show_home'] == 'true' ) { 
            echo '<li>You are here:</li>';
            echo '<li><a class="pathway" href="';
            echo home_url();
            echo '">';
            echo 'Home';
            echo '</a>'.$separator_block.'</li>';
        } else {
            echo '<li>You are here:</li>';
        }
        
    // -----------------------------------------------------------------
    // BLOCK 2: Handling Home Page (FIXED: Removed extra closing brace)
    // -----------------------------------------------------------------
    } else {
        // FIXED: Added parentheses ( ) around the condition
        if ( isset($option['govph_breadcrumbs_show_home']) && $option['govph_breadcrumbs_show_home'] == 'true' ){
            echo '<ul class="breadcrumbs">';
            echo '<li>You are here:</li>';
            echo '<li><a class="pathway" href="';
            echo home_url();
            echo '">';
            echo 'Home';
            echo '</a>'.$separator_block.'</li>';
        }
    }

    // -----------------------------------------------------------------
    // BLOCK 3: Specific Page Types (Category, Single, Page, Archive)
    // -----------------------------------------------------------------
    if (is_category() || is_single()) {
        echo '<li>';
        if(is_category()){
            single_cat_title();
        }

        if (is_single()) {
            the_category('</li><li> ');
            echo $separator_block.'<li>';
            the_title();
            echo '</li>';
        }
        echo '</li>';

    } elseif (is_page()) {
        if($post->post_parent){
            $anc = get_post_ancestors( $post->ID );
            $anc = array_reverse($anc); // Optional: Reverses order so it goes Parent > Child
            $output = ''; // Initialize variable
            
            foreach ( $anc as $ancestor ) {
                // FIXED: Changed "=" to ".=" to append ancestors instead of overwriting them
                $output .= '<li><a class="pathway" href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a>'.$separator_block.'</li>';
            }
            echo $output;
            echo '<li><span class="current show-for-sr">Current: </span>'.get_the_title().'</li>';
        } else {
            echo '<li><span class="current show-for-sr">Current: </span>'.get_the_title().'</li>';
        }
    }
    
    if (is_archive()) {
        if (is_day()) {echo "<li>"; the_time('F jS, Y'); echo '</li>';}
        elseif (is_month()) {echo "<li>"; the_time('F Y'); echo '</li>';}
        elseif (is_year()) {echo "<li>"; the_time('Y'); echo '</li>';}
        elseif (is_author()) {echo "<li>Author Archive"; echo '</li>';}
        elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo '</li>';}
        elseif (is_search()) {echo "<li>Search Results"; echo '</li>';}
    }
    
    echo '</ul>';

    return true;
}