<?php
//This page is for the blog "program" archive, note this the area where you want to remove certain features such as the posted by date, etc
get_header();
pageBanner(array(
  'title' => 'All Programs',
  'subtitle' => 'There is something for everyone. Have a look around.'
));
 ?>

<div class="container container--narrow page-section">
<!-- the class link-list can be found in the css files and modules -->
<ul class="link-list min-list">

<?php
  while(have_posts()) {
    the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
  <?php }
  echo paginate_links(); //displays out the number blog posts pages in total. so if total 50 posts / 10 = about 5 pages. 
?>
</ul>



</div>

<?php get_footer();

?>