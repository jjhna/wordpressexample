<?php
//This page is for the blog archive, so when you access a blog name, date or category
get_header();
pageBanner(array(
  'title' => get_the_archive_title(),
  'subtitle' => get_the_archive_description()
));
 ?>

<div class="container container--narrow page-section">
<?php
  while(have_posts()) {
    the_post(); ?>
    <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      
      <div class="metabox">
        <!-- to look up information on the abbreviations for time and date, google it -->
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p> <!-- the category name, etc -->
      </div>

      <div class="generic-content">
        <?php the_excerpt(); ?>
        <!-- a small excerpt from the blog post -->
        <!-- the blue button for the continue reading button -->
        <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
      </div>

    </div>
  <?php }
  echo paginate_links();
?>
</div>

<?php get_footer();

?>