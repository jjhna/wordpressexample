<?php

//function university files that contain the images, css, styles and other cdn 
function university_files() {
    // Enqueue (add an item of data to a queue of itesms awaiting processing) a bunch of scripts
    // In this case the js file from the build folder with jquery added in
  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
  // Custom google fonts cdn
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  // Font-awesome cdn
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  //gets the css files
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  //gets the css file
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

//hooks the university files to the enqueue_script 
add_action('wp_enqueue_scripts', 'university_files');

//A function that adds in the title tag when the header.php file is utilized
function university_features() {
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'university_features');