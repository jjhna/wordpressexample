<!-- This is the php file for the index page or maing front page when accessing the WP website -->
<!--Adds in the header from the header.php -->
<?php get_header(); ?>

  <div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>);"></div>
    <div class="page-banner__content container t-center c-white">
      <h1 class="headline headline--large">Welcome!</h1>
      <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
      <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
      <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
    </div>
  </div>

  <div class="full-width-split group">
    <div class="full-width-split__one">
      <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
        <!-- posts the events by the most upcoming event date and hide previous events from the front page -->
        <!-- This is a prime example of a custom query -->
        <?php 
          $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            //Finds any event dates that are greater than todays date (later) to be displayed in the front page
            //otherwise older events or past events are removed from the front page
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              )
            )
          ));

          while($homepageEvents->have_posts()) {
            $homepageEvents->the_post();
            get_template_part('template-parts/content', 'event');
          }
        ?>
        
        <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event') ?>" class="btn btn--blue">View All Events</a></p>

      </div>
    </div>
    <div class="full-width-split__two">
      <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
        <?php
        /* This below is an example of a "Custom Query", rather than WP default query ex: WP knows the default post limit per page 
          is 10 but for custom query you tell WP: "I don't care what it says or what page I'm on, if I'm on this page. do this"
          This is a custom query that gets the 2 most common posts and puts them on the front page
          example of an object class being created, homepagePosts is an object and an instance of WP_Query
          for this instance the homePagePosts object takes in a array of what pages/stuff you are trying to query or display */
          $homepagePosts = new WP_Query(array(
            'posts_per_page' => 2 //the custom query is only looking for 2 posts per page
          ));

          //the while loop goes through all and any possible posts by using the 
            // previous object: homepagePosts to look into to find both the have_posts() function and the_title() function
          while ($homepagePosts->have_posts()) {
            $homepagePosts->the_post(); ?>
            <div class="event-summary">
              <!-- the yellow circle with the date also clickable to the link of the blog post -->
              <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
                <span class="event-summary__month"><?php the_time('M'); ?></span>
                <span class="event-summary__day"><?php the_time('d'); ?></span>  
              </a>
              <!-- contains both the permalink for the title and read more buttons -->
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <!-- the trim function, gets the blog content and trims it to 1 word (supposdly this looks like 1 line) -->
                        <!-- if the blog has an excerpt then dispaly the excerpt otherwise get the content but only a trimmed version of it -->
                <p><?php if (has_excerpt()) {
                    echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                    } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
              </div>
            </div>
          <?php } wp_reset_postdata(); //reset the WP variables and such after being used, similar to a destructor or garbage collector
        ?> 

        
        
        
        <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">View All Blog Posts</a></p>
      </div>
    </div>
  </div>

  <div class="hero-slider">
    <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
    <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg'); ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Free Transportation</h2>
        <p class="t-center">All students have free unlimited bus fare.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
  <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg'); ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">An Apple a Day</h2>
        <p class="t-center">Our dentistry program recommends eating apples.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
  <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg'); ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Free Food</h2>
        <p class="t-center">Fictional University offers lunch plans for those in need.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
    </div>
      <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]">
      </div>
    </div>
  </div>

  <?php get_footer();

?>