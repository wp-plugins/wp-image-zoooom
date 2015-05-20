<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * ImageZoooom_Admin 
 */
class ImageZoooom_Admin {

    private static $messages = array();
    private static $tab = 'general';

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'admin_head', array( $this, 'iz_add_tinymce_button' ) );
    }

    /**
     * Add menu items
     */
    public function admin_menu() {
        add_menu_page(
            __( 'Image Zoooom', 'zoooom' ),
            __( 'Image Zoooom', 'zoooom' ),
            'administrator',
            'zoooom_settings',
            array( $this, 'admin_settings_page' ),
            ImageZoooom()->plugins_url() . '/assets/images/icon.svg'
        );
    }

    /**
     * Load the javascript and css scripts
     */
    public function admin_enqueue_scripts( $hook ) {
        if ( $hook != 'toplevel_page_zoooom_settings' )
            return false;

        $iz = ImageZoooom();

        // Register the javascript files
        if ( $iz->testing == true ) {
            wp_register_script( 'bootstrap', $iz->plugins_url( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), $iz->version, true  );
            wp_register_script( 'image_zoooom', $iz->plugins_url( '/assets/js/jquery.image_zoom.js' ), array( 'jquery' ), $iz->version, true );
            if ( !isset($_GET['tab']) || $_GET['tab'] == 'settings' ) {
                wp_register_script( 'zoooom-settings', $iz->plugins_url( '/assets/js/image_zoom.settings.js' ), array( 'image_zoooom' ), $iz->version, true );
            }
        } else {
            wp_register_script( 'bootstrap', $iz->plugins_url( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), $iz->version, true  );
            wp_register_script( 'image_zoooom', $iz->plugins_url( '/assets/js/jquery.image_zoom.min.js' ), array( 'jquery' ), $iz->version, true );
            if ( !isset($_GET['tab']) || $_GET['tab'] == 'settings' ) {
                wp_register_script( 'zoooom-settings', $iz->plugins_url( '/assets/js/image_zoom.settings.min.js' ), array( 'image_zoooom' ), $iz->version, true );
            }
        }

        // Enqueue the javascript files
        wp_enqueue_script( 'bootstrap' );
        wp_enqueue_script( 'image_zoooom' );
        wp_enqueue_script( 'zoooom-settings' );

        // Register the css files
        wp_register_style( 'bootstrap', $iz->plugins_url( '/assets/css/bootstrap.min.css' ) );
        if ( $iz->testing == true ) {
            wp_register_style( 'zoooom', $iz->plugins_url( '/assets/css/style.css' ) );
        } else {
            wp_register_style( 'zoooom', $iz->plugins_url( '/assets/css/style.min.css' ) );
        }

        // Enqueue the css files
        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( 'zoooom' );
    }

    /**
     * Build an array with settings that will be used in the form
     * @access public
     */
    public static function get_settings( $id  = '' ) {
        $settings = array(
            'lensShape' => array(
                'label' => __('Lens Shape', 'zoooom'),
                'values' => array(
                    'none' => array('/images/lens_shape_none.svg', __('No Lens', 'zoooom')),
                    'round' => array('/images/lens_shape_circle.svg', __('Circle Lens', 'zoooom')),
                    'square' => array('/images/lens_shape_square.svg', __('Square Lens', 'zoooom')),
                    'zoom_window' => array('/images/type_zoom_window.svg', __('With Zoom Window', 'zoooom')),
                ),
                'value' => 'zoom_window',
                'input_form' => 'buttons',
            ),
            'cursorType' => array(
                'label' => __('Cursor Type', 'zoooom'),
                'values' => array(
                    'default' => array('/images/cursor_type_default.svg', __('Default', 'zoooom' ) ),
                    'pointer' => array('/images/cursor_type_pointer.svg', __('Pointer', 'zoooom' ) ),
                    'crosshair' => array('/images/cursor_type_crosshair.svg', __('Crosshair', 'zoooom' ) ),
                    'move' => array('/images/cursor_type_move.svg', __('Move', 'zoooom' ) ),
                ),
                'value' => 'default',
                'input_form' => 'buttons',
            ),
            'zwEasing' => array(
                'label' => __('Animation Easing Effect', 'zoooom' ),
                'value' => 12,
                'description' => __('A number between 0 and 200 to represent the degree of the Animation Easing Effect', 'zoooom' ),
                'input_form' => 'input_text',
            ),

            'lensSize' => array(
                'label' => __('Lens Size', 'zoooom' ),
                'post_input' => 'px',
                'value' => 200,
                'description' => __('For Circle Lens it means the diameters, for Square Lens it means the width', 'zoooom' ),
                'input_form' => 'input_text',
            ),
            'borderThickness' => array(
                'label' => __('Border Thickness', 'zoooom' ),
                'post_input' => 'px',
                'value' => 1,
                'input_form' => 'input_text',
            ),
            'borderColor' => array(
                'label' => __('Border Color', 'zoooom' ),
                'value' => '#ffffff',
                'input_form' => 'input_color',
            ),
            'lensFade' => array(
                'label' => __('Fade Time', 'zoooom' ),
                'post_input' => 'sec',
                'value' => 1,
                'description' => __('The amount of time it takes for the Lens to slowly appear or dissapear', 'zoooom'),
                'input_form' => 'input_text',
            ),
            'tint' => array(
                'label' => __('Tint', 'zoooom'),
                'value' => false,
                'description' => __('A color that will layed on top the of non-magnified image in order to emphasize the lens', 'zoooom'),
                'input_form' => 'checkbox',
            ),
            'tintColor' =>array(
                'label' => __('Tint Color', 'zoooom'),
                'value' => '#ffffff',
                'input_form' => 'input_color',
            ),
            'tintOpacity' => array(
                'label' => __('Tint Opacity', 'zoooom'),
                'value' => '0.5',
                'post_input' => '%',
                'input_form' => 'input_text',
            ),
            'zwWidth' => array(
                'label' => __('Zoom Window Width', 'zoooom'),
                'post_input' => 'px',
                'value' => 400,
                'input_form' => 'input_text',
            ),
            'zwHeight' => array(
                'label' => __('Zoom Window Height', 'zoooom'),
                'post_input' => 'px',
                'value' => 360,
                'input_form' => 'input_text',
            ),
            'zwPadding' => array(
                'label' => __('Distance from the Main Image', 'zoooom'),
                'post_input' => 'px',
                'value' => 10,
                'input_form' => 'input_text',
            ),
            'zwBorderThickness' => array(
                'label' => __('Border Thickness', 'zoooom'),
                'post_input' => 'px',
                'value' => 4,
                'input_form' => 'input_text',
            ),
            'zwShadow' => array(
                'label' => __('Shadow Thickness', 'zoooom'),
                'post_input' => 'px',
                'value' => 4,
                'input_form' => 'input_text',
                'description' => __('Use 0px to remove the shadow', 'zoooom'),
            ),
            'zwBorderColor' => array(
                'label' => __('Border Color', 'zoooom'),
                'value' => '#888888',
                'input_form' => 'input_color',
            ),
            'zwBorderRadius' => array(
                'label' => __('Rounded Corners', 'zoooom'),
                'post_input' => 'px',
                'value' => 0,
                'input_form' => 'input_text',
            ),
            'mousewheelZoom' => array(
                'label' => __('Mousewheel Zoom', 'zoooom'),
                'value' => true,
                'description' => __('When using the mousewheel, the zoomed level of the image will change', 'zoooom'),
                'input_form' => 'checkbox',
            ),
            'zwFade' => array(
                'label' => __('Fade Time', 'zoooom'),
                'post_input' => 'sec',
                'value' => 0,
                'description' => __('The amount of time it takes for the Zoom Window to slowly appear or disappear', 'zoooom'),
                'input_form' => 'input_text',
            ),
            'enable_woocommerce' => array(
                'label' => __('Enable the zoom on WooCommerce products', 'zoooom'),
                'value' => true,
                'input_form' => 'checkbox',
            ),
            'enable_mobile' => array(
                'label' => __('Enable the zoom on mobile devices', 'zoooom'),
                'value' => false,
                'input_form' => 'checkbox',
            ),
        );
        if ( isset( $settings[$id] ) ) {
            $settings[$id]['name'] = $id;
            return $settings[$id];
        } elseif ( empty( $id ) ) {
            return $settings;
        }
        return false;
    }

    /**
     * Output the admin page
     * @access public
     */
    public function admin_settings_page() {

        if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'general' ) {
            if ( ! empty( $_POST ) ) {
                $new_settings = $this->validate_general( $_POST );
                update_option( 'zoooom_general', $new_settings );
                self::add_message( 'success', '<b>'.__('Your settings have been saved.', 'zoooom') . '</b>' );
            }

            $template = ImageZoooom()->plugin_dir_path() . "/includes/image-zoom-admin-general.php";
            load_template( $template );

            $this::$tab = 'general';

            return;
        }

        if ( ! empty( $_POST ) ) {
            $new_settings = $this->validate_settings( $_POST );
            $new_settings_js = $this->generate_js_settings( $new_settings );
            update_option( 'zoooom_settings', $new_settings );
            update_option( 'zoooom_settings_js', $new_settings_js );
            self::add_message( 'success', '<b>'.__('Your settings have been saved.', 'zoooom') . '</b>' );
        }

        $template = ImageZoooom()->plugin_dir_path() . "/includes/image-zoom-admin-template.php";
        load_template( $template );

        $this::$tab = 'settings';
    }

    /**
     * Build the jquery.image_zoom.js options and save them directly in the database
     * @access private
     */
    private function generate_js_settings( $settings ) {
        $options = array();
        switch ( $settings['lensShape'] ) {
            case 'none' : 
                $options[] = 'zoomType : "inner"';
                $options[] = 'cursor: "'.$settings['cursorType'].'"';
                $options[] = 'easingAmount: '.$settings['zwEasing'];
                break;
            case 'square' :
            case 'round' :
                $options[] = 'lensShape     : "' .$settings['lensShape'].'"';
                $options[] = 'zoomType      : "lens"';
                $options[] = 'lensSize      : "' .$settings['lensSize'].'"';
                $options[] = 'borderSize    : "' .$settings['borderThickness'].'"'; 
                $options[] = 'borderColour  : "' .$settings['borderColor'].'"';
                $options[] = 'cursor        : "' .$settings['cursorType'].'"';
                $options[] = 'lensFadeIn    : "' .$settings['lensFade'].'"';
                $options[] = 'lensFadeOut   : "' .$settings['lensFade'].'"';
                if ( $settings['tint'] == true ) {
                    $options[] = 'tint     : true';
                    $options[] = 'tintColour:  "' . $settings['tintColor'] . '"';
                    $options[] = 'tintOpacity:  "' . $settings['tintOpacity'] . '"';
                }
 
                break;
            case 'square' :
                break;
            case 'zoom_window' :
               $options[] = 'lensShape       : "square"';
               $options[] = 'lensSize        : "' .$settings['lensSize'].'"'; 
               $options[] = 'lensBorderSize  : "' .$settings['borderThickness'].'"'; 
               $options[] = 'lensBorderColour: "' .$settings['borderColor'].'"'; 
               $options[] = 'borderRadius    : "' .$settings['zwBorderRadius'].'"'; 
               $options[] = 'cursor          : "' .$settings['cursorType'].'"';
               $options[] = 'zoomWindowWidth : "' .$settings['zwWidth'].'"';
               $options[] = 'zoomWindowHeight: "' .$settings['zwHeight'].'"';
               $options[] = 'borderSize      : "' .$settings['zwBorderThickness'].'"';
               $options[] = 'borderColour    : "' .$settings['zwBorderColor'].'"';
               $options[] = 'borderRadius    : "' .$settings['zwBorderRadius'].'"';
               $options[] = 'lensFadeIn      : "' .$settings['lensFade'].'"';
               $options[] = 'lensFadeOut     : "' .$settings['lensFade'].'"';
               $options[] = 'zoomWindowFadeIn  :"' .$settings['zwFade'].'"';
               $options[] = 'zoomWindowFadeOut :"' .$settings['zwFade'].'"';
               $options[] = 'scrollzoom      : "' .$settings['mousewheelZoom'].'"';
               $options[] = 'easingAmount  : "'.$settings['zwEasing'].'"';
                if ( $settings['tint'] == true ) {
                    $options[] = 'tint     : true';
                    $options[] = 'tintColour:  "' . $settings['tintColor'] . '"';
                    $options[] = 'tintOpacity:  "' . $settings['tintOpacity'] . '"';
                }

                break;
        }
        if (count($options) == 0) return false;

        $options = implode(', ', $options);

        return $options;
    }


    /**
     * Check the validity of the settings. The validity has to be the same as the javascript validation in image-zoom.settings.js
     * @access public
     */
    public static function validate_settings( $post ) {
        $settings = self::get_settings();

        $new_settings = array();
        foreach ( $settings as $_key => $_value ) {
            if ( isset( $post[$_key] ) && $post[$_key] != $_value['value'] ) {
                $new_settings[$_key] = $post[$_key]; 
            } else {
                $new_settings[$_key] = $_value['value'];
            } 
        }

        $new_settings['lensShape'] = self::validateValuesSet('lensShape', $new_settings['lensShape']);
        $new_settings['cursorType'] = self::validateValuesSet('cursorType', $new_settings['cursorType']);
        $new_settings['zwEasing'] = self::validateRange('zwEasing', $new_settings['zwEasing'], 'int', 0, 200);
        $new_settings['lensSize'] = self::validateRange('lensSize', $new_settings['lensSize'], 'int', 20, 2000);
        $new_settings['borderThickness'] = self::validateRange('borderThickness', $new_settings['borderThickness'], 'int', 0, 200);
        $new_settings['borderColor'] = self::validateColor('borderColor', $new_settings['borderColor']);
        $new_settings['lensFade'] = self::validateRange('lensFade', $new_settings['lensFade'], 'float', 0, 10);
        $new_settings['tint'] = self::validateCheckbox('tint', $new_settings['tint']);
        $new_settings['tintColor'] = self::validateColor('tintColor', $new_settings['tintColor']);
        $new_settings['tintOpacity'] = self::validateRange('tintOpacity', $new_settings['tintOpacity'], 'float', 0, 1);
        $new_settings['zwWidth'] = self::validateRange('zwWidth', $new_settings['zwWidth'], 'int', 0, 2000);
        $new_settings['zwHeight'] = self::validateRange('zwHeight', $new_settings['zwHeight'], 'int', 0, 2000);
        $new_settings['zwBorderThickness'] = self::validateRange('zwBorderThickness', $new_settings['zwBorderThickness'], 'int', 0, 200);
        $new_settings['zwBorderRadius'] = self::validateRange('zwBorderRadius', $new_settings['zwBorderRadius'], 'int', 0, 500);
        $new_settings['zwFade'] = self::validateRange('zwFade', $new_settings['zwFade'], 'float', 0, 10);
        $new_settings['mousewheelZoom'] = self::validateCheckbox('mousewheelZoom', $new_settings['mousewheelZoom']);

        return $new_settings; 
    }

    public static function validate_general( $post = null) {
        $settings = self::get_settings();

        if ( ! isset( $post['enable_woocommerce'] ) ) 
            $post['enable_woocommerce'] = true;
        if ( ! isset( $post['enable_mobile'] ) ) 
            $post['enable_mobile'] = false;

        $new_settings = array(
            'enable_woocommerce' => self::validateCheckbox('enable_woocommerce', $post['enable_woocommerce']),
            'enable_mobile' => self::validateCheckbox('enable_mobile', $post['enable_mobile']),
        );

        return $new_settings;
    }

    /**
     * Helper to validate a checkbox
     * @access private
     */
    private static function validateCheckbox( $id, $value ) {
        $settings = self::get_settings();

        if ( $value == 'on' ) $value = true;

        if ( !is_bool($value) ) {
            $value = $settings[$id]['value'];
            self::add_message('info', __('Unrecognized <b>'.$settings[$id]['label'].'</b>. The value was reset to default', 'zoooom') );
        } else {
        }
        return $value;
    }

    /**
     * Helper to validate a color
     * @access private
     */
    private static function validateColor( $id, $value ) {
        $settings = self::get_settings();

        if ( !preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value) ) {
            $value = $settings[$id]['value'];
            self::add_message('info', __('Unrecognized <b>'.$settings[$id]['label'].'</b>. The value was reset to <b>'.$settings[$id]['value'] . '</b>', 'zoooom') );
        }
        return $value;
    }

    /**
     * Helper to validate the value out of a set of values
     * @access private
     */
    private static function validateValuesSet( $id, $value ) {
        $settings = self::get_settings();

        if ( !array_key_exists($value, $settings[$id]['values']) ) {
            $value = $settings[$id]['value'];
            self::add_message('info', __('Unrecognized <b>'.$settings[$id]['label'].'</b>. The value was reset to <b>'.$settings[$id]['value'] . '</b>', 'zoooom') );
        }
        return $value;
    }

    /**
     * Helper to validate an integer of a float
     * @access private
     */
    private static function validateRange( $id, $value, $type, $min, $max ) {
        $settings = self::get_settings();

        if ( $type == 'int' ) $new_value = (int)$value;
        if ( $type == 'float' ) $new_value = (float)$value;

        if ( !is_numeric($value) || $new_value < $min || $new_value > $max ) {
            $new_value = $settings[$id]['value'];
            self::add_message('info', __('<b>'.$settings[$id]['label'].'</b> accepts values between '.$min.' and '.$max .'. Your value was reset to <b>' . $settings[$id]['value'] .'</b>', 'zoooom') );
        }
        return $new_value;
    }


    /**
     * Add a message to the $this->messages array
     * @type    accepted types: success, error, info, block
     * @access private
     */
    private static function add_message( $type = 'success', $text ) {
        self::$messages[] = array('type' => $type, 'text' => $text);
    }

    /**
     * Output the form messages
     * @access public
     */
    public static function show_messages() {
        if ( sizeof( self::$messages ) == 0 ) return;
        $output = '';
        foreach ( self::$messages as $message ) {
            $output .= '<div class="alert alert-'.$message['type'].'">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  '. $message['text'] .'</div>';
        }
        return $output;
    }



    /**
     * Add a button to the TinyMCE toolbar
     * @access public
     */
    function iz_add_tinymce_button() {
        global $typenow;

        if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
            return;
        }
        if( ! in_array( $typenow, array( 'post', 'page' ) ) )
            return;

        if ( get_user_option('rich_editing') != 'true') 
            return;

        add_filter('mce_external_plugins', array( $this, 'iz_add_tinymce_plugin' ) );
        add_filter('mce_buttons', array( $this, 'iz_register_tinymce_button' ) );
    }

    /**
     * Register the plugin with the TinyMCE plugins manager
     * @access public
     */
    function iz_add_tinymce_plugin($plugin_array) {
        $plugin_array['image_zoom_button'] = ImageZoooom()->plugins_url() . '/assets/js/tinyMCE-button.js'; 
        return $plugin_array;
    }

    /**
     * Register the button with the TinyMCE manager
     */
    function iz_register_tinymce_button($buttons) {
        array_push($buttons, 'image_zoom_button');
        return $buttons;
    }


}


return new ImageZoooom_Admin();
