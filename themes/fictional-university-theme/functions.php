<?php

//function pageBanner takes in a argument $args but the default is null if nothing is entered
// The function reduce the need for duplication and also provides a default fallback if no title,subtitle and photo is entered
//
function pageBanner($args = NULL) {
  // php logic will live here
  //if there isn't a title then the title will be taken from the post original admin title
  if (!$args['title']) {
    $args['title'] = get_the_title();
  }
 
  if (!$args['subtitle']) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
 
  if (!$args['photo']) {
    if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
  ?>
  
  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);">
    </div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>
    <?php 
}

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
    //notifies the wp what values are assigned to the key, ex: also found in footer.php 
    // wp_nav_menu(array(
    //     'theme_location' => 'footerLocationOne'
    // ));
    //these can be found in the " admin apperances/menus page -> menu settings " page
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    //Note these images below are custom variables used to resize an image
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}
add_action('after_setup_theme', 'university_features');

//This will only affect the event website checking to make sure it doesn't touch the admin site, and only the event archives page
//Note that most of the keys and values are taken from the front-page.php homepageevents section
function university_adjust_queries($query) {
  //this if satement is for the program archive page
  if (!is_admin() AND is_post_type_archive('program') AND is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
  //this if statement is for the event archive page
  if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

// This below is too powerful and will also affect the admin website.
// function university_adjust_queries($query) {
//   $query->set('posts_per_page', '1');
// }

// add_action('pre_get_posts', 'university_adjust_queries');