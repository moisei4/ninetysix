<?php get_header();
the_post();

        echo '<div class="row">';
        echo '<div class="content-area col-md-12">';
            echo '<div class="entry-content">';
                the_content();
            echo '</div>';
            wp_link_pages();
            comments_template('', true);
        echo '</div>';
        echo '</div>';
    
get_footer();