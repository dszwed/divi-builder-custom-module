<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class wp360_ET_Builder_Recent_Posts extends ET_Builder_Module {

    function init () {
        $this->name = __( 'My Recent posts', 'wp360-textdomain' );
        $this->slug = 'et_pb_my_recent_posts';

        $this->whitelisted_fields = array(
            'number_of_posts',
            'title',
            'show_excerpt',
            'show_meta',
            'show_date',
            'category'
        );

        $this->fields_defaults = array(
            'number_of_posts' => array( 3, 'add_default_setting' ),
            'title' => array( 'Recent posts', 'add_default_setting' ),
            'category' => array( 'All', 'add_default_setting' )
        );

        $this->main_css_element = '%%order_class%%';
    }

    function get_fields () {
        $fields = array(
            'number_of_posts' => array(
                'label' => __( 'Number of posts', 'wp360-textdomain' ),
                'type' => 'text',
                'description' => __( 'Number of posts to display. Use -1 to display all', 'wp360-textdomain' ),
            ),
            'title' => array(
                'label' => __( 'Title', 'wp360-textdomain' ),
                'type' => 'text',
                'description' => __( 'Leave empty to not display', 'wp360-textdomain' ),
            ),
            'show_excerpt' => array(
                'label' => __( 'Show excerpt', 'wp360-textdomain' ),
                'type' => 'yes_no_button',
                'options' => array(
                    'on' => __( 'On', 'wp360-textdomain' ),
                    'off' => __( 'Off', 'wp360-textdomain' ),
                )
            ),
            'show_meta' => array(
                'label' => __( 'Show meta', 'wp360-textdomain' ),
                'type' => 'yes_no_button',
                'options' => array(
                    'on' => __( 'On', 'wp360-textdomain' ),
                    'off' => __( 'Off', 'wp360-textdomain' ),
                ),
                'affects' => array(
                    '#et_pb_show_date'
                ),
            ),
            'show_date' => array(
                'label' => __( 'Show date', 'my-text-domain' ),
                'type' => 'yes_no_button',
                'options' => array(
                    'on' => __( 'On', 'my-text-domain' ),
                    'off' => __( 'Off', 'my-text-domain' ),
                ),
                'depends_show_if' => 'on',
            ),
            'category' => array(
                'label' => __( 'Show meta', 'wp360-textdomain' ),
                'type' => 'select',
                'options' => wp360_get_categories()
            )
        );
        return $fields;
    }

    function shortcode_callback ( $atts, $content = null, $function_name ) {
        $number_of_posts = $this->shortcode_atts['product_id'];
        $title = $this->shortcode_atts['title'];
        $show_excerpt = filter_var( $this->shortcode_atts['show_excerpt'], FILTER_VALIDATE_BOOLEAN);
        $show_meta = filter_var( $this->shortcode_atts['show_meta'], FILTER_VALIDATE_BOOLEAN);
        $show_date = filter_var( $this->shortcode_atts['show_date'], FILTER_VALIDATE_BOOLEAN);
        $category = $this->shortcode_atts['category'];
        
        $html = '<h1>'. $title .'</h1>';
        
        $posts = new WP_Query(array(
            'posts_per_page' => $number_of_posts,
            'category' => $category
        ));
        ob_start();
        while($posts->have_posts()) {
            $posts->the_post();
            include('templates/post.php');
        }
        
        
        $html .= ob_get_clean();
        ob_end_clean();
        wp_reset_postdata();

        return '<div class="et_pb_module">' . $html . '</div>';
    }

}

new wp360_ET_Builder_Recent_Posts;
