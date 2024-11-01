<?php
/**
 * Description
 *
 * @since  1.0.0
 */
function yellow_seo_options() {
    ?>
    <h1>Yellow SEO Options</h1>
    
    <div class="postbox-container" style="width:70%;">
    
        <form method="post" action="options.php" novalidate>
    
        <?php settings_fields('sseo-settings-group'); submit_button(); ?>
        
        <div class="metabox-holder">	
            <div class="meta-box-sortables ui-sortable" style="min-height: 0">
                <div id="simple_seo_buy" class="postbox">
                    <h3 class="hndle ui-sortable-handle"><span>Home Page</span></h3>
                    <div class="inside">
                        <div class="main">
                            <?php settings_fields('sseo-settings-group'); ?>
                            <?php do_settings_sections('sseo-settings-group'); ?>
    
                            <div id="sseo_data">
                                <?php 
    
                                $sseoForm = new cds_sseo_form_helper();
                                echo $sseoForm->input('sseo_default_meta_title', array(
                                    'label' => 'Default Title',
                                    'value' => esc_attr(get_option('sseo_default_meta_title')),
                                ));
    
                                echo '<p><span id="sseo_title_count">0</span> caracteres. La mayoría de los motores de búsqueda usan un máximo de 60 caracteres para el título.</p>';
    
                                echo $sseoForm->textarea('sseo_default_meta_description', array(
                                    'label' => 'Default Description',
                                    'value' => esc_attr(get_option('sseo_default_meta_description')),
                                ));
    
                                echo '<p><span id="sseo_desc_count">0</span> caracteres. La mayoría de los motores de búsqueda usan un máximo de 155 caracteres para la descripción.</p>';
    
                                echo $sseoForm->textarea('sseo_default_meta_keywords', array(
                                    'label' => 'Default Keywords',
                                    'value' => esc_attr(get_option('sseo_default_meta_keywords')),
                                ));
    
                                echo '<p> Una lista de tus palabras clave (keywords) separadas por comas que serán colocadas en META keywords.</p>';

                                echo $sseoForm->input('sseo_default_meta_image', array(
                                    'label' => 'Image url',
                                    'value' => esc_attr(get_option('sseo_default_meta_image')),
                                ));
    
                                echo '<p> La imagen a mostrar en la página principal o si el post o página no contiene una imagen destacada.</p>';
    
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="metabox-holder">	
            <div class="meta-box-sortables ui-sortable" style="min-height: 0">
                <div id="simple_seo_buy" class="postbox">
                    <h3 class="hndle ui-sortable-handle"><span>Google</span></h3>
                    <div class="inside">
                        <div class="main">
                            <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="sseo_gsite_verification">Google Webmaster Tools (<a href="https://support.google.com/webmasters/answer/35179?hl=en" target="_blank">Site Verification</a>)</label></p>
                            <input name="sseo_gsite_verification" type="text" size="60" id="sseo_gsite_verification" value="<?php echo esc_attr(get_option('sseo_gsite_verification')); ?>">
                            
                            <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="sseo_ganalytics">Google Analytics (<a href="https://support.google.com/analytics/answer/1008080?hl=en" target="_blank">Get Your Code</a>)</label></p>
                            <input name="sseo_ganalytics" type="text" size="60" id="sseo_ganalytics" value="<?php echo esc_attr(get_option('sseo_ganalytics')); ?>">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <?php submit_button(); ?>
    
        </form>
    </div>
    
    
    <?php }