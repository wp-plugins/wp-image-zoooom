<?php
/**
 * Plugin Name: WP Image Zoooom
 * Plugin URI: https://wordpress.org/plugins/wp-image-zoooom/
 * Description: Add zoom effect over the an image, whether it is an image in a post/page or the featured image of a product in a WooCommerce shop 
 * Version: 1.0
 * Author: Diana Burduja
 *
 * Text Domain: zoooom
 * Domain Path: /languages/
 *
 */

require_once 'image-zoom-forms-helper.php';

$assets_url = ImageZoooom()->plugins_url() . '/assets';

$settings = ImageZoooom()->get_option_general();
if ( $settings == false ) {
    $settings = ImageZoooom_Admin::validate_general( null );
}

$messages = ImageZoooom_Admin::show_messages();

?>

<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">

    <a href="?page=zoooom_settings&tab=general" class="nav-tab nav-tab-active"><?php echo __('General Settings', 'zoooom'); ?></a>

    <a href="?page=zoooom_settings&tab=settings" class="nav-tab"><?php echo __('Zoom Settings'); ?></a>

</h2>

<div class="panel panel-default">
    <div class="panel-body">
    <div class="row">



    <div class="col-lg-12">
    <?= $messages ?>
    <div id="alert_messages">
    </div>
    </div>


    <div class="col-lg-8" style="padding: 30px;">

        

<form class="form-horizontal" method="post" action="" id="form_settings">

        <?php

        load_form_group( 'enable_woocommerce', $settings['enable_woocommerce'] );

        load_form_group( 'enable_mobile', $settings['enable_mobile'] );
        
        ?> 

<div class="form-group">
      <div class="col-lg-6 col-lg-offset-3">
        <input type="hidden" name="tab" value="general" />
          <button type="submit" class="btn btn-primary"><?php echo __('Save changes', 'zoooom'); ?></button>
      </div>
    </div>

</form>


    </div>
    </div>
    </div>
</div>


<?php

function load_form_group( $id, $value = '' ) {
    $settings = ImageZoooom_Admin::get_settings( $id );
    $settings['value'] = $value;
    ImageZoooom_FormsHelper::input($settings['input_form'], $settings);
}


?>
