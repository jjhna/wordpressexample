<?php
/* Note this page is to create a new search route such as: http://wordpressexample.local/wp-json/university/v1/search?term=math
which allows the user to create a new search route for the rest api allowing for a more accurate search. 
please also note this only makes the content readable (CRUD) and doesn't allow any creation, update and deletion at the moment.

adds in the universityRegisterSearch function below to the rest_api_init action hook
rest_api_init - fires when preparing  to serve a rest api request */
add_action('rest_api_init', 'universityRegisterSearch');

//creates a new namespace called "university/v1" with a route called search
//this gives the user a new url to search with
//
function universityRegisterSearch() {
  register_rest_route('university/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE, //Creates a new readable rest api for the user
    'callback' => 'universitySearchResults' //any of the results get returned to the universitySearchResults function below
  ));
}

//Takes in the universitySearchResults from the universityRegisterSearch with the data parameter to be used to post an array
// of different types of posts and also sanitized at the end
function universitySearchResults($data) {
  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
    //The 's' is for search and the keyword 'term' is used with the route for searching any of the type of post listed above
    //sanitized so that the a user cannot add in any miscellaneous type of code 
    's' => sanitize_text_field($data['term']) 
  ));

  //the instance of results contains an array of posts that also contain empty arrays for the searh queue
  $results = array(
    'generalInfo' => array(),
    'professors' => array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array()
  );

  /* while the mainquery instance from the universitySearchResults function contains a list of posts
  those posts will sift through the if statmenets to check the type of posts
  if the post meets a match then those results from the post type will return an array of data */
  while($mainQuery->have_posts()) {
    $mainQuery->the_post();

    //This will check if the post type is post or page if so then the results of the data will be displayed on the json page
    //This will return an array of the title, permalink, posttype and author name to the user. 
    if (get_post_type() == 'post' OR get_post_type() == 'page') {
      array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName' => get_the_author()
      ));
    }

    if (get_post_type() == 'professor') {
      array_push($results['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
      ));
    }

    if (get_post_type() == 'program') {
      $relatedCampuses = get_field('related_campus');
      //note that campuses are a bit more tricky since they lack content but we don't need to worry since we are using the campus page
      if ($relatedCampuses) {
        foreach($relatedCampuses as $campus) {
          array_push($results['campuses'], array(
            'title' => get_the_title($campus),
            'permalink' => get_the_permalink($campus)
          ));
        }
      }
    
      array_push($results['programs'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'id' => get_the_id() //note that we need to get the id because we need pinpoint accuracy of what we want to search for
      ));
    }

    if (get_post_type() == 'campus') {
      array_push($results['campuses'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }

    if (get_post_type() == 'event') {
      $eventDate = new DateTime(get_field('event_date'));
      $description = null;
      if (has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      }

      array_push($results['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'),
        'day' => $eventDate->format('d'),
        'description' => $description
      ));
    }
    
  }

  if ($results['programs']) {
    $programsMetaQuery = array('relation' => 'OR');
      //check the results from the program id page if it is similar to what the user is searching for 
    foreach($results['programs'] as $item) {
      array_push($programsMetaQuery, array(
          //checks the field of related program and compare it to the items id
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . $item['id'] . '"'
        ));
    }

    $programRelationshipQuery = new WP_Query(array(
      'post_type' => array('professor', 'event'),
      'meta_query' => $programsMetaQuery
    ));

    /* This while loop is to help find any data that is related to the search query
    for example if there is a professor that teaches math then this query will also pull him up
    overall as it says in its name: $programRelationshipQuery, its used to find relationship between data */
    while($programRelationshipQuery->have_posts()) {
      $programRelationshipQuery->the_post();

      if (get_post_type() == 'event') {
        $eventDate = new DateTime(get_field('event_date'));
        $description = null;
        if (has_excerpt()) {
          $description = get_the_excerpt();
        } else {
          $description = wp_trim_words(get_the_content(), 18);
        }

        array_push($results['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => $eventDate->format('M'),
          'day' => $eventDate->format('d'),
          'description' => $description
        ));
      }

      if (get_post_type() == 'professor') {
        array_push($results['professors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));
      }

    }

    //These two values below are important because they prevent any duplicate results
    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
  }


  return $results;

}