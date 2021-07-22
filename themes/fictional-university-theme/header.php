<!-- This is the php file that is used for the header, such as the about us, links, etc-->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- this meta tag that tells the device to use their native size, allowing phone users to easily use the app -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
   <!-- The body_class function the data info of the page such as the page id number in the inspector on the browsers -->
  <body <?php body_class(); ?>>
    <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left"><a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a></h1>
      <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <ul>
             <!-- the if statements in the li tags is to check to see if the current page is on the targeted page, if so then highlight yellow -->
            <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 16) echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
            <li <?php if (get_post_type() == 'program') echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('program') ?>">Programs</a></li>
            <li <?php if (get_post_type() == 'event' OR is_page('past-events')) echo 'class="current-menu-item"';  ?>><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
            <li <?php if (get_post_type() == 'campus') echo 'class="current-menu-item"' ?>><a href="<?php echo get_post_type_archive_link('campus'); ?>">Campuses</a></li>
            <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
          </ul>
        </nav>
        <div class="site-header__util">
          <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
          <a href="#" class="btn btn--small  btn--dark-orange float-left">Sign Up</a>
          <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        </div>
      </div>
    </div>
  </header>
