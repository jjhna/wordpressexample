<!-- This is the php file that is used for the header, such as the about us, links, etc-->

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
      <meta charset="<?php bloginfo('charset'); ?>">
      <!-- this meta tag that tells the device to use their native size, allowing phone users to easily use the app -->
      <meta name="viewport" content="width=device-width, initial-scale = 1">
    <?php wp_head(); ?>
  </head>
  <!-- The body_class function the data info of the page such as the page id number in the inspector on the browsers -->
  <body <?php body_class(); ?>>
    <header class="site-header">
      <div class="container">
        <h1 class="school-logo-text float-left">
          <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
        </h1>
        <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">

            <!-- lists out the menus from the wordpress menus -->
            <?php 
                //wp_nav_menu takes only an associative array and gets the value from the functions.php page or 
                //register_nav_menu('headerMenuLocation', 'Header Menu Location');
                wp_nav_menu(array(
                    'theme_location' => 'headerMenuLocation'
                ));
            ?>

            <!-- <ul>
              <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
              <li><a href="#">Programs</a></li>
              <li><a href="#">Events</a></li>
              <li><a href="#">Campuses</a></li>
              <li><a href="#">Blog</a></li>
            </ul> -->
          </nav>
          <div class="site-header__util">
            <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
            <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
            <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
          </div>
        </div>
      </div>
    </header>