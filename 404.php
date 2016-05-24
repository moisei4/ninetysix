<?php
get_header();
?>
<div class="row">
    <div class="waves-main col-md-12">
        <section class="content">
            <div id="error404-container">
                <h1 class="error404"><?php esc_html_e("404", "ninetysix");?><span><?php esc_html_e("Not found!", "ninetysix");?></span></h1>
                <p class="error-msg">
                    <?php esc_html_e("We're sorry, the page you have looked for does not exist in our database!", "ninetysix");?><br/>
                    <?php printf(esc_html__("Perhaps you would like to go to our %s home page %s ?", "ninetysix"), '<a href="'.esc_url(home_url('/')).'">', '</a>');?>
                </p>
            </div>
        </section>
    </div>
</div>
<?php
get_footer();