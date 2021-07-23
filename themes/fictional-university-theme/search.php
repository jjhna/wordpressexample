<?php
//The search page 
get_header();
pageBanner(array(
  'title' => 'Search Results',
  //get_search_query returns the search keyword that the user entered, it's also has false in a parameter
  // to prevent cross site attack to prevent code from being used. 
  //exc_html is also used to prevent even further attacks and prevent the page from returning an error
  'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;'
));
 ?>
     <!-- for more info on how the dates, times, button and excerpt works, look up the same methods on archive.php -->
<div class="container container--narrow page-section">
<?php
    if (have_posts()) {
        while(have_posts()) {
            the_post(); 
        
            //gets the method/variables from the template-parts folder/file
            get_template_part('template-parts/content', get_post_type()); }
            echo paginate_links();
    } else {
        echo '<h2 class="headline headline--small-plus">No results match those results</h2>';
    }

    get_search_form();
  
?>
</div>

<?php get_footer();

?>