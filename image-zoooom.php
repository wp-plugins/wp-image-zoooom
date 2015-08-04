<?php
/**
 * Plugin Name: WP Image Zoooom
 * Plugin URI: https://wordpress.org/plugins/wp-image-zoooom/
 * Description: Add zoom effect over the an image, whether it is an image in a post/page or the featured image of a product in a WooCommerce shop 
 * Version: 1.1.1
 * Author: Diana Burduja
 * License: GPL2
 *
 * Text Domain: zoooom
 * Domain Path: /languages/
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'ImageZoooom' ) ) :
/**
 * Main ImageZoooom Class
 *
 * @class ImageZoooom
 */
final class ImageZoooom {
    public $version = '1.1.1';
    public $testing = false;
    public $free = true;
    protected static $_instance = null; 


    /**
     * Main ImageZoooom Instance
     *
     * Ensures only one instance of ImageZoooom is loaded or can be loaded
     *
     * @static
     * @return ImageZoooom - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
      * Cloning is forbidden.
      */
    public function __clone() {
         _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'zoooom' ), '1.0' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'zoooom' ), '1.0' );
    }

    /**
     * Image Zoooom Constructor
     * @access public
     * @return ImageZoooom
     */
    public function __construct() {
         if ( is_admin() ) {
            include_once( 'includes/image-zoom-admin.php' );
         }
         add_action( 'template_redirect', array( $this, 'template_redirect' ) );
    }

    /**
     * Show the javascripts in the front-end
     * Hooked to template_redirect in $this->__construct()
     * @access public
     */
    public function template_redirect() {

        $general = $this->get_option_general();

        if ( isset($general['enable_mobile']) && empty($general['enable_mobile']) && wp_is_mobile() )
            return false;

        if ( isset($general['force_woocommerce']) && $general['force_woocommerce'] == 1 ) {
            add_filter( 'woocommerce_single_product_image_html', array( $this, 'woocommerce_single_product_image_html' ) );
        }



        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
        add_action( 'wp_head', array( $this, 'show_js_settings' ) );
    }

    /**
     * Force the WooCommerce large image to be loaded
     */
    function woocommerce_single_product_image_html( $content ) {
        $content = preg_replace('@(-[0-9]+x[0-9]+).(jpg|png|gif)@', '.$2', $content);
        return $content;
    }

    /**
     * Call the jquery.image_zoom.js with the right options
     * Hooked to wp_head in $this->template_redirect
     * @access public
     */
    public function show_js_settings() {
        $options = get_option( 'zoooom_settings_js' );
        $general = $this->get_option_general();

        $with_woocommerce = true;
        if ( ! $this->woocommerce_is_active() )
            $with_woocommerce = false;

        if ( !function_exists( 'is_product' ) || !is_product() ) 
            $with_woocommerce = false;

        if ( isset($general['enable_woocommerce']) && empty($general['enable_woocommerce']))
            $with_woocommerce = false;


        echo '<script type="text/javascript">
            /* <![CDATA[ */
            jQuery(document).ready(function(){
                var options = {'.$options.'};
                jQuery(".zoooom").image_zoom(options);

                ';
                if ( $with_woocommerce ) {
                echo '    
                jQuery(".attachment-shop_single").image_zoom(options);

                jQuery("a[data-rel^=\'prettyPhoto\']").each(function(index){
                    jQuery(this).click(function(event){
                        event.preventDefault();
                        var main_image = jQuery(".attachment-shop_single");
                        var new_source = jQuery(this).attr(\'href\');
                        main_image.attr(\'src\', new_source); 
                        main_image.parent().attr(\'href\', new_source);
                        main_image.image_zoom(options);
                    });
                });';
                }
            echo '});
            /* ]]> */
        </script>';
    }

    /**
     * Enqueue the jquery.image_zoom.js
     * Hooked to wp_enqueue_scripts in $this->template_redirect
     * @access public
     */
    public function wp_enqueue_scripts() {
        if ( $this->testing == true ) {
            wp_register_script( 'image_zoooom', $this->plugins_url( '/assets/js/jquery.image_zoom.js' ), array( 'jquery' ), $this->version, false );
            wp_enqueue_script( 'image_zoooom' );
        } else {
            wp_register_script( 'image_zoooom', $this->plugins_url( '/assets/js/jquery.image_zoom.min.js' ), array( 'jquery' ), $this->version, false );
            wp_enqueue_script( 'image_zoooom' );
        }

        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
    }



    /** Helper function ****************************************/

    public function plugins_url( $path  = '/' ) {
        return untrailingslashit( plugins_url( $path, __FILE__ ) );
    }

    public function plugin_dir_path() {
        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }

    /**
     * Check if WooCommerce is activated
     * @access public
     * @return bool
     */
    public function woocommerce_is_active() {
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            return true;
        }
        return false;
    }

    public function get_option_general() {
        $general = get_option('zoooom_general');

        if (!isset($general['enable_woocommerce']))
            $general['enable_woocommerce'] = true;

        if ( !isset( $general['enable_mobile'] ) )
            $general['enable_mobile'] = false;

        if ( !isset( $general['force_woocommerce'] ) )
            $general['force_woocommerce'] = false;

       return $general; 
    }

}

endif; 

/**
 * Returns the main instance of ImageZoooom
 *
 * @return ImageZoooom
 */
function ImageZoooom() {
    return ImageZoooom::instance();
}

ImageZoooom();
