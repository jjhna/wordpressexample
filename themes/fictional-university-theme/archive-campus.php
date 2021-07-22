<?php
//Note that we won't be using this for our website due to the lack of a google map api (which we would have to pay)
get_header();
pageBanner(array(
  'title' => 'Our Campuses',
  'subtitle' => 'We have several conveniently located campuses.'
));
 ?>

<div class="container container--narrow page-section">

<div class="acf-map">

<?php
  while(have_posts()) {
    the_post();
    $mapLocation = get_field('map_location');
   ?>
    <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      <?php echo $mapLocation['address']; ?>
    </div>
  <?php } ?>
</div>



</div>

<?php get_footer();

?>