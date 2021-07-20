
<!-- This page is for the blog "program" archive, note this the area where you want to remove certain features such as the posted by date, etc -->

<?php

    get_header(); 
    pageBanner(array(
      'title' => 'ALl Programs',
      'subtitle' => 'There is something in batmans cave and its not bats'
    ));
    ?>

    <div class="container container--narrow page-section">
        <ul class="link-list min-list">
        <?php
            while (have_posts()) {
                the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
           <?php } 
           echo paginate_links(); //displays out the number blog posts pages in total. so if total 50 posts / 10 = about 5 pages. 
        ?>
        </ul>

    </div>

    <?php get_footer();
    
?>