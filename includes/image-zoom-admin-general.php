<?php

require_once 'image-zoom-forms-helper.php';

$iz = ImageZoooom();
$iz_admin = new ImageZoooom_Admin;
$iz_forms_helper = new ImageZoooom_FormsHelper;

$assets_url = $iz->plugins_url() . '/assets';

$settings = $iz->get_option_general();
if ( $settings == false ) {
    $settings = $iz_admin->validate_general( null );
}

$messages = $iz_admin->show_messages();

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

        foreach ( array('enable_woocommerce', 'enable_mobile', 'force_woocommerce' ) as $_field ) {
            $this_settings = $iz_admin->get_settings( $_field);
            $this_settings['value'] = $settings[$_field];
            $iz_forms_helper->input($this_settings['input_form'], $this_settings); 
        }
        
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
