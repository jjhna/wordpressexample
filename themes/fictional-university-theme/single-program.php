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
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                <i class="fa fa-home" aria-hidden="true"></i>All Programs</a> 
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        
        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <!-- This looks inside the WP database itself to find any events that are related to a particular program -->
        <?php 
        $relatedProfessors = new WP_Query(array(
          'posts_per_page' => -1,
          'post_type' => 'professor',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'related_programs',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"'
            )
          )
        ));

        if ($relatedProfessors->have_posts()) {
          echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';

        echo '<ul class="professor-cards">';
        while($relatedProfessors->have_posts()) {
          $relatedProfessors->the_post(); ?>
          <li class="professor-card__list-item">
            <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>">
            <span class="professor-card__name"><?php the_title(); ?></span>
          </a></li>
        <?php }
        echo '</ul>';
        }

            //whenever you use multiple queries, 99% of the time you will end up using wp_reset_postdata
            wp_reset_postdata(); //a function that resets the global post object and functions such as the_title and the_ID 
            // so that they can be used in the queries below. 

            $today = date('Ymd');
            $homepageEvents = new WP_Query(array(
              'posts_per_page' => 2,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              //Finds any event dates that are greater than todays date (later) to be displayed in the front page
              //otherwise older events or past events are removed from the front page
              'meta_query' => array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                ),
                //if the related programs is equal to the ID of the program then return the array
                array(
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_ID() . '"'
                )
              )
            ));

            if ($homepageEvents->have_posts()) {
              echo '<hr class="section-break">';
              echo '<h2 class=headline headline--medium>Upcoming ' . get_the_title() . ' Events</h2>';

              while ($homepageEvents->have_posts()) {
                $homepageEvents->the_post();
                get_template_part('template-parts/content-event');
              }
            }
          ?>

    </div>
    
    <!-- Note that the php isn't closed until after the last html tag or usage -->
  <?php }

  get_footer();

?>