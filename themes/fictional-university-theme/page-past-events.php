<!-- This page is for the blog "event" archive, so when you access a blog name, date or category -->

<?php

    get_header(); 
      pageBanner(array(
        'title' => 'Past Events',
        'subtitle' => 'A recap of our past events'
    ));
    ?>

    <div class="container container--narrow page-section">
        <?php
        $today = date('Ymd');
        $pastEvents = new WP_Query(array(
          'paged' => get_query_var('paged', 1),
          'post_type' => 'event',
          'meta-key' => 'event_date',
          'orderby' => 'meta_value',
          'order' => 'ASC',
          //Finds any event dates that are greater than todays date (later) to be displayed in the front page
          //otherwise older events or past events are removed from the front page
          'meta_query' => array(
            array(
              'key' => 'event_date',
              'compare' => '<',
              'value' => $today,
              'type' => 'numeric'
            )
          )
        ));
        //So note that $pastEvents-> indicates that its looking for posts inside that particular variable which is holding an array
            while ($pastEvents->have_posts()) {
                $pastEvents->the_post(); 
                get_template_part('template-parts/content-event');
              } 
                echo paginate_links(array(
                'total' => $pastEvents->max_num_pages
            )); //displays out the number blog posts pages in total. so if total 50 posts / 10 = about 5 pages. 
        ?>

    </div>

    <?php get_footer();
    
?>