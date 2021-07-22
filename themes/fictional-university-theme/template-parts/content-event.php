<!-- The content from the event section so that the dates: month & day + link + tile + bits of the content, this entire page can be repeatedly used in different files -->
<div class="event-summary">
  <a class="event-summary__date t-center" href="#">
    <span class="event-summary__month"><?php
      //Create a new varaible/instance called eventDate which contains the date 
      $eventDate = new DateTime(get_field('event_date'));
      //echo - output the results from the eventdate month
      //the -> is used to call a method of an instance 
      echo $eventDate->format('M')
    ?></span>
    <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>  
  </a>
  <div class="event-summary__content">
    <!-- Prints out the title and have that tile as a permalink -->
    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    <!-- If the post has an excerpt then return back the trimed parts of the content -->
    <p><?php if (has_excerpt()) {
        echo get_the_excerpt();
      } else {
        echo wp_trim_words(get_the_content(), 18);
        } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
  </div>
</div>