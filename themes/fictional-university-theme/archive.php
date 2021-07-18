<!-- This page is for the blog archive, so when you access a blog name, date or category -->

<?php

    get_header(); ?>

    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>"></div>
      <div class="page-banner__content container container--narrow">
          <!-- displays the arhive title when someone clicks on a date, name, category, etc. -->
        <h1 class="page-banner__title"><?php the_archive_title(); ?></h1>
        <div class="page-banner__intro">
            <!-- the archieve description that is listed in the WP admin site -->
          <p><?php the_archive_description(); ?></p>
        </div>
      </div>
    </div>

    <div class="container container--narrow page-section">
        <?php
            while (have_posts()) {
                the_post(); ?>
                <div class="post-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                    <div class="metabox">
                        <!-- to look up information on the abbreviations for time and date, google it -->
                        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in 
                        <?php echo get_the_category_list(', ') ?></p> <!-- the category name, etc -->
                    </div>

                    <div class="generic-content">
                        <?php the_excerpt(); ?> 
                        <!-- a small excerpt from the blog post -->
                        <!-- the blue button for the continue reading button -->
                        <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
                    </div>
                </div>
           <?php } 
        ?>

        <?php 
            echo paginate_links(); //displays out the number blog posts pages in total. so if total 50 posts / 10 = about 5 pages. 
        ?>

    </div>

    <?php get_footer();
    
?>