<!-- This is the php file that is used for posts for wp -->

<?php
  
  get_header();

  //While loop that checks WP to see if there are any pages that are published
  while(have_posts()) {
      // The content of the post itself
    the_post(); 
    pageBanner();
    ?> <!-- Note that the php isn't closed until after we enter the while loop, since we want to loop
    through the entire pages and just before the html tag -->
    
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
            <a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>">
                <i class="fa fa-home" aria-hidden="true"></i>Blog Home</a> 
                <span class="metabox__main">Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in 
                        <?php echo get_the_category_list(', ') ?></span>
            </p>
        </div>
        
        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>
    
    <!-- Note that the php isn't closed until after the last html tag or usage -->
  <?php }

  get_footer();

?>