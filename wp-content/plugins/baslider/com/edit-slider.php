<div class='wrap'>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <div id="post-body-content">
                <div id='edit-slider'>
                    <form method="post" id="slider-options-form" enctype="multipart/form-data" action="admin-ajax.php?page=nextcode_slider_admin&action=save_settings&id=<?php echo( esc_html($current_id));?>">

                        <div id="STX-admin" class="STX-admin">
                            <div class="STX-nav">
                                <div class="STX-box dashicons-before dashicons-image-flip-horizontal"></div>
                                <div class="STX-header-wrapp">
                                    <p class="STX-header-text"><?php esc_html_e( 'NEXTCODE SLIDER', 'stx' ); ?></p>
                                </div>
                                <div class="STX-header-editing-nav STX-header-right">
                                    <a href="admin.php?page=nextcode_slider_admin" class="STX-h4 STX-btn-topbar-edit STX-btn-dashboard-edit" data-form-name="dashboard"><?php esc_html_e( 'Dashboard', 'stx' ); ?></a>
                                    <span>
									<i aria-hidden="true" class="fa fa-angle-right"></i>
								</span>
                                    <a class="STX-h4 STX-active STX-btn-topbar-edit btn-slider-name" data-form-name="slider-name"></a>
                                </div>
                            </div>
                            <div class="STX-admin-content STX-table STX-table-fixed STX-content">
                                <div class="STX-tr">
                                    <div class="STX-edit-wrapp STX-td STX-content-base-bg">
                                        <div class="STX-heading-bar ">
                                            <div class="STX-heading-bar-left">
                                                <div class="STX-h1 STX-heading edit-slider-text" data-form-name="slider-name"><?php esc_html_e( 'Edit Slider', 'stx' ); ?></div>
                                            </div>
                                            <div class="nextcode-slider-sticky-btns">
                                                <div class="STX-slider-cancel-btn btns-dashboard-nav" title="Cancel">
                                                    <a href="admin.php?page=nextcode_slider_admin"><?php esc_html_e( 'CANCEL', 'stx' ); ?></a>
                                                </div>
                                                <input type="submit" form="slider-options-form" title="Save" value="<?php esc_html_e( 'SAVE', 'stx' ); ?>" class="slider-save-btn-disabled slider-save-btn btns-dashboard-nav"/>
                                                <a id="nextcode-slider-preview" class="slider-preview-btn-disabled slider-preview-btn btns-dashboard-nav slider-preview" title="Preview"><?php esc_html_e( 'PREVIEW', 'stx' ); ?></a>
                                                <a class="delete-all-slides-button" title="Delete all slides">
                                                    <div class="STX-slider-trash-btn-large-disabled STX-slider-trash-btn-large btns-dashboard-nav"></div>
                                                </a>
                                            </div>
                                            <div class="STX-saved-notification-wrapper">
                                                <div class="STX-saved-notification-content"><?php esc_html_e( 'Slider saved', 'stx' ); ?></div>
                                            </div>
                                        </div>
                                        <div class="STX-slides-container ui-sortable">
                                        </div>
                                        <div class="STX-adding-STX-slides-container">
                                            <div class="STX-h2"><?php esc_html_e( 'Add slide', 'stx' ); ?></div>
                                            <div class="STX-edit-slides-box STX-rect STX-h3 STX-uc">
                                                <div class="STX-edit-slides-box-small-image-slide STX-create STX-btn STX-btn-l STX-button-green STX-radius-global STX-uc STX-h3">
                                                    <a class="add-slides-button " data-uploader-title="Add slide to slider" data-uploader-button-text="Add slide"><?php esc_html_e( 'Image / Video', 'stx' ); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="STX-main-table-wrapp">
                                            <div class="STX-td STX-sidebar STX-sidebar-base-bg">
                                                <dl class="STX-list STX-h3">
                                                    <dt><a class="STX-btn-menu" data-form-name="publish"><?php esc_html_e( 'Publish', 'stx' ); ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="general_settings"><?php esc_html_e( 'General', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="size"><?php esc_html_e( 'Size', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="autoplay"><?php esc_html_e( 'Autoplay', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="buttons"><?php esc_html_e( 'Buttons', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="arrows"><?php esc_html_e( 'Navigation', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="pagination"><?php esc_html_e( 'Pagination', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="hash_navigation"><?php esc_html_e( 'Hash navigation', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                    <dt><a class="STX-btn-menu" data-form-name="loading"><?php esc_html_e( 'Loading', 'stx' );if(!nextcodeslider()->is_valid()){echo '<span class="nextcodeslider-pro-text"> (PRO)</span>';} ?></a></dt>
                                                </dl>
                                            </div>
                                            <div class="general-settings-form">
                                                <div class="slider-options-wrappper">
                                                    <div class="column-left">
                                                        <div class="options_publish STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Publish', 'stx' ); ?></div>
                                                            <div class="STX-publish-table-wrapp">
                                                                <table class="form-table" id="slider-options-publish">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_general_settings STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'General', 'stx' ); ?></div>
                                                            <div class="general-settings-table-wrapp">
                                                                <table class="form-table" id="slider-options-general-settings">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_size STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Size', 'stx' ); ?></div>
                                                            <div class="size-table-wrapp">
                                                                <table class="form-table" id="slider-options-size">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_autoplay STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Autoplay', 'stx' ); ?></div>
                                                            <div class="autoplay-table-wrapp">
                                                                <table class="form-table" id="slider-options-autoplay">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_arrows STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Navigation', 'stx' ); ?></div>
                                                            <div class="arrows-table-wrapp">
                                                                <table class="form-table" id="slider-options-arrows">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_pagination STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Pagination', 'stx' ); ?></div>
                                                            <div class="pagination-table-wrapp">
                                                                <table class="form-table" id="slider-options-pagination">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_hash_navigation STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Hash navigation', 'stx' ); ?></div>
                                                            <div class="hash-navigation-table-wrapp">
                                                                <table class="form-table" id="slider-options-hash-navigation">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_buttons STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Buttons', 'stx' ); ?></div>
                                                            <div class="buttons-table-wrapp">
                                                                <table class="form-table" id="slider-options-buttons">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="options_loading STX-form-tab">
                                                            <div class="STX-h2 STX-content-box-title-bg"><?php esc_html_e( 'Loading', 'stx' ); ?></div>
                                                            <div class="loading-table-wrapp">
                                                                <table class="form-table" id="slider-options-loading">
                                                                    <tbody/>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="slider-preview-container" style="display:none;">
                                                    <div id="slider-preview-container-inner" style="position:relative;height:100%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="STX-modal-window">
                            <div class="STX-modal-window-overlay"></div>
                            <div class="STX-modal-window-inside apply">
                                <div class="STX-heading-bar-modal">
                                    <div class="STX-heading-bar-left">
                                        <div class="STX-h1 STX-heading STX-modal-window-title"></div>
                                    </div>
                                    <div class="STX-modal-close-btn">
                                        <i aria-hidden="true" class="fa fa-times"></i>
                                    </div>
                                </div>
                                <div class="STX-modal-window-content apply">
                                    <div class="STX-editing-slide-table-wrapp">
                                        <div class="STX-preview-preloader"></div>
                                        <div class="slider_preview"></div>
                                        <table class="form-table" id="STX-editing-slide-settings">
                                            <tbody/>
                                        </table>
                                        <input type="submit" name="submit" id="submit" class="btns-dashboard-nav slider-apply-btn-modal slider-apply-btn-modal-disabled" value="<?php esc_html_e( 'APPLY', 'stx' ); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
wp_enqueue_media();

;
wp_enqueue_script('alpha-color-picker', nextcodeslider()->PLUGIN_DIR_URL. 'js/alpha-color-picker.min.js', array( 'jquery', 'wp-color-picker' ), $this->PLUGIN_VERSION, true);

wp_enqueue_style('edit-slider-css', nextcodeslider()->PLUGIN_DIR_URL. "css/nextcode-slider.css", array(), $this->PLUGIN_VERSION);
wp_enqueue_style('animate-slider-css', nextcodeslider()->PLUGIN_DIR_URL. "css/animate.min.css", array(), $this->PLUGIN_VERSION);
wp_enqueue_style('alpha-color-picker', nextcodeslider()->PLUGIN_DIR_URL. 'css/alpha-color-picker.min.css', array( 'wp-color-picker'), $this->PLUGIN_VERSION);

wp_enqueue_style( "nextcodeslider", nextcodeslider()->PLUGIN_DIR_URL."css/style.min.css" , array(), $this->PLUGIN_VERSION);
wp_enqueue_style( "nextcodeslider-swiper", nextcodeslider()->PLUGIN_DIR_URL."css/swiper.min.css" , array(), $this->PLUGIN_VERSION);
wp_enqueue_style( "nextcodeslider-fontawesome", "https://use.fontawesome.com/releases/v5.8.1/css/all.css" , array(), $this->PLUGIN_VERSION);

wp_enqueue_script("nextcodeslider-lib-three", nextcodeslider()->PLUGIN_DIR_URL."js/lib//three.min.js", array('jquery'), $this->PLUGIN_VERSION);
wp_enqueue_script("nextcodeslider-lib-swiper", nextcodeslider()->PLUGIN_DIR_URL."js/lib/swiper.min.js", array('jquery'), $this->PLUGIN_VERSION);
wp_enqueue_script("nextcodeslider-lib-tween", nextcodeslider()->PLUGIN_DIR_URL."js/lib/Tween.min.js", array('jquery'), $this->PLUGIN_VERSION);
wp_enqueue_script("nextcodeslider-lib-webfontloader", nextcodeslider()->PLUGIN_DIR_URL."js/lib/webfontloader.js", array('jquery'), $this->PLUGIN_VERSION);

wp_enqueue_script("nextcodeslider-embed", nextcodeslider()->PLUGIN_DIR_URL."js/embed.js", array('jquery'), $this->PLUGIN_VERSION);
wp_enqueue_script("nextcodeslider-build", nextcodeslider()->PLUGIN_DIR_URL."js/build/nextcodeSlider.js", array('jquery'), $this->PLUGIN_VERSION);
wp_enqueue_script("read-slider-admin", nextcodeslider()->PLUGIN_DIR_URL."js/plugin_admin.js", array('nextcodeslider-build', 'jquery','jquery-ui-sortable','jquery-ui-resizable','jquery-ui-selectable','jquery-ui-tabs'),$this->PLUGIN_VERSION);


$ajax_nonce = wp_create_nonce( "saving-nextcodeslider");
$sliders[$current_id]['security'] = $ajax_nonce;

wp_localize_script( 'read-slider-admin', 'options', json_encode($sliders[$current_id]) );
wp_localize_script( 'read-slider-admin', 'nextcodesliderL10n', array(
        'is_valid' => nextcodeslider()->is_valid(),
) );
