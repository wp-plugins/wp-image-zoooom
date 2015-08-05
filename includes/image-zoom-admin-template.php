<?php

require_once 'image-zoom-forms-helper.php';

$iz = ImageZoooom();
$iz_admin = new ImageZoooom_Admin;
$iz_forms_helper = new ImageZoooom_FormsHelper;

$assets_url = $iz->plugins_url() . '/assets';

$settings = get_option( 'zoooom_settings' );
if ( $settings == false ) {
    $settings = $iz_admin->validate_settings( array() );
}
$messages = $iz_admin->show_messages();

?>

<div class="wrap">

<h2>WP Image Zoooom</h2>

<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">

    <a href="?page=zoooom_settings&tab=general" class="nav-tab "><?php echo __('General Settings', 'zoooom'); ?></a>

    <a href="?page=zoooom_settings&tab=settings" class="nav-tab nav-tab-active"><?php echo __('Zoom Settings'); ?></a>

</h2>

<div class="panel panel-default">
    <div class="panel-body">
    <div class="row">



    <?= $messages ?>
    <div id="alert_messages">
    </div>
        
<form class="form-horizontal" method="post" action="" id="form_settings">

<div class="form-group">
        <?= load_steps('Step 1', 'Choose the Lens Shape'); ?>

        <?php 
            $lensShape = $iz_admin->get_settings( 'lensShape', $settings['lensShape']);

            $lensShape['value'] = $settings['lensShape'];
            if ( ! isset($lensShape['value'] ) ) $lensShape['value'] = '';
        ?>
          <div class="btn-group" data-toggle="buttons" id="btn-group-style-circle">
            <?php foreach( $lensShape['values'] as $_id => $_value ) : ?>
            <label class="btn btn-default<?= ($lensShape['value'] == $_id) ? ' active' : '' ?> ">
            <input type="radio" name="<?= $lensShape['name'] ?>" id="<?= $_id ?>" value="<?= $_id ?>" <?=  ($lensShape['value'] == $_id) ? 'checked' : '' ?> />
            <div class="icon-in-label ndd-spot-icon icon-style-1">
              <div class="ndd-icon-main-element">
              <img src="<?= ImageZoooom()->plugins_url() . '/assets' . $_value[0] ?>"<?php 
                if ( ! empty($_value[1]) ) {
                    echo ' data-toggle="tooltip" data-placement="top" title="'.$_value[1].'" data-originla-title="' . $_value[1] . '"';
                }
?> />
              </div>
            </div>
            </label>
            <?php endforeach; ?>
          </div>

    <div style="clear: both; margin-bottom: 50px;"></div>


    <?= load_steps('Step 2', 'Check your configuration changes on the image'); ?>
    <img id="demo" src="<?= $assets_url ?>/images/img1_medium.png" data-zoom-image="<?= $assets_url ?>/images/img1_large.png" width="300" />


    <div style="clear: both; margin-bottom: 50px;"></div>

    <?= load_steps('Step 3', 'Make more fine-grained configurations on the zoom'); ?>
    <ul class="nav nav-tabs">
        <li class="" id="tab_padding" style="width: 40px;"> &nbsp; </li>
        <li class="active" id="tab_general">
            <a href="#general_settings" data-toggle="tab" aria-expanded="true">General</a>
        </li>
        <li class="" id="tab_lens">
            <a href="#lens_settings" data-toggle="tab" aria-expanded="false">Lens</a>
        </li>
        <li class="" id="tab_zoom_window">
            <a href="#zoom_window_settings" data-toggle="tab" aria-expanded="false">Zoom Window</a>
        </li>
    </ul>

<div class="tab-content">
    <div class="tab-pane fade active in" id="general_settings">
        <?php

        foreach ( array('cursorType', 'zwEasing' ) as $_field ) {
            $this_settings = $iz_admin->get_settings( $_field);
            $this_settings['value'] = $settings[$_field];
            $iz_forms_helper->input($this_settings['input_form'], $this_settings); 
        }
        ?> 

    </div>
    <div class="tab-pane fade" id="lens_settings">
        <?php

        $fields = array(
            'lensSize',
            'borderThickness',
            'borderColor',
            'lensFade',
            'tint',
            'tintColor',
            'tintOpacity',
        );

        foreach ( $fields as $_field ) {
            $this_settings = $iz_admin->get_settings( $_field);
            $this_settings['value'] = $settings[$_field];
            $iz_forms_helper->input($this_settings['input_form'], $this_settings); 
        }

        ?>
    </div>

    <div class="tab-pane fade" id="zoom_window_settings">
        <?php

        $fields = array(
            'zwWidth',
            'zwHeight',
            'zwPadding',
            'zwBorderThickness',
            'zwBorderColor',
            'zwShadow',
            'zwBorderRadius',
            'mousewheelZoom',
            'zwFade',
        );

        foreach ( $fields as $_field ) {
            $this_settings = $iz_admin->get_settings( $_field);
            $this_settings['value'] = $settings[$_field];
            $iz_forms_helper->input($this_settings['input_form'], $this_settings); 
        }

       ?>
    </div>
</div><!-- close "tab-content" -->


    <?= load_steps('Step 4', 'Don\'t forget to save the changes in order to apply them on the website'); ?>
    <div class="form-group">
      <div class="col-lg-6">
      <button type="submit" class="btn btn-primary"><?php echo __('Save changes', 'zoooom'); ?></button>
      </div>
    </div>

</div><!-- close "form-group" -->
</form>


    </div>
</div>
</div>


</div><!-- close wrap -->


<?php include_once('right_columns.php'); ?>

<?php

function load_steps($step, $description) {
    return '<div class="steps">
        <span class="steps_nr">'. __($step) .':</span>
        <span class="steps_desc">' . __($description) . '</span>
        </div>' . "\n";
}

?>
