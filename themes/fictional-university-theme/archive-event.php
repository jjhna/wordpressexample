<?php
//<!-- This page is for the blog "event" archive, so when you access a blog name, date or category -->
get_header(); //gets the header.php file functions and variables to ensure the header is placed on the top of every page
// gets the pageBanner function from the functions.php page that takes in the array of the title and subtitle 
//to ensure that it overwrites the default title, subtitle and photo
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.'
));
 ?>
<!-- the class container can be found in the css files and modules -->
<div class="container container--narrow page-section"> 
<?php
  
  while(have_posts()) {
    the_post(); 
    get_template_part('template-parts/content-event');
   }
  echo paginate_links(); //displays out the number blog posts pages in total. so if total 50 posts / 10 = about 5 pages. 
?>

<hr class="section-break">

<p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive</a>.</p>

</div>

<?php get_footer(); //gets the footer.php file functions and variables to ensure the footer is placed below each page

?>