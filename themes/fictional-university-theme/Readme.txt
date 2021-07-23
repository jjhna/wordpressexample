What is WP? - wordpress is a "free" and open-source content managment system written in PHP with MYSQL or Maria DB database.
How does WP work? - Wp works by using themes as a template system for webpages. 

When to use 'echo' or not? - echo is used to return an output from a function. 
For example:
get_title() returns a string which isn't ouput so echo MUST be used
the_title() returns and ouputs a string which means echo doesn't need to be used.

To change any content of the admin page change the varaiblels from the /mu-plugins/university-post-types.PHP
To change any JS content go to /src/modules/Search.JS
To change css files go to the css page
To change a cusom url route go to /inc/search-route.PHP
To change the custom search feature (non-JS) go to /template-parts

Make sure to add in a git ignore file to prevent the git from committing the node_modules and any related npm fles

To enable the usage and updates from the JS files/section install and run npm:
Make sure to install and run npm by typing from the fictional-theme folder and type:
npm install
npm run start

