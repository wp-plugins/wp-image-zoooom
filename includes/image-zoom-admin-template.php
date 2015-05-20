<?php

require_once 'image-zoom-forms-helper.php';

$assets_url = ImageZoooom()->plugins_url() . '/assets';

$settings = get_option( 'zoooom_settings' );
if ( $settings == false ) {
    $settings = ImageZoooom_Admin::validate_settings( array() );
}
$messages = ImageZoooom_Admin::show_messages();

?>

<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">

    <a href="?page=zoooom_settings&tab=general" class="nav-tab "><?php echo __('General Settings', 'zoooom'); ?></a>

    <a href="?page=zoooom_settings&tab=settings" class="nav-tab nav-tab-active"><?php echo __('Zoom Settings'); ?></a>

</h2>

<div class="panel panel-default">
    <div class="panel-body">
    <div class="row">



    <div class="col-lg-12">
    <?= $messages ?>
    <div id="alert_messages">
    </div>
    </div>


    <div class="col-lg-4">
    <img id="demo" src="<?= $assets_url ?>/images/img1_medium.png" data-zoom-image="<?= $assets_url ?>/images/img1_large.png" width="300" />
    </div>
    <div class="col-lg-8">

        
<form class="form-horizontal" method="post" action="" id="form_settings">

<div class="form-group">
        <?php echo __('Choose the Lens Shape') . ':'; ?><br>

        <?php 
            $lensShape = ImageZoooom_Admin::get_settings( 'lensShape');

            if ( ! isset($lensShape['value'] ) ) $lensShape['value'] = '';
        ?>

        <div class="col-sm-9">
          <div class="btn-group btn-group-no-margin" data-toggle="buttons" id="btn-group-style-circle">
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
        </div>

    <div style="clear: both; margin-bottom: 50px;"></div>

    <ul class="nav nav-tabs">
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

        load_form_group( 'cursorType', $settings['cursorType'] );

        load_form_group( 'zwEasing', $settings['zwEasing'] );
        
        ?> 

    </div>
    <div class="tab-pane fade" id="lens_settings">
        <?php

        load_form_group( 'lensSize', $settings['lensSize'] );

        load_form_group( 'borderThickness', $settings['borderThickness'] );

        load_form_group( 'borderColor', $settings['borderColor'] );

        load_form_group( 'lensFade', $settings['lensFade'] );

        load_form_group( 'tint', $settings['tint'] );

        load_form_group( 'tintColor', $settings['tintColor'] );

        load_form_group( 'tintOpacity', $settings['tintOpacity'] );

        ?>
    </div>

    <div class="tab-pane fade" id="zoom_window_settings">
        <?php

        load_form_group( 'zwWidth', $settings['zwWidth'] );

        load_form_group( 'zwHeight', $settings['zwHeight'] );

        load_form_group( 'zwPadding', $settings['zwPadding'] );

        load_form_group( 'zwBorderThickness', $settings['zwBorderThickness'] );

        load_form_group( 'zwBorderColor', $settings['zwBorderColor'] );

        load_form_group( 'zwShadow', $settings['zwShadow'] );

        load_form_group( 'zwBorderRadius', $settings['zwBorderRadius'] );

        load_form_group( 'mousewheelZoom', $settings['mousewheelZoom'] );

        load_form_group( 'zwFade', $settings['zwFade'] );

       ?>
    </div>
</div><!-- close "tab-content" -->


    <div class="form-group">
      <div class="col-lg-6 col-lg-offset-3">
      <button type="submit" class="btn btn-primary"><?php echo __('Save changes', 'zoooom'); ?></button>
      </div>
    </div>

</div><!-- close "form-group" -->
</form>


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
