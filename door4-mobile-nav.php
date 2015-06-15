<?php
/**
 * Plugin Name: Door4 Mobile Nav
 * Plugin URI: http://www.door4.com
 * Description: A sliding menu to be included on Door4 sites for Mobile Versions.
 * Version: 0.9
 * Author: Dan Beckett
 * Author URI: http://www.door4.com
 * License: GPL2
 
*/

$menu_location_name = 'door4_mobile';
$menu_array = array();

if(!function_exists('door4_mobile_menu_resources')) {

	function door4_mobile_menu_resources() {
	
		wp_register_style( 'door4-mobile-nav-style', plugins_url('door4-mobile-nav/css/door4-mobile-nav.css'), array(), '0.7.4', 'all' );
		wp_register_style( 'd4-mn-font-awesome-min', plugins_url('door4-mobile-nav/css/font-awesome.min.css'), array(), '3.2.1', 'all' );
		wp_enqueue_style( 'door4-mobile-nav-style' );
		wp_enqueue_style( 'd4-mn-font-awesome-min' );
		
		wp_register_script( 'door4-mobile-nav-script', plugins_url('door4-mobile-nav/js/door4-mobile-nav.js'), array(), '0.7', true );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'door4-mobile-nav-script' );
	
	};
	
	add_action( 'wp_enqueue_scripts', 'door4_mobile_menu_resources' );

};

if(!function_exists('register_door4_mobile_menu_location')) {

	function register_door4_mobile_menu_location () {
		global $menu_location_name;
		register_nav_menu( $menu_location_name, 'Door4 Sliding Mobile Menu' );
	};

	add_action( 'admin_init', 'register_door4_mobile_menu_location');

};

function add_sub_menu($item_id, $section_title, $menu_array) {
	$sub_menu = $menu_array[$item_id];
	$sub_output= '<ul class="sub">';
	$sub_output.='<li class="section-title"><h4 class="door4-mobile-nav-title">'.$section_title.'</h4></li><li class="mobile-nav-item mobile-back-item"><a class="mobile-nav-link mobile-back-link" href="javascript:void(0);"><span>Back</span><i class="icon-caret-right"></i></a></li>';
	foreach($sub_menu as $sub_menu_item) {
		$sub_item_id = $sub_menu_item->ID;
		$has_sub = 'blank';
		if($menu_array[$sub_item_id]) $has_sub = 'caret-left';
		$sub_output.= '<li class="mobile-nav-item mobile-sub-nav-item"><a class="mobile-nav-link mobile-sub-nav-link hasi-'.$has_sub.'" href="'.$sub_menu_item->url.'"><i class="icon-'.$has_sub.'"></i>'.$sub_menu_item->title.'</a>';
		if($menu_array[$sub_item_id]) {
			$sub_output.= add_sub_menu($sub_item_id, $sub_menu_item->title, $menu_array);
		}			
		$sub_output.= '</li>';
	}
	$sub_output.= '</ul>';
	return $sub_output;	
};

/*  Deprecated in 0.9 as tapping directly into wp_head was causing
    incorrect load into <head> section.
    
    Replaced with include_door4_mobile_menu_js, performing same function
    but adding to body with jQuery
if(!function_exists('include_door4_mobile_menu')) {

	function include_door4_mobile_menu() {

		global $menu_location_name;
		global $menu_array;
		
		$output = '<a href="javascript:void(0);" class="door4-mobile-nav-toggle"><i class="icon-reorder"></i></a><div class="door4-mobile-nav"><ul class="mobile-nav-list"><li class="section-title"><h4 class="door4-mobile-nav-title">Navigate</h4></li>';
		
		$menu_locations = get_nav_menu_locations();
		$menu_id = $menu_locations[$menu_location_name];		
		
		$menu_items = wp_get_nav_menu_items($menu_id);
	
		if(is_array($menu_items)) {
	
			foreach($menu_items as $item) {
				$nav_parent = $item->menu_item_parent;
				$menu_array[$nav_parent][] = $item;
			};
			
			foreach($menu_array[0] as $top_level_item) {
				$item_id = $top_level_item->ID;
				$has_sub = 'blank';
				if($menu_array[$item_id]) $has_sub = 'caret-left';
				$output.= '<li class="mobile-nav-item"><a class="mobile-nav-link hasi-'.$has_sub.'" href="'.$top_level_item->url.'">';
				$output.= '<i class="icon-'.$has_sub.'"></i><span>'.$top_level_item->title.'</span></a>';
				if($menu_array[$item_id]) {
					$output.= add_sub_menu($item_id, $top_level_item->title, $menu_array);
				}
				$output.= '</li>';
			}
		
		}
		
		$output.= '</ul></div>';
		$output.= '<div class="door4-mobile-nav-push"><div class="door4-mobile-nav-overlay"></div><div class="door4-mobile-nav-push-inner">';
		
		echo $output;
		
	};

	add_action( 'wp_head', 'include_door4_mobile_menu' );
};
*/


/*  Deprecated in version 0.9 and rolled into one function 
	- include_door4_mobile_menu_js
	
if(!function_exists('include_door4_mobile_menu_close')) {

	function include_door4_mobile_menu_close() {
		$output = '</div></div>';		
		echo $output;
	};

	add_action( 'wp_footer', 'include_door4_mobile_menu_close' );
};
*/

if(!function_exists('include_door4_mobile_menu_js')) {

	function include_door4_mobile_menu_js() {

		global $menu_location_name;
		global $menu_array;
		
		$output = '<a href=\"javascript:void(0);\" class=\"door4-mobile-nav-toggle\"><i class=\"icon-reorder\"></i></a><div class=\"door4-mobile-nav\"><ul class=\"mobile-nav-list\"><li class=\"section-title\"><h4 class=\"door4-mobile-nav-title\">Navigate</h4></li>';
		
		$menu_locations = get_nav_menu_locations();
		$menu_id = $menu_locations[$menu_location_name];		
		
		$menu_items = wp_get_nav_menu_items($menu_id);
	
		if(is_array($menu_items)) {
	
			foreach($menu_items as $item) {
				$nav_parent = $item->menu_item_parent;
				$menu_array[$nav_parent][] = $item;
			};
			
			foreach($menu_array[0] as $top_level_item) {
				$item_id = $top_level_item->ID;
				$has_sub = 'blank';
				if($menu_array[$item_id]) $has_sub = 'caret-left';
				$output.= '<li class=\"mobile-nav-item\"><a class=\"mobile-nav-link hasi-'.$has_sub.'\" href=\"'.$top_level_item->url.'\">';
				$output.= '<i class=\"icon-'.$has_sub.'\"></i><span>'.$top_level_item->title.'</span></a>';
				if($menu_array[$item_id]) {
					$output.= add_sub_menu($item_id, $top_level_item->title, $menu_array);
				}
				$output.= '</li>';
			}
		
		}
		
		$output.= '</ul></div>';
		$output.= '<div class=\"door4-mobile-nav-push\"><div class=\"door4-mobile-nav-overlay\"></div><div class=\"door4-mobile-nav-push-inner\">';
		
		//$output = '<div class=\"buzzin\" style=\"background-color: red; height: 200px; width: 200px;\"></div>';
		
		$newoutput = "<script type=\"text/javascript\">
		jQuery(document).ready(function(){
			jQuery('body').prepend('".$output."');
			jQuery('body').append('</div></div>');
		});</script>";
		
		echo $newoutput;
		
	};

	add_action( 'wp_head', 'include_door4_mobile_menu_js' );
};

?>