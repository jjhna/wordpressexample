<?php
//Doesn't need a closing tag because this file will be pure php
//Note that this needs to be triggered in the top portion of the functions.php file
//Ex: require get_theme_file_path('/inc/like-route.php');

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes() {
    //This will register a route for our like buttons
    //we need to create both functions for clicking the like button and reclicking on it 
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

//This is the content and title that will be posted if a user clicks on the like button on the professors page
function createLike($data) {
    // we need to make sure that the user is logged in first
    if (is_user_logged_in()) {
        //The only data that we need to get is the professorId number
        $professor = sanitize_text_field($data['professorId']);
        
          $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            //Check to see if the professor id matches the search, if so then we can caluclate the number of likes
            //and return it to show the number of likes on a professor
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professor
              )
            )
          ));

          //an if statemnet that uses the existQuery and looks inside to see if there are any posts
          //if not then we can like the professor, otherwise if there already is a like post
          //then it means that we cannot like the professor since you can like them only once
          if ($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor') {
            return wp_insert_post(array(
              'post_type' => 'like',
              'post_status' => 'publish',
              'post_title' => '2nd PHP Test',
              'meta_input' => array(
                'liked_professor_id' => $professor
              )
            ));
          } else {
            die("Invalid professor id");
          }

    } else {
        //otherwise the server will die (exit the function) and return an error message
        die("Only logged in users can create a like.");
    }

    //The only data that we need to get is the professorId number
    $professor = sanitize_text_field($data['professorId']);

    wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => 'Our php creat post test',
        'post_content' => 'hello world',
        'meta_input' => array(
            'liked_professor_id' => $professor
        )
    ));
}

function deleteLike($data) {
    $likeId = sanitize_text_field($data['like']);
    if (get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
      wp_delete_post($likeId, true);
      return 'Congrats, like deleted.';
    } else {
      die("You do not have permission to delete that.");
    }
  }