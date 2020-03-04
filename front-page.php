<?php get_template_part( 'components/header' ); ?>

<section class="frontpage">
    <div class="half left">
        <div class="pencil">
            <img src="<?php echo get_bloginfo('template_url'); ?>/images/pencil_black.svg"/>
            <div class="stripes"></div>
        </div>


        <div class="header">Edward<br/>Swier <span class="media">Media</span> </div>
        <?php wp_nav_menu( array( 'theme_location' => 'front-menu' ) ); ?>

        <div class="social">
            <?php
            global $post;
            $args = array(
                'post_type' => 'social',
                'order' => 'ASC'
            );
            $postslist = get_posts( $args );
            foreach ( $postslist as $post ) :
                setup_postdata( $post ); ?>

                <div class="cell">
                    <a href="<?php echo get_post_meta( get_the_ID(), 'social_url', true );  ?>" target="_blank" class="item">
                        <i class="fab <?php echo get_post_meta( get_the_ID(), 'social_icon', true );  ?>"></i>
                    </a>
                </div>

                <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>

    <div class="half right">
        <div class="pencil"><img src="<?php echo get_bloginfo('template_url'); ?>/images/pencil_white.svg"</div></div>

        <div class="header">Media</div>
        <div class="about">
            <div class="info">
                <span class="phone"><a href="tel:06-24203671">06-24203671</a></span><br/>
                <a href="mailto:edwardswiermedia@gmail.com">edwardswiermedia@gmail.com</a>
            </div>
            <div class="photo"><img src="<?php echo get_bloginfo('template_url'); ?>/images/es_face.jpg" /></div>
        </div>
        <div class="credit">2018 © Edward Swier Media (ontwerp door <a href="http://sandwichdigital.nl" target="_blank">Sandwich Digital</a>)</div>
    </div>
</section>

<?php get_template_part( 'components/footer' ); ?>
