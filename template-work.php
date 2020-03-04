<?php /* Template Name: Voor wie werk ik */ ?>
<?php get_template_part( 'components/header' ); ?>

<section class="default" id="header">
    <div class="logo"><a href="http://edwardswiermedia.nl"><img src="<?php echo get_bloginfo('template_url'); ?>/images/esm_logo.jpg"/></a></div>
    <div class="menu"><?php wp_nav_menu( array( 'theme_location' => 'front-menu' ) ); ?></div>

    <div class="header-menu-hamburger">
        <div class="icon"><i class="fas fa-bars"></i></div>
        <div class="logonav"><a href="http://edwardswiermedia.nl"><img src="<?php echo get_bloginfo('template_url'); ?>/images/esm_logo.jpg"/></a></div>

        <nav class="nav">
            <?php wp_nav_menu( array( 'theme_location' => 'front-menu' ) ); ?>
        </nav>
    </div>
</section>

<section class="default" id="work">
    <div class="container">
        <?php
        while ( have_posts() ) : the_post(); ?>
            <div class="entry-content-page" style="width: 100%; text-align: center;">
                <?php the_content(); ?>
            </div>
            <?php
        endwhile;
        wp_reset_query();
        ?>

        <div class="row">
            <?php
            global $post;
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'clients',
				'orderby' => 'title',
                'order' => 'ASC',
            );
            $postslist = get_posts( $args );
            foreach ( $postslist as $post ) :
                setup_postdata( $post ); ?>

                <div class="cell">
                    <a href="<?php echo get_post_meta( get_the_ID(), 'article_url', true );  ?>" target="_blank">
                        <div class="overlay">
                            <span><i class="fas fa-file-pdf"></i></span>
                        </div>
                    </a>
                    <img src="<?php the_post_thumbnail_url(); ?>"/>
                </div>

                <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<script>
    jQuery(".header-menu-hamburger .icon").click(function(e) {
        var target = jQuery(e.target);

        if (jQuery(".header-menu-hamburger .icon").hasClass("open")) {
            jQuery(".menu").hide();
            jQuery(".logonav").show();
            jQuery(".header-menu-hamburger .icon").removeClass( "open" );
            jQuery(".header-menu-hamburger .icon").html('<i class="fas fa-bars"></i>');
        }
        else {
            jQuery(".menu").show();
            jQuery(".logonav").hide();
            jQuery(".header-menu-hamburger .icon").addClass( "open" );
            jQuery(".header-menu-hamburger .icon").html('<i class="fas fa-times"></i>');
        }
    });
</script>


<?php get_template_part( 'components/footer' ); ?>
