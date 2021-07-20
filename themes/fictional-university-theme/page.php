<!-- This is the php file that is used for pages for wp -->

<?php

  get_header();

  //While loop that checks WP to see if there are any pages that are published
  while(have_posts()) {
      // The content of the post itself
    the_post(); 
    pageBanner(array(
      'title' => 'Hello there this is the title',
      'subtitle' => 'Hi this is the subtitle'
    ));
    ?> <!-- Note that the php isn't closed until after we enter the while loop, since we want to loop
    through the entire posts and just before the html tag -->

    <div class="container container--narrow page-section">

        <?php
            // the variable theParent that shortens the ID statement
            $theParent = wp_get_post_parent_id(get_the_ID());
        
            // an if statement that checks if the current page is the parent page. If it is a parent page then it returns a number.
            // otherwise it will return a 0 or zero which will indicate a false for the if statement. 
            
            if ($theParent) { ?>
                <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>">
              <i class="fa fa-home" aria-hidden="true"></i> <?php echo get_the_title($theParent); ?> </a> 
              <span class="metabox__main"><?php the_title(); ?></span>
        </p>
      </div>
          <?php  }
        ?>

    <?php 
    //The get_pages searches through any possible child pages that the parent page might have, if they do exist then 
    // it returns the number otherwise it returns a 0 which will indicate false in an if statement. 
    $testArray = get_pages(array (
        'child of' => get_the_ID()
    ));

    // <!-- if the current page has a parent or is a parent... -->
    if ($theParent or $testArray) { ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent) ?></a></h2>
        <ul class="min-list">
          <?php 
            if ($theParent) {
                $findChildrenOf = $theParent;
            } else {
                $findChildrenOf = get_the_ID();
            }

            // An associative array - when you associate an value to each item, similar to a dictionary
            // example:
            //     $animalSounds = array ('cat' => 'meow', 'dog' => 'bark'); echo $animalSounds['dog']; prints out bark
            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order' //Sorts the menu in a specifi order
            ));
          ?>
        </ul>
      </div> <?php } ?> 

      <div class="generic-content">
          <?php the_content(); ?>
        </div>
    </div>

    
    <!-- Note that the php isn't closed until after the last html tag or usage -->
  <?php }

  get_footer();

?>