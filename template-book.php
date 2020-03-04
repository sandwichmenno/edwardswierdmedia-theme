<?php /* Template Name: Boek */ ?>
<?php get_template_part( 'components/header' ); ?>

<section class="default book" id="header">
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

<section class="default book">
    <div class="container">
        <h1 style="text-align: center;"><?php echo get_post_meta( get_the_ID(), 'head_text', true );  ?></h1>
        <div class="content">
            <div class="left">
                <img src="<?php echo get_bloginfo('template_url'); ?>/images/mountainbike_boek.png">
                <!--<a href="/"><div class="button">Online aanschaffen</div></a>-->
                <h3 style="margin-top: 0;">19,99 euro</h3>
                <h4 style="text-align: center;">binnenkort verkrijgbaar</h4>
            </div>

            <div class="right">
                <?php
                while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                    <?php
                endwhile;
                wp_reset_query();
                ?>
                <div class="white-block">
                    EAN: 9789018045890<br/>
                    Paperback<br/>
                    194 pagina’s<br/>
                    Geïllustreerd, met fotografie van Leon van Bon, Joris Knapen, Cor Vos en Klaas Jan van der Weij
                </div>
            </div>
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
