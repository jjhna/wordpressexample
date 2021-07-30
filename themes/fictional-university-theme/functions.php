<?php

require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');

function university_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {return get_the_author();}
  ));

  //This is used in the MyNotes.js so that the delete note button will remove the warning limit
  register_rest_field('note', 'userNoteCount', array(
    'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}
  ));
}

add_action('rest_api_init', 'university_custom_rest');

//function pageBanner takes in a argument $args but the default is null if nothing is entered
// The function reduce the need for duplication and also provides a default fallback if no title,subtitle and photo is entered
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
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>  
  </div>
<?php }

//function university files that contain the images, css, styles and other cdn 
function university_files() {
  // Enqueue (add an item of data to a queue of itesms awaiting processing) a bunch of scripts
    // In this case the js file from the build folder with jquery added in
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyDin3iGCdZ7RPomFLyb2yqFERhs55dmfTI', NULL, '1.0', true);
  //adds in the jquery and index.js file to the main-university-js function?
  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    // Custom google fonts cdn
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // Font-awesome cdn
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  //gets the css files
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  //gets the css files
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
  // /localizes a script by getting the site url and placing it into a varible called root_url
  wp_localize_script('main-university-js', 'universityData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));

}

//hooks the university files to the enqueue_script 
add_action('wp_enqueue_scripts', 'university_files');

//A function that adds in the title tag when the header.php file is utilized
function university_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

//this function adjust the queiries by checking the post type and the main query
function university_adjust_queries($query) {
  //for example if it isn't the admin page and a campust post and if the query is the main query
  // then return the all the posts with no post limit per page
  if (!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
    $query->set('posts_per_page', -1);
  }
  //this if satement is for the program archive page
  //returns a query set ordered by its title by ascending and no post limit per page
  if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
   //this if statement is for the event archive page
   //returns a query set by its event date in ascending order BUT it also only shhows relevent dates
   // that are after todays date so previous events aren't shown
  if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    //compares the event date with todays date
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

//ignore functions below
function universityMapKey($api) {
  $api['key'] = 'yourKeyGoesHere';
  return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');


//Redirects subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');
//checks the users role to see if they are a subscriber then redirect them to the main page after logging in
function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user(); //gets the current user
  //checks the users role to see if they are a subscriber then redirect them to the main page after logging in
  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit; // stops the php once it redirects someone
  }
}

//Removes the admin bar for subscribers
add_action('wp_loaded', 'noSubsAdminBar');
//checks the users role to see if they are a subscriber then remove the admin bar
function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user(); //gets the current user
  //checks the users role to see if they are a subscriber then remove the admin bar
  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false); //admin bar isn't shown to subscriber
  }
}

//Customize Login Screen
//So if the user clicks on the W logo on the WP site then it will redirect the user to our university homepage
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
  return esc_url(site_url('/'));
}

/* This tells WP to change the logo image
note that can't change the logo but we can tell WP to change the logo image
also note that if you want to change any of the login theme, color, font and logo
you can change and access it in the login.scss */
add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS() {
  // Custom google fonts cdn
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // Font-awesome cdn
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  //gets the css files
  wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
  //gets the css files
  wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

//Removes the "Powered by Wordpress" logo and wording to be replaced with the project name
//Note that the project name I previously created is: "wordpress-example" which is completely different
add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
  return get_bloginfo('name');
}

//Force note posts to be private
//These functions act as a filter, so WP can filter out any of the data being sent to word press will run through a function
//note: the 3rd parameter is the priority level just in case you need to use multiple usages of wp_insert_post_data
//the 4th parameter means that the function should take in 2 parameters: $data and $postarr
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

//IMPORTANT NOTE: After changing the MyNotes.js from Jquery to pure JS the die error message no longer appears but everything else still works
//The $data is the data that needs to be filtered and in this case the notes that need to become private
function makeNotePrivate($data, $postarr) {
  //We need to make sure the post type is a note
  if ($data['post_type'] == 'note') {
    //Say if we want to limit the amount of notes that a user can make, so we want to limit 5 notes
    //and we want to avoid using this if statement if the post does have an ID
    if (count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {
      die("You have reached your note limit"); //die prevents any of the code below to be run/used
    }
    
    //We want to ensure that wp doesn't allow any post to contain html tags we need to filter the data using sanitize
    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_textarea_field($data['post_title']);
  }

  //Note we need to make sure that the data we want to filter out isn't in the trash and is a note type
  if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
    $data['post_status'] = "private";
  }
  return $data;
}