<!-- This is the php file that is used for the footer -->

<footer class="site-footer">
      <div class="site-footer__inner container container--narrow">
        <div class="group">
          <div class="site-footer__col-one">
            <h1 class="school-logo-text school-logo-text--alt-color">
              <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
            </h1>
            <p><a class="site-footer__link" href="#">555.555.5555</a></p>
          </div>

          <div class="site-footer__col-two-three-group">
            <div class="site-footer__col-two">
              <h3 class="headline headline--small">Explore</h3>
              <nav class="nav-list">

              <!-- lists out the menus from the wordpress menus -->
                <?php 
                    //wp_nav_menu takes only an associative array and gets the value from the functions.php page or 
                    //register_nav_menu('headerMenuLocation', 'Header Menu Location');
                    wp_nav_menu(array(
                        'theme_location' => 'footerLocationOne'
                    ));
                ?>

                <!-- <ul>
                  <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                  <li><a href="#">Programs</a></li>
                  <li><a href="#">Events</a></li>
                  <li><a href="#">Campuses</a></li>
                </ul> -->
              </nav>
            </div>

            <div class="site-footer__col-three">
              <h3 class="headline headline--small">Learn</h3>
              <nav class="nav-list">

              <!-- lists out the menus from the wordpress menus -->
              <?php 
                    //wp_nav_menu takes only an associative array and gets the value from the functions.php page or 
                    //register_nav_menu('headerMenuLocation', 'Header Menu Location');
                    wp_nav_menu(array(
                        'theme_location' => 'footerLocationTwo'
                    ));
                ?>

                <!-- <ul>
                  <li><a href="#">Legal</a></li>
                  <li><a href="<?php echo site_url('/privacy-policy') ?>">Privacy</a></li>
                  <li><a href="#">Careers</a></li>
                </ul> -->
              </nav>
            </div>
          </div>

          <div class="site-footer__col-four">
            <h3 class="headline headline--small">Connect With Us</h3>
            <nav>
              <ul class="min-list social-icons-list group">
                <li>
                  <a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </footer>

    <!-- Pulls up the admin bar that you see on the top -->
    <!-- This also pulls in the JS files, note even in regular web dev you place the JS context at the bottom so it doesn't slow down the 
    loading of the webpage  -->
<?php wp_footer(); ?>
</body>
</html>