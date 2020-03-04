<?php
show_admin_bar( false );
add_theme_support( 'post-thumbnails' );

function enqueue_style() {
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('style', get_bloginfo('template_url') . '/style.css');

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/releases/v5.0.7/js/all.js');
}

add_action( 'wp_enqueue_scripts', 'enqueue_style' );

function google_fonts() {
    wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Oswald|Special+Elite');
    wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'google_fonts');

function register_menus() {
    register_nav_menu('front-menu',__( 'Frontpage Menu' ));
}
add_action( 'init', 'register_menus' );

function add_page_attributes() {
    add_post_type_support( 'page', 'page-attributes' );
}

add_action('init', 'add_page_attributes');

function custom_post_types() {
    register_post_type( 'social',
        array(
            'labels' => array(
                'name' => __( 'Social' ),
                'singular_name' => __( 'Social' ),
                'menu_name' => 'Social',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_admin_bar'   => true,
            'menu_icon' => 'dashicons-share',
            'supports' => array( 'title'),
            'register_meta_box_cb' => 'metaboxes',
        )
    );

    register_post_type( 'clients',
        array(
            'labels' => array(
                'name' => __( 'Clients' ),
                'singular_name' => __( 'Client' ),
                'menu_name' => 'Werkgevers',
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_admin_bar'   => true,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'register_meta_box_cb' => 'metaboxes',
        )
    );
}
add_action( 'init', 'custom_post_types' );

add_action( 'add_meta_boxes', 'page_meta' );
function page_meta() {
    add_meta_box(
        'head_text',
        'Koptekst',
        'head_text_fields',
        'page',
        'normal',
        'default'
    );
}

function metaboxes() {
    add_meta_box(
        'social_url',
        'Social page URL',
        'social_url_fields',
        'social',
        'normal',
        'default'
    );

    add_meta_box(
        'article_url',
        'Artikel URL',
        'article_url_fields',
        'clients',
        'normal',
        'default'
    );
}

function social_url_fields() {
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'event_fields' );
    $socialurl = get_post_meta( $post->ID, 'social_url', true );
    $socialicon = get_post_meta( $post->ID, 'social_icon', true );

    echo 'URL: <input type="text" name="socialurl" value="' . esc_textarea( $socialurl )  . '" class="widefat">';
    echo '<p>Fontawesome icon: <input type="text" name="socialicon" value="' . esc_textarea( $socialicon )  . '" class="widefat"></p>';
}

function head_text_fields() {
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'event_fields' );
    $headtext = get_post_meta( $post->ID, 'head_text', true );

    echo 'Koptekst: <input type="text" name="headtext" value="' . esc_textarea( $headtext )  . '" class="widefat">';
}

function article_url_fields() {
    global $post;
    $query_pdf_args = array(
        'post_type' => 'attachment',
        'post_mime_type' =>'application/pdf',
        'post_status' => 'inherit',
        'posts_per_page' => -1,
    );
    $query_pdf = new WP_Query( $query_pdf_args );
    $pdf = array();

    wp_nonce_field( basename( __FILE__ ), 'event_fields' );
    $articleurl = get_post_meta( $post->ID, 'article_url', true );

    echo '<select name="articleurl" id="articleurl">';
        echo '<option value="#">Geen bestand</option>';
        foreach ( $query_pdf->posts as $file) {
            echo '<option value="'.$pdf[]= $file->guid.'"'.($articleurl==$file->guid?' selected="selected"':'').'>'.$pdf[]= $file->guid.'</option>';
        }
    echo '</select>';
}

function save_meta( $post_id, $post ) {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    if ( ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
        return $post_id;
    }

    $events_meta['social_url'] = esc_textarea( $_POST['socialurl'] );
    $events_meta['social_icon'] = esc_textarea( $_POST['socialicon'] );
    $events_meta['head_text'] = esc_textarea( $_POST['headtext'] );
    $events_meta['article_url'] = esc_textarea( $_POST['articleurl'] );

    foreach ( $events_meta as $key => $value ) :
        if ( 'revision' === $post->post_type ) {
            return;
        }
        if ( get_post_meta( $post_id, $key, false ) ) {
            update_post_meta( $post_id, $key, $value );
        } else {
            add_post_meta( $post_id, $key, $value);
        }
        if ( ! $value ) {
            delete_post_meta( $post_id, $key );
        }
    endforeach;
}
add_action( 'save_post', 'save_meta', 1, 2 );