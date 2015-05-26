<?php

require_once 'image-zoom-forms-helper.php';

$assets_url = ImageZoooom()->plugins_url() . '/assets';

$settings = ImageZoooom()->get_option_general();
if ( $settings == false ) {
    $settings = ImageZoooom_Admin::validate_general( null );
}

$messages = ImageZoooom_Admin::show_messages();

?>

<div class="wrap">

<h2>WP Image Zoooom</h2>

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


        

<form class="form-horizontal" method="post" action="" id="form_settings">

        <?php

        load_form_group( 'enable_woocommerce', $settings['enable_woocommerce'] );

        load_form_group( 'enable_mobile', $settings['enable_mobile'] );
        
        ?> 

<div class="form-group">
      <div class="col-lg-6">
        <input type="hidden" name="tab" value="general" />
          <button type="submit" class="btn btn-primary"><?php echo __('Save changes', 'zoooom'); ?></button>
      </div>
    </div>

</form>


    </div>
    </div>
</div>
</div>

<?php include_once('right_columns.php'); ?>

<?php

function load_form_group( $id, $value = '' ) {
    $settings = ImageZoooom_Admin::get_settings( $id );
    $settings['value'] = $value;
    ImageZoooom_FormsHelper::input($settings['input_form'], $settings);
}


?>
