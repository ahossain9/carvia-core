<?php

/**
 * Custom Post Types and Taxonomies for Carvia Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Carvia_Core_Post_Types
{

    public function __construct()
    {
        // Register types and tax
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'carvia_flush_rewrite_rules'), 999);

        // Essential Elementor Support
        add_action('elementor/init', array($this, 'add_elementor_support'));
        add_action('init', array($this, 'set_elementor_settings'), 20);

        // Force Template for Builder
        add_filter('template_include', array($this, 'force_elementor_canvas'), 99);
    }

    public function register_post_types()
    {
        // ---------------------------------------------
        // Header Custom Post Type
        // ---------------------------------------------
        $header_labels = array(
            'name'               => __('Headers', 'carvia-core'),
            'singular_name'      => __('Header', 'carvia-core'),
            'add_new'            => __('Add New', 'carvia-core'),
            'add_new_item'       => __('Add New Header', 'carvia-core'),
        );

        $header_args = array(
            'labels'             => $header_labels,
            'public'             => true,
            'publicly_queryable' => true, // Essential for Elementor
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'header'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-welcome-widgets-menus',
            'supports'           => array('title', 'editor', 'elementor'),
            'show_in_rest'       => true, // Essential for modern builders
        );
        register_post_type('header', $header_args);

        // ---------------------------------------------
        // Footer Custom Post Type
        // ---------------------------------------------
        $footer_labels = array(
            'name'               => __('Footers', 'carvia-core'),
            'singular_name'      => __('Footer', 'carvia-core'),
            'add_new'            => __('Add New', 'carvia-core'),
            'add_new_item'       => __('Add New Header', 'carvia-core'),
        );

        $footer_args = array(
            'labels'             => $footer_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'rewrite'            => array('slug' => 'footer'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-editor-kitchensink',
            'supports'           => array('title', 'editor', 'elementor'),
            'show_in_rest'       => true,
        );

        register_post_type('footer', $footer_args);

        // ---------------------------------------------
        // Service Custom Post Type
        // ---------------------------------------------
        $service_labels = array(
            'name'                  => __('Services', 'Post type general name', 'carvia-core'),
            'singular_name'         => __('Service', 'Post type singular name', 'carvia-core'),
            'menu_name'             => __('Services', 'Admin Menu text', 'carvia-core'),
            'name_admin_bar'        => __('Service', 'Add New on Toolbar', 'carvia-core'),
            'add_new'               => __('Add New', 'carvia-core'),
            'add_new_item'          => __('Add New Service', 'carvia-core'),
            'new_item'              => __('New Service', 'carvia-core'),
            'edit_item'             => __('Edit Service', 'carvia-core'),
            'view_item'             => __('View Service', 'carvia-core'),
            'all_items'             => __('All Services', 'carvia-core'),
            'search_items'          => __('Search Services', 'carvia-core'),
            'parent_item_colon'     => __('Parent Services:', 'carvia-core'),
            'not_found'             => __('No services found.', 'carvia-core'),
            'not_found_in_trash'    => __('No services found in Trash.', 'carvia-core'),
            'featured_image'        => __('Service Image', 'carvia-core'),
            'set_featured_image'    => __('Set service image', 'carvia-core'),
            'remove_featured_image' => __('Remove service image', 'carvia-core'),
            'use_featured_image'    => __('Use as service image', 'carvia-core'),
            'archives'              => __('Service Archives', 'carvia-core'),
            'insert_into_item'      => __('Insert into service', 'carvia-core'),
            'uploaded_to_this_item' => __('Uploaded to this service', 'carvia-core'),
            'filter_items_list'     => __('Filter services list', 'carvia-core'),
            'items_list_navigation' => __('Services list navigation', 'carvia-core'),
            'items_list'            => __('Services list', 'carvia-core'),
        );

        $service_args = array(
            'labels'             => $service_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'services'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 7,
            'menu_icon'          => 'dashicons-admin-page',
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'thumbnail', 'elementor'),
            'taxonomies'         => array('service_category'),
        );

        register_post_type('services', $service_args);

        // ---------------------------------------------
        // Cars Custom Post Type
        // ---------------------------------------------
        $cars_labels = array(
            'name'                  => __('Cars', 'Post type general name', 'carvia-core'),
            'singular_name'         => __('Car', 'Post type singular name', 'carvia-core'),
            'menu_name'             => __('Cars', 'Admin Menu text', 'carvia-core'),
            'name_admin_bar'        => __('Cars', 'Add New on Toolbar', 'carvia-core'),
            'add_new'               => __('Add New', 'carvia-core'),
            'add_new_item'          => __('Add New Cars', 'carvia-core'),
            'new_item'              => __('New Cars', 'carvia-core'),
            'edit_item'             => __('Edit Cars', 'carvia-core'),
            'view_item'             => __('View Cars', 'carvia-core'),
            'all_items'             => __('All Cars', 'carvia-core'),
            'search_items'          => __('Search Cars', 'carvia-core'),
            'parent_item_colon'     => __('Parent Cars:', 'carvia-core'),
            'not_found'             => __('No cars found.', 'carvia-core'),
            'not_found_in_trash'    => __('No cars found in Trash.', 'carvia-core'),
            'featured_image'        => __('Cars Image', 'carvia-core'),
            'set_featured_image'    => __('Set cars image', 'carvia-core'),
            'remove_featured_image' => __('Remove cars image', 'carvia-core'),
            'use_featured_image'    => __('Use as cars image', 'carvia-core'),
            'archives'              => __('Cars Archives', 'carvia-core'),
            'insert_into_item'      => __('Insert into cars', 'carvia-core'),
            'uploaded_to_this_item' => __('Uploaded to this cars', 'carvia-core'),
            'filter_items_list'     => __('Filter cars list', 'carvia-core'),
            'items_list_navigation' => __('Cars list navigation', 'carvia-core'),
            'items_list'            => __('Cars list', 'carvia-core'),
        );

        $cars_args = array(
            'labels'             => $cars_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'cars'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 8,
            'menu_icon'          => 'dashicons-portfolio',
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'taxonomies'         => array('cars_category'),
        );

        register_post_type('cars', $cars_args);
    }

    public function register_taxonomies()
    {
        // Service Category
        $service_cat_labels = array(
            'name'              => __('Service Categories', 'taxonomy general name', 'carvia-core'),
            'singular_name'     => __('Service Category', 'taxonomy singular name', 'carvia-core'),
            'search_items'      => __('Search Service Categories', 'carvia-core'),
            'all_items'         => __('All Service Categories', 'carvia-core'),
            'parent_item'       => __('Parent Service Category', 'carvia-core'),
            'parent_item_colon' => __('Parent Service Category:', 'carvia-core'),
            'edit_item'         => __('Edit Service Category', 'carvia-core'),
            'update_item'       => __('Update Service Category', 'carvia-core'),
            'add_new_item'      => __('Add New Service Category', 'carvia-core'),
            'new_item_name'     => __('New Service Category Name', 'carvia-core'),
            'menu_name'         => __('Categories', 'carvia-core'),
        );

        register_taxonomy('service_category', array('services'), array(
            'hierarchical'      => true,
            'labels'            => $service_cat_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service-category'),
            'show_in_rest'      => true,
        ));

        // Cars Category
        $cars_cat_labels = array(
            'name'              => _x('Cars Categories', 'taxonomy general name', 'carvia-core'),
            'singular_name'     => _x('Cars Category', 'taxonomy singular name', 'carvia-core'),
            'search_items'      => __('Search Cars Categories', 'carvia-core'),
            'all_items'         => __('All Cars Categories', 'carvia-core'),
            'parent_item'       => __('Parent Cars Category', 'carvia-core'),
            'parent_item_colon' => __('Parent Cars Category:', 'carvia-core'),
            'edit_item'         => __('Edit Cars Category', 'carvia-core'),
            'update_item'       => __('Update Cars Category', 'carvia-core'),
            'add_new_item'      => __('Add New Cars Category', 'carvia-core'),
            'new_item_name'     => __('New Cars Category Name', 'carvia-core'),
            'menu_name'         => __('Categories', 'carvia-core'),
        );

        register_taxonomy('cars_category', array('cars'), array(
            'hierarchical'      => true,
            'labels'            => $cars_cat_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'cars-category'),
            'show_in_rest'      => true,
        ));
    }

    public function add_elementor_support()
    {
        add_post_type_support('header', 'elementor');
        add_post_type_support('footer', 'elementor');
        add_post_type_support('services', 'elementor');
        add_post_type_support('cars', 'elementor');
    }

    public function set_elementor_settings()
    {
        $cpt_support = get_option('elementor_cpt_support');
        $carvia_types = array('services', 'cars', 'header', 'footer');

        if (!$cpt_support) {
            update_option('elementor_cpt_support', array_merge(array('post', 'page'), $carvia_types));
        } else {
            $update_needed = false;
            foreach ($carvia_types as $type) {
                if (!in_array($type, $cpt_support)) {
                    $cpt_support[] = $type;
                    $update_needed = true;
                }
            }
            if ($update_needed) {
                update_option('elementor_cpt_support', $cpt_support);
            }
        }
    }

    /**
     * Force Elementor Canvas for Header and Footer CPTs
     */
    public function force_elementor_canvas($template)
    {
        if (is_singular(array('header', 'footer'))) {
            // Check for Elementor's native canvas first (This is the safest way to stop the spinning)
            if (defined('ELEMENTOR_PATH')) {
                $canvas = ELEMENTOR_PATH . 'modules/page-templates/templates/canvas.php';
                if (file_exists($canvas)) {
                    return $canvas;
                }
            }
        }
        return $template;
    }

    public static function activate()
    {
        self::register_post_types();
        self::register_taxonomies();
        flush_rewrite_rules();
    }
    public function carvia_flush_rewrite_rules()
    {
        $rewrite_version = '1.0.0';

        if (get_option('carvia_rewrite_version') !== $rewrite_version) {
            flush_rewrite_rules(false);
            update_option('carvia_rewrite_version', $rewrite_version);
        }
    }
}

// Initialize the class
new Carvia_Core_Post_Types();

// Activation hook
register_activation_hook(CARVIA_CORE_FILE, array('Carvia_Core_Post_Types', 'activate'));