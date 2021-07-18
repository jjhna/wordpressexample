<!-- This is the php file that is used for pages for wp -->

<?php

  get_header();

  //While loop that checks WP to see if there are any pages that are published
  while(have_posts()) {
      // The content of the post itself
    the_post(); ?> <!-- Note that the php isn't closed until after we enter the while loop, since we want to loop
    through the entire posts and just before the html tag -->
    <h1>This is a page not a post</h1>
    <h2><?php the_title(); ?></h2> <!-- Displays the posts title from WP -->
    <?php the_content(); ?> <!-- Displays the posts content from WP -->
    
    <!-- Note that the php isn't closed until after the last html tag or usage -->
  <?php }

  get_footer();

?>