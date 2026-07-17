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
            'rewrite'            => array('slug' => 'carvia-header'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-welcome-widgets-menus',
            'supports'           => array('title', 'editor', 'elementor'),
            'show_in_rest'       => true, // Essential for modern builders
        );
        register_post_type('carvia-header', $header_args);

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
            'rewrite'            => array('slug' => 'carvia-footer'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-editor-kitchensink',
            'supports'           => array('title', 'editor', 'elementor'),
            'show_in_rest'       => true,
        );

        register_post_type('carvia-footer', $footer_args);

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
            'rewrite'            => array('slug' => 'service'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 7,
            'menu_icon'          => 'dashicons-admin-page',
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'thumbnail', 'elementor'),
            'taxonomies'         => array('carvia_service_category'),
        );

        register_post_type('carvia-service', $service_args);

        // ---------------------------------------------
        // Project Custom Post Type
        // ---------------------------------------------
        $project_labels = array(
            'name'                  => __('Projects', 'Post type general name', 'carvia-core'),
            'singular_name'         => __('Project', 'Post type singular name', 'carvia-core'),
            'menu_name'             => __('Projects', 'Admin Menu text', 'carvia-core'),
            'name_admin_bar'        => __('Project', 'Add New on Toolbar', 'carvia-core'),
            'add_new'               => __('Add New', 'carvia-core'),
            'add_new_item'          => __('Add New Project', 'carvia-core'),
            'new_item'              => __('New Project', 'carvia-core'),
            'edit_item'             => __('Edit Project', 'carvia-core'),
            'view_item'             => __('View Project', 'carvia-core'),
            'all_items'             => __('All Projects', 'carvia-core'),
            'search_items'          => __('Search Projects', 'carvia-core'),
            'parent_item_colon'     => __('Parent Projects:', 'carvia-core'),
            'not_found'             => __('No projects found.', 'carvia-core'),
            'not_found_in_trash'    => __('No projects found in Trash.', 'carvia-core'),
            'featured_image'        => __('Project Image', 'carvia-core'),
            'set_featured_image'    => __('Set project image', 'carvia-core'),
            'remove_featured_image' => __('Remove project image', 'carvia-core'),
            'use_featured_image'    => __('Use as project image', 'carvia-core'),
            'archives'              => __('Project Archives', 'carvia-core'),
            'insert_into_item'      => __('Insert into project', 'carvia-core'),
            'uploaded_to_this_item' => __('Uploaded to this project', 'carvia-core'),
            'filter_items_list'     => __('Filter projects list', 'carvia-core'),
            'items_list_navigation' => __('Projects list navigation', 'carvia-core'),
            'items_list'            => __('Projects list', 'carvia-core'),
        );

        $project_args = array(
            'labels'             => $project_labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'project'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 8,
            'menu_icon'          => 'dashicons-portfolio',
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'taxonomies'         => array('carvia_project_category'),
        );

        register_post_type('carvia-project', $project_args);
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

        register_taxonomy('carvia_service_category', array('carvia-service'), array(
            'hierarchical'      => true,
            'labels'            => $service_cat_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service-category'),
            'show_in_rest'      => true,
        ));

        // Project Category
        $project_cat_labels = array(
            'name'              => _x('Project Categories', 'taxonomy general name', 'carvia-core'),
            'singular_name'     => _x('Project Category', 'taxonomy singular name', 'carvia-core'),
            'search_items'      => __('Search Project Categories', 'carvia-core'),
            'all_items'         => __('All Project Categories', 'carvia-core'),
            'parent_item'       => __('Parent Project Category', 'carvia-core'),
            'parent_item_colon' => __('Parent Project Category:', 'carvia-core'),
            'edit_item'         => __('Edit Project Category', 'carvia-core'),
            'update_item'       => __('Update Project Category', 'carvia-core'),
            'add_new_item'      => __('Add New Project Category', 'carvia-core'),
            'new_item_name'     => __('New Project Category Name', 'carvia-core'),
            'menu_name'         => __('Categories', 'carvia-core'),
        );

        register_taxonomy('carvia_project_category', array('carvia-project'), array(
            'hierarchical'      => true,
            'labels'            => $project_cat_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'project-category'),
            'show_in_rest'      => true,
        ));
    }

    public function add_elementor_support()
    {
        add_post_type_support('carvia-header', 'elementor');
        add_post_type_support('carvia-footer', 'elementor');
    }

    public function set_elementor_settings()
    {
        $cpt_support = get_option('elementor_cpt_support');
        $carvia_types = array('carvia-service', 'carvia-project', 'carvia-header', 'carvia-footer');

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
        if (is_singular(array('carvia-header', 'carvia-footer'))) {
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
        $instance = new self();
        $instance->register_post_types();
        flush_rewrite_rules();
    }
}

// Initialize the class
new Carvia_Core_Post_Types();

// Activation hook
register_activation_hook(CARVIA_CORE_FILE, array('Carvia_Core_Post_Types', 'activate'));
