<?php
//This is the php file that is used for the my notes so that users can create, edit and delete
//their own posts/notes by using the rest of the CRUD operations

    //if the user is logged out then they are redirected to the front page
    if (!is_user_logged_in()) {
        wp_redirect(esc_url(site_url('/')));
        exit;
    }

  get_header(); //gets the header.php page methods and etc

    //While loop that checks WP to see if there are any pages that are published
  while(have_posts()) {
    the_post();  // The content of the post itself
    pageBanner();
     ?><!-- Note that the php isn't closed until after we enter the while loop, since we want to loop
     through the entire posts and just before the html tag -->
    
    <div class="container container--narrow page-section">
        <div class="create-note">
            <h2>Create New Note</h2>
            <input class="new-note-title" placeholder="Title">
            <textarea class="new-note-body" placeholder="Your note here..."></textarea>
            <span class="submit-note">Create New Note</span>
            <!-- this message below will only trigger if the user goes over the notes post limit -->
            <span class="note-limit-message">Note limit reached: delete an exisiting note</span>
        </div>
        <ul class="min-list link-list" id="my-notes">
            <?php 
                $userNotes = new WP_Query(array(
                    'post_type' => 'note',
                    'posts_per_page' => -1,
                    'author' => get_current_user_id()
                ));

                //The content of the notes with the ability to edit or delete those notes
                //Note that escape function such as esc_attr() prevent malicious code from being passed such as js scripts
                while ($userNotes->have_posts()) {
                    $userNotes->the_post(); ?>
                    <!-- The span class="edit or delete or update can all be found/used in the MyNotes.js file -->
                    <!-- Note: we need to get the note post ID number to tell the MyNotes.js what post to edit, delete, etc -->
                    <li data-id="<?php the_ID(); ?>">
                        <!-- The esc_attr() is need if you need to print out dynamic or generated text so that special characters won't break your HTML -->
                        <!-- str_replace takes 3 arguments: 1st the string you want to remove, 2nd the string you want to replace with and 3rd where this string is coming from -->
                        <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>">
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                        <!-- wp_strip_all_tags() removes all tags from the field preventing tags like <p></p> from being printed -->
                        <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                    </li>
              <?php  }
            ?>
        </ul>
    </div>
     <!-- Note that the php isn't closed until after the last html tag or usage -->
  <?php }

  get_footer();

?>