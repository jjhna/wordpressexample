<!-- This is the php file that is used for events for wp -->

<?php
  
  get_header();

  //While loop that checks WP to see if there are any events that are published
  while(have_posts()) {
      // The content of the post itself
    the_post(); 
    pageBanner();
    ?> <!-- Note that the php isn't closed until after we enter the while loop, since we want to loop
    through the entire events and just before the html tag -->

    <div class="container container--narrow page-section">
        
        <div class="generic-content">
            <div class="row group">
              <div class="one-third">
                <?php the_post_thumbnail('professorPortrait'); ?>
              </div>
              <div class="one-third">
                <?php the_content(); ?>
              </div>
            </div>
        </div>

        <?php 
          $relatedPrograms = get_field('related_programs');
          //print_r($relatedPrograms);
          //as long as the field has a value in the array then its always true
          if($relatedPrograms) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
            echo '<ul class="link-list min-list">';
            foreach($relatedPrograms as $program) { ?>
              <li><a href="<?php echo get_the_permalink($program); ?>">
              <?php echo get_the_title($program); ?></a></li>
    <?php  }
            echo '</ul>';
          }
        ?>
        
    </div>
    
    <!-- Note that the php isn't closed until after the last html tag or usage -->
  <?php }

  get_footer();

?>