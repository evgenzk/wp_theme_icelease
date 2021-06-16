<?php

/**
 * =============================================================================
 * Icelease theme core class
 * =============================================================================
 * @subpackage  Icelease
 * @author      <panevnyk.roman@gmail.com>
 */
namespace Core;

class Icelease {
    

    /**
     * @var Icelease
     */
    protected static $instance;


    /**
     * @return Icelease
     */
    public static function get_instance(){

        if(!(self::$instance instanceof self)){
            self::$instance = new self;
        }
        return self::$instance;

    }


    /**
     * @var Array
     */
    public static $templates = [
        'front-page' => [
            'aircraft-leasing'
        ],
        'page' => [
            'aircraft-leasing'
        ]
    ];


    /**
     * -------------------------------------------------------------------------
     * Keep all actions, hooks and filters here
     * -------------------------------------------------------------------------
     * @method __construct
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    public function __construct() {

        {
            // TODO: remove it
            define('ALLOW_UNFILTERED_UPLOADS', true);

        }


        
        /**
         * Actions, Filters
         */
        add_action('wp_enqueue_scripts',        [$this, 'enqueue_scripts']);

        add_filter('script_loader_tag',         [$this, 'change_tag'], 10, 3);

        add_action('after_setup_theme',         [$this, 'setup_theme']);

        add_action('admin_notices',             [$this, 'theme_dependencies']);



        /**
         * Ajax
         */
        add_action('wp_ajax_fill-main',         [$this, 'fill_main']);
        add_action('wp_ajax_nopriv_fill-main',  [$this, 'fill_main']);

        $this->initACF();

    }

    /**
     * -------------------------------------------------------------------------
     * Method to initializate ACF settings
     * -------------------------------------------------------------------------
     * @method initACF
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    public function initACF(){

        if(function_exists('acf_add_options_page')){

            acf_add_options_page([
                'page_title' 	=> 'Icelease Settings',
                'menu_title'	=> 'Icelease',
                'menu_slug' 	=> 'icelease-settings',
                'capability'	=> 'edit_posts',
                'redirect'		=> false,
                'position'      => 2
            ]);

            acf_add_options_sub_page([
                'page_title' 	=> 'Preloader Settings',
                'menu_title'	=> 'Preloader',
                'parent_slug'	=> 'icelease-settings',
            ]);

        }

        include_once(
            get_template_directory() . '/acf/acf_dependencies.php'
        );

    }

    /**
     * -------------------------------------------------------------------------
     * Show theme dependencies
     * -------------------------------------------------------------------------
     * @method theme_dependencies
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    public function theme_dependencies(){

        if(!function_exists('acf_add_options_page')){

            $text = __(
                'Warning: Icelease theme needs Plugin ACF, please install it', 
                'icelease'
            );

            include_once(
                get_template_directory() . '/template-parts/notices/error.php'
            );

        }

    }


    /**
     * -------------------------------------------------------------------------
     * Enqueue scripts and styles here
     * -------------------------------------------------------------------------
     * @method 
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    public function enqueue_scripts(){


        $styles = [
            'reset',
            'fonts',
            'atomic',
            'animation',
            'style'
        ];

        $scripts = [
            'main'
        ];

        $this->init_styles($styles);
        $this->init_scripts($scripts);

    }


    /**
     * -------------------------------------------------------------------------
     * Method to load and localize styles
     * -------------------------------------------------------------------------
     * @method init_styles
     * @param  Array $styles 
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    private function init_styles($styles){

        wp_enqueue_style(
            'style',
            get_stylesheet_uri()
        );

        foreach($styles as $style){
            wp_enqueue_style(
                $style . '-css',
                get_template_directory_uri() . '/dist/css/' . $style . '.css'
            );
        }

    }


    /**
     * -------------------------------------------------------------------------
     * Method to load and localize scripts
     * -------------------------------------------------------------------------
     * @method init_scripts
     * @param  Array $scripts 
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    private function init_scripts($scripts){

        foreach($scripts as $script){
            wp_enqueue_script(
                $script . '-js',
                get_template_directory_uri() . '/dist/js/' . $script . '.js'
            );
        }
        

        wp_localize_script(
            'main-js', 
            'Icelease', 
            [
                'directory' => get_template_directory_uri(),
                'ajax'      => admin_url('admin-ajax.php'),
                'preloader' => [
                    'texts' => function_exists('acf_add_options_page') ? get_field('custom_texts', 'options') : []
                ]
            ]
        );

    }


    /**
     * -------------------------------------------------------------------------
     * Method to change script tag
     * -------------------------------------------------------------------------
     * @method change_tag
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Mixed
     */

    public function change_tag($tag, $handle, $src) {

        if ($handle === 'main-js') {
            $tag = '<script type="module" src="'.esc_url($src).'"></script>';
        }
        
        return $tag;
        
    }

    
    /**
     * -------------------------------------------------------------------------
     * Method to add theme option
     * -------------------------------------------------------------------------
     * @method setup_theme
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Void
     */
    public function setup_theme(){

        show_admin_bar(false);
        add_theme_support('menus');
        add_theme_support('post-thumbnails');

        register_nav_menus([
            'header_menu'       => __('Menu in header',     'icelease'),
        ]);

    }



    /**
     * -------------------------------------------------------------------------
     * Method to make SPA
     * -------------------------------------------------------------------------
     * @method fill_main
     * @param  Null
     * 
     * @author <panevnyk.roman@gmail.com>
     * @since  1.0
     * @return Template
     */
    public function fill_main(){

        $url        = $_POST['state']['page'];
        $id         = url_to_postid($url);
        $slug       = explode('.', get_page_template_slug($id))[0];

        // If its front page
        if(get_option('page_on_front') == $id){
            $slug = 'front-page';
        }

        // If did not find template (archive)
        if(!$id){
            $categories = get_categories([
                'taxonomy'     => 'category',
                'type'         => 'post',
                'child_of'     => 0,
                'parent'       => '',
                'orderby'      => 'name',
                'order'        => 'ASC',
                'hide_empty'   => 0,
                'hierarchical' => 1,
                'exclude'      => '1',
                'include'      => '',
                'number'       => 0,
                'pad_counts'   => false,
            ]);
            foreach($categories as $category) {
                if (get_category_link($category->cat_ID) == $url){
                    $id = $category->cat_ID;
                    set_query_var('category', true);
                }
            }
            $slug = 'archive';
        }

        if ($slug == ''){
            $slug = 'page';
        }

        set_query_var('id', $id);


        foreach(self::$templates[$slug] as $template){

            get_template_part('template-parts/'.$template);
    
        }

        wp_die();
    }



}