<!-- This page is for the blog "event" archive, so when you access a blog name, date or category -->

<?php

    get_header(); 
    pageBanner(array(
      'title' => 'All Events',
      'subtitle' => 'See what is going on in batmans world.'
    ));
    ?>

    <div class="container container--narrow page-section">
        <?php
            while (have_posts()) {
                the_post(); 
                get_template_part('template-parts/content-event');
              } 
           echo paginate_links(); //displays out the number blog posts pages in total. so if total 50 posts / 10 = about 5 pages. 
        ?>
        <hr class="section-break">
        <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events'); ?>">
        Check out our past events archive</a></p>

    </div>

    <?php get_footer();
    
?>