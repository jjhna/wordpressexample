<!-- This file is a shortcut to reduce duplication of code, it can be called using: get_search_form();
    esc_url is a best security process similar to sanitize function 
            also gets the site url from the root url -->
<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>"> 
    <label class="headline headline--medium" for="s">Perform a New Search</label>
    <div class="search-form-row">
            <!-- this replaces the search variable with 's' instead of search -->
        <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s">
        <input class="search-submit" type="submit" value="Search">
    </div>
          
</form>