<?php 

/*
Plugin Name: List Posts Alphabetically
Description: List posts or pages alphabetically by category.
Version: 1.0
Author: Altpress
Author URI: https://profiles.wordpress.org/altpress
License: GPLv2 or later
*/

function lpa_az_func( $lpa_az_atts ) {
    $lpa_az_a = shortcode_atts( array(
        'category' => '',
    ), $lpa_az_atts );


if (!isset($lpa_az_atts['category'])) {
	$lpa_az_atts['category'] = '';
}

$lpa_az_args = array(
  'numberposts' => 1000,
  'category_name'  => $lpa_az_atts['category'],
  'orderby' => 'title',
  'order' => 'ASC'
);
 
$lpa_az_posts = get_posts( $lpa_az_args );
$lpa_az_the_array = array();



foreach ($lpa_az_posts as $lpa_az_post) {

	$lpa_az_post_title = $lpa_az_post->post_title;
	$lpa_az_first_letter = strtoupper($lpa_az_post_title[0]);

	$lpa_az_allposts = '<li><a href="'.get_post_permalink($post->ID).'">'.$lpa_az_post_title.'</a></li>';

	if (!array_key_exists($lpa_az_first_letter, $lpa_az_the_array)) {

		$lpa_az_the_array[$lpa_az_first_letter] = '';

		if (is_numeric($lpa_az_first_letter)) {
			$lpa_az_the_array['Other'] .= $lpa_az_allposts;
		}

		else {
			$lpa_az_the_array[$lpa_az_first_letter] .= $lpa_az_allposts;
		}
		

	}

	else {

		if (is_numeric($lpa_az_first_letter)) {
			$lpa_az_the_array['Other'] .= $lpa_az_allposts;
		}

		else {
			$lpa_az_the_array[$lpa_az_first_letter] .= $lpa_az_allposts;
		}

		

	}

}
	$lpa_az_az = '<ul style="display:flex; flex-wrap: wrap;">';
	foreach (range('A', 'Z') as $lpa_az_char) {
    	if (array_key_exists($lpa_az_char, $lpa_az_the_array)) {
    		$lpa_az_az .= '<li style="margin: 0px; margin-bottom: 10px; padding: 0px 7px; text-align:center; display: inline-block; margin-right: 5px; background: gainsboro; border: 2px solid #c5c5c5;"><a text-decoration: none;" href="#'.$char.'">'.strtoupper($lpa_az_char).'</a></li>';
    	}
    	else {$lpa_az_az .= '<li style="margin: 0px; margin-bottom: 10px; height: max-content; padding: 0px 7px; text-align:center; display: flex; justify-content: center; align-content: center; margin-right: 5px; background: gainsboro; border: 2px solid #c5c5c5; color: #a7a7a7;">'.strtoupper($lpa_az_char).'</li>';}
	}
	$lpa_az_az .= '</ul>';


	//output the blocks
	foreach ($lpa_az_the_array as $lpa_az_letter => $lpa_az_post) {
		if (is_numeric($lpa_az_letter)) {} 
		else if ($lpa_az_letter == "Other") {$lpa_az_linkLast .= '<div id="'.$lpa_az_letter.'"><h2>'.strtoupper($lpa_az_letter).'</h2><ul>'.$lpa_az_post.'</ul></div>';}
		else if (!is_numeric($lpa_az_letter) && $lpa_az_letter !== "Other") {$lpa_az_link .= '<div id="'.$lpa_az_letter.'"><h2>'.strtoupper($lpa_az_letter).'</h2><ul>'.$lpa_az_post.'</ul></div>';} 
	}

	$lpa_az_return_stuff = $lpa_az_az.$lpa_az_link.$lpa_az_linkLast;

	//print_r($the_array);
	return $lpa_az_return_stuff;
}
add_shortcode( 'list-posts-alphabetically', 'lpa_az_func' );

 ?>