<?php
/* Note: MU - stand for must use, it's a plugin that tells WP that they must use this custom type plugin
    Used to make custom changes to the type posts. Make sure to go to admin page -> settings/peramlinks and click save changes after
    making any changes below
    Note that makin any changes below will provide the admin and other users to add/update/delete any posts with additional content
    For example, removing the title from supports will remove the ability to type a title to a post */
function university_post_types() {
  // Campus Post Type
  register_post_type('campus', array(
    'capability_type' => 'campus',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'rewrite' => array('slug' => 'campuses'),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Campuses',
      'add_new_item' => 'Add New Campus',
      'edit_item' => 'Edit Campus',
      'all_items' => 'All Campuses',
      'singular_name' => 'Campus'
    ),
    'menu_icon' => 'dashicons-location-alt'
  ));
  
  // Event Post Type
  //the function register_post_type which takes in 2 arguments, 1st arg - post type, 2nd arg - an array of varaibles
  register_post_type('event', array(
    //note: capability_type & map_meta_cap allows us to see the events for roles in the member section on the admin site
    'capability_type' => 'event', //post by timepost, grants custom permission to certain roles
    'map_meta_cap' => true, // hey wp can you require the right permission at the right time?
    'show_in_rest' => true, // if you need to register a custom post using the REST API inside the wp/v2 namespace
    'supports' => array('title', 'editor', 'excerpt'), //gives the user the ability to add a title, editor name and excerpt for each event
    'rewrite' => array('slug' => 'events'), //slug - part of a URL of the website, which allows the slug to be rewritten as events
    'has_archive' => true, //does it allow an archive page to group all similar events? then make it true
    'public' => true, //publically available to the public
    //adds in an array of labels to add or edit any events
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    ),
    'menu_icon' => 'dashicons-calendar' //adds in a little menu icon for the calendar
  ));

  // Program Post Type
  register_post_type('program', array(
    'show_in_rest' => true,
    'supports' => array('title'),
    'rewrite' => array('slug' => 'programs'),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program'
    ),
    'menu_icon' => 'dashicons-awards'
  ));

  // Professor Post Type
  register_post_type('professor', array(
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'public' => true,
    'labels' => array(
      'name' => 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor'
    ),
    'menu_icon' => 'dashicons-welcome-learn-more'
  ));

  // Note Post Type
  register_post_type('note', array(
    'capability_type' => 'note', //We want to grant permissions to certain users on using the note feature
    'map_meta_cap' => true, // hey wp can you require the right permission at the right time?
    'show_in_rest' => true,
    'supports' => array('title', 'editor'),
    'public' => false, //because we want our notes to be private only if the user is logged in
    'show_ui' => true, //but we still want these features to be shown in the front page
    'labels' => array(
      'name' => 'Notes',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Note',
      'singular_name' => 'Note'
    ),
    'menu_icon' => 'dashicons-welcome-write-blog'
  ));

  // Like Post Type
  register_post_type('like', array(
    'supports' => array('title'),
    'public' => false, //because we want our notes to be private only if the user is logged in
    'show_ui' => true, //but we still want these features to be shown in the front page
    'labels' => array(
      'name' => 'Likes',
      'add_new_item' => 'Add New Like',
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like'
    ),
    'menu_icon' => 'dashicons-heart'
  ));
}

/* adds a callback function to an action hook,
init - runs after wp has finished loading but before any headers are sent
so this adds the function university_post_types (from the top of this page) to be send to the action hook: init */
add_action('init', 'university_post_types');