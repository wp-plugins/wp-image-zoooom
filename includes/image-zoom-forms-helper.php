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


class ImageZoooom_FormsHelper {

    public static $label_class = 'col-sm-3 control-label';

    public static function input( $type, $settings = array() ) {
        $allowed_types = array( 'radio', 'input_text', 'buttons', 'input_color', 'checkbox' );

        if ( ! in_array( $type, $allowed_types ) ) {
            return;
        }
        call_user_func( 'ImageZoooom_FormsHelper::' . $type, $settings );
    }
    
    public static function radio($args = array()) {
        if ( !isset($args['label'] )) return;
        if ( !isset($args['name'] )) return;
        if ( !isset($args['values'] ) || count($args['values']) == 0 ) return;
        if ( !isset($args['active'] ) ) $args['active'] = '';
        ?>
           <div class="form-group">
             <label class="<?= self::$label_class ?>"><?= $args['label'] ?></label>
       	      <div class="col-lg-8">
                <?php foreach ($args['values'] as $_id => $_label) : ?>
				<div class="radio">
				  <label>
                  <input type="radio" name="<?= $args['name'] ?>" id="<?= $_id ?>" value="<?= $_id ?>" <?= ($_id == $args['active']) ? 'checked=""' : '' ?>>
                  <?= $_label ?>
				  </label>
				</div>
                <?php endforeach; ?>
			  </div>		    
			</div>		    
        <?php
    }

    public static function input_text( $args = array() ) {
        if ( ! isset($args['label'] ) ) return;
        if ( ! isset($args['name'] ) ) return;
        if ( ! isset($args['value'] ) ) $args['value'] = '';
        if ( ! isset($args['description'] ) ) $args['description'] = '';
        ?>
        	<div class="form-group">
            <label for="<?= $args['name'] ?>" class="<?= self::$label_class ?>"><?= $args['label'] ?> <?= self::tooltip($args['description']) ?></label>
            <?php if (isset($args['post_input'])) : ?>
                <div class="input-group">
            <?php else : ?>
                <div class="input-group">
            <?php endif; ?>
        <input type="text" class="form-control" id="<?= $args['name']?>" name="<?= $args['name'] ?>" value="<?= $args['value'] ?>" />
            <?php if (isset($args['post_input'])) : ?><span class="input-group-addon"><?= $args['post_input'] ?></span>
            <?php endif; ?>
                </div>
			</div>
        <?php
    }


    public static function input_color( $args = array() ) {
        if ( ! isset($args['label'] ) ) return;
        if ( ! isset($args['name'] ) ) return;
        if ( ! isset($args['value'] ) ) $args['value'] = '';
        ?>
            <div class="form-group">
            <label for="<?= $args['name'] ?>" class="<?= self::$label_class ?>"><?= $args['label'] ?></label>
				<div class="input-group">
                <input type="color" class="form-control" id="<?= $args['name'] ?>" name="<?= $args['name'] ?>" value="<?= $args['value'] ?>">
                <span class="input-group-addon" id="color-text-color-hex"><?= $args['value'] ?></span>
				</div>
			</div>

        <?php
    }

    public static function checkbox( $args = array() ) {
        if ( ! isset($args['label'] ) ) return;
        if ( ! isset($args['name'] ) ) return;
        if ( ! isset($args['value'] ) ) $args['value'] = false;
        ?>
            <div class="form-group">
            <label for="<?= $args['name'] ?>" class="<?= self::$label_class ?>"><?= $args['label'] ?></label>
                  <div class="checkbox">
                    <label>
                    <input type="checkbox" id="<?= $args['name'] ?>" name="<?= $args['name'] ?>" <?= ($args['value'] == true) ? 'checked=""' : '' ?> />
                    </label>
                   </div>
            </div>
        <?php
    }

    public static function buttons( $args = array() ) {
        if ( ! isset($args['label'] ) ) return;
        if ( ! isset($args['name'] ) ) return;
        if ( ! isset($args['values'] ) || count($args['values']) == 0 ) return;
        if ( ! isset($args['value'] ) ) $args['value'] = '';
        ?>
        <div class="form-group">
        <label for="<?= $args['name'] ?>" class="<?= self::$label_class?>"><?= $args['label'] ?></label>
        <div class="col-sm-9">
          <div class="btn-group btn-group-no-margin" data-toggle="buttons" id="btn-group-style-circle">
            <?php foreach( $args['values'] as $_id => $_value ) : ?>
            <label class="btn btn-default<?= ($args['value'] == $_id) ? ' active' : '' ?> ">
            <input type="radio" name="<?= $args['name'] ?>" id="<?= $_id ?>" value="<?= $_id ?>" <?=  ($args['value'] == $_id) ? 'checked' : '' ?> />
            <div class="icon-in-label ndd-spot-icon icon-style-1">
              <div class="ndd-icon-main-element">
              <img src="<?= self::assets_url() . $_value[0] ?>"<?php 
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
        </div>
        <?php
    }

    public static function tooltip( $description = '' ) {
        if ( empty($description) ) return '';
        return '<img src="'.self::assets_url().'/images/question_mark.svg" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$description.'" />';
    }

    public static function assets_url() {
       $assets_url = ImageZoooom()->plugins_url() . '/assets'; 
       return $assets_url;
    }

}

?>
