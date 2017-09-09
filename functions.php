<?php

if ( function_exists('register_sidebars') )
	register_sidebar();

function pdp8_add_theme_page() {

	if ($_GET['page'] == basename(__FILE__)) {
		if      ('save' == $_REQUEST['action']) {
			update_option('pdp8_Mode', $_REQUEST[ 'set_Mode' ] );
			update_option('pdp8_Sidebar', $_REQUEST[ 'set_Sidebar' ] );
			update_option('pdp8_ShowAuthor', $_REQUEST[ 'set_ShowAuthor' ] );
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} 
            else if ('reset' == $_REQUEST['action']) {
			delete_option( 'pdp8_Mode' );
			delete_option( 'pdp8_Sidebar' );
			delete_option( 'pdp8_ShowAuthor' );
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}

      add_theme_page("PDP-8 Theme Options", "Theme Options", 'edit_themes', basename(__FILE__), 'pdp8_theme_page');
}

function pdp8_theme_page() {
	if ( $_REQUEST['saved'] ) 
        echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) 
        echo '<div id="message" class="updated fade"><p><strong>Settings reset.</strong></p></div>';
?>

<div class="wrap">
<form method="post">
<p>Select computer type:
<?php $value = get_settings( 'pdp8_Mode' ); ?>
<table border="0" cellspacing="4">
<?php $selected = ""; if ($value == "PDP8") $selected = "checked=\"true\""; ?>
<tr>
<td><nobr><input type="radio" name="set_Mode" <?php echo $selected; ?> value="PDP8"> PDP-8</nobr></td>
<td><img src="<?php bloginfo('template_url'); ?>/images/PDP8header.gif"  width="479" height="63"></td>
<td>Considered the first mini-computer, the PDP-8 was a 12-bit machine, introduced in 1965</td>
</tr>
<?php $selected = ""; if ($value == "PDP10") $selected = "checked=\"true\""; ?>
<tr>
<td><nobr><input type="radio" name="set_Mode" <?php echo $selected; ?> value="PDP10"> PDP-10</nobr></td>
<td><img src="<?php bloginfo('template_url'); ?>/images/PDP10header.gif" width="479" height="63"></td>
<td>The mainframe that Bill Gates and Paul Allen learned on, the 36-bit PDP-10 was introduced in 1969</td>
</tr>
<?php $selected = ""; if ($value == "PDP11") $selected = "checked=\"true\""; ?>
<tr>
<td><nobr><input type="radio" name="set_Mode" <?php echo $selected; ?> value="PDP11"> PDP-11</nobr></td>
<td><img src="<?php bloginfo('template_url'); ?>/images/PDP11header.gif" width="479" height="63"></td>
<td>The most popular mini-computer of all time, the 16-bit PDP-11 was introduced in 1970</td>
</tr>
</table>
</p>

<p>Sidebar:
<?php $value = get_settings( 'pdp8_Sidebar' ); ?>
<table border="0" cellspacing="4">
<?php $selected = ""; if ($value == "Left") $selected = "checked=\"true\""; ?>
<tr>
<td><nobr><input type="radio" name="set_Sidebar" <?php echo $selected; ?> value="Left"> Left</nobr></td>
</tr>
<?php $selected = ""; if ($value == "Right") $selected = "checked=\"true\""; ?>
<tr>
<td><nobr><input type="radio" name="set_Sidebar" <?php echo $selected; ?> value="Right"> Right</nobr></td>
</tr>
</table>
</p>

<p>Show Author:
<?php
     $value = get_settings( 'pdp8_ShowAuthor' );
     echo "<select name=\"set_ShowAuthor\" style=\"width:200px;\">";
     
     $selected = "";
     if ($value == "true") $selected = "selected=\"true\"";
     echo "<option value=\"true\" $selected >Yes</option>";

     $selected = "";
     if ($value == "false") $selected = "selected=\"true\"";
     echo "<option value=\"false\" $selected >No</option>";
     echo "</select>";
?>
</p>

<p class="submit"><input type="submit" name="save" value="Save Settings"></p>
<input type="hidden" name="action" value="save" />
</form>
</div><!--wrap-->
<?php
}

add_action('admin_menu', 'pdp8_add_theme_page');

/*
Plugin Name: PageNav
Plugin URI: http://www.adsworth.info/wp-pagesnav
Description: Header Navigation.
Author: Adi Sieker
Version: 0.0.1
Author URI: http://www.adsworth.info/
*/
/*  Copyright 2004  Adi J. Sieker  (email : adi@adsworth.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function pdp8_pages_nav($args = '') {
    global $wp_query;
	parse_str($args, $r);
	if (!isset($r['current']))          $r['current'] = -1;
	if (!isset($r['show_all_parents'])) $r['show_all_parents'] = 0;
	if (!isset($r['show_root']))        $r['show_root'] = 0;
	if (!isset($r['list_tag']))        $r['show_root'] = 1;

    if($r['current'] == "")
        return;

    if($r['current'] == -1 && $wp_query->is_page == true) {
        $r['current'] = $wp_query->post->ID;
    }

    if($r['current'] == -1 && $r['show_root'] != 0) {
        $r['current'] = 0;
    }
    
	// Query pages.
	$pages = get_pages($args);
	if ( $pages ) {
    	// Now loop over all pages that were selected
    	$page_tree = Array();
    	$parent_page_id = null;
    	$parents= Array();
    	foreach($pages as $page) {
    		// set the title for the current page
    		$page_tree[$page->ID]['title'] = $page->post_title;
    		$page_tree[$page->ID]['parent'] = $page->post_parent;
    
    		// set the selected date for the current page
    		// depending on the query arguments this is either
    		// the createtion date or the modification date
    		// as a unix timestamp. It will also always be in the
    		// ts field.
    		if (! empty($r['show_date'])) {
    			if ('modified' == $r['show_date'])
    				$page_tree[$page->ID]['ts'] = $page->time_modified;
    			else
    				$page_tree[$page->ID]['ts'] = $page->time_created;
    		}
    
    		// The tricky bit!!
    		// Using the parent ID of the current page as the
    		// array index we set the curent page as a child of that page.
    		// We can now start looping over the $page_tree array
    		// with any ID which will output the page links from that ID downwards.
    		$page_tree[$page->post_parent]['children'][] = $page->ID; 	
            if( $r['current'] == $page->ID) {
                if($page->post_parent != 0 || $r['show_root'] == true)
                    $parents[] = $page->post_parent;
            }
    	}

    	$len = count($parents);
    	for($i = 0; $i < $len ; $i++) {
    	    $parent_page_id = $parents[$i];
    	    $parent_page = $page_tree[$parent_page_id];

    	    if(isset($parent_page['parent']) && !in_array($parent_page['parent'], $parents)) {
    	        if($parent_page['parent'] != 0 || $r['show_root'] == true) {
        	        $parents[] = $parent_page['parent'];
        	        $len += 1;
        	        if( $len >= 2 && $r['show_all_parents'] == 0) {
        	            break;
        	        }
        	    }
    	    }
        }

        $parents = array_reverse($parents);

        $level = 0;
        $parent_out == false;
        foreach( $parents as $parent_page_id ) {
            $level += 1;
      		$css_class = 'level' . $level;
      		if( $r['list_tag'] == true || $parent_out == true)
	        	echo "<ul class='". $css_class . "'>";
            foreach( $page_tree[$parent_page_id]['children'] as $page_id) {
        		$cur_page = $page_tree[$page_id];
        		$title = $cur_page['title'];

                $css_class = '';
        		if( $page_id == $r['current']) {
        			$css_class .= ' current';
  	      		}
				if( $page_id == $page_tree[$r['current']]['parent']){
					$css_class .= 'currentparent';
				}
                echo "<li class='" . $css_class . "' ><a href='" . get_page_link($page_id) . "' title='" . wp_specialchars($title) . "'>" . $title . "</a></li>\n";
            }

	        	echo "</ul>";

	        $parent_out = true;
        }

    	if( is_array($page_tree[$r['current']]['children']) === true ) {
            $level += 1;
      		$css_class = 'level' . $level;
      		if( $r['list_tag'] == true || $parent_out == true)
		       	echo "<ul class='". $css_class . " children'>";
            foreach( $page_tree[$r['current']]['children'] as $page_id) {
        		$cur_page = $page_tree[$page_id];
        		$title = $cur_page['title'];
        
                echo "<li class='" . $css_class . "'><a href='" . get_page_link($page_id) . "' title='" . wp_specialchars($title) . "'>" . $title . "</a></li>\n";
            }

	  echo "</ul>";

        }
     }
}
?>
