<div class="wrap">
    <?php
    if (isset($_GET['action'])){

        if($_GET['action'] == "delete"){

            $names = '';
            $ids = array_map('absint', explode(',', $_GET['id']));

            if(count($ids) == 1)
                $prefix = 'Slider';
            else
                $prefix = 'Sliders';

            foreach ($ids as $id) {

                if($names != '')
                    $names = $names . ', ';

                $slider = get_option('sliders'.$id);

                if($slider)
                    $names = $names . $id;
            }

            echo '<div id="message" class="updated notice is-dismissible below-h2">
                        <p><strong>'.esc_html($prefix) .' </strong><i>' . esc_html($names).'</i> <strong>deleted</strong>. <a class="undo" href="#">Undo</a></p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
        }
        elseif($_GET['action'] == "delete_all"){

            echo '<div id="message" class="updated notice is-dismissible below-h2">
                        <p>All sliders deleted. <a class="undo" href="#">Undo		</a></p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';

        }
        elseif($_GET['action'] == "import_from_json_confirm" ) {

            echo '<div id="message" class="updated notice is-dismissible below-h2">
                        <p>Sliders imported from JSON. <a class="undo" href="#">Undo		</a></p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>';
        }
    }
    ?>

    <div id="STX-admin" class="STX-admin">
        <div class="STX-nav">
            <div class="STX-box dashicons-before dashicons-image-flip-horizontal"></div>
            <div class="STX-header-wrapp">
                <p class="STX-header-text"><?php esc_html_e( 'NEXTCODE SLIDER', 'stx' ); ?></p>
            </div>
            <div class="STX-header">
                <div class="STX-header-admin-nav STX-header-right">
                    <a class="STX-h4 STX-btn-topbar STX-btn-dashboard" data-form-name="dashboard"><?php esc_html_e( 'Dashboard', 'stx' ); ?></a>
                </div>
            </div>
        </div>
        <div class="STX-admin-content STX-table STX-table-fixed STX-content">
            <div class="STX-tr">
                <div class="STX-dashboard-wrapp STX-td STX-content-base-bg STX-content-wrapper">
                    <div class="STX-heading-bar ">
                        <div class="STX-heading-bar-left">
                            <div class="STX-h1 STX-heading"><?php esc_html_e( 'Dashboard', 'stx' ); ?></div>
                        </div>
                        <a class="delete_all_sliders" title="Delete all sliders">
                            <div class="STX-slider-trash-btn-large btns-dashboard-nav"></div>
                        </a>
                        <div class="STX-slider-export-btn btns-dashboard-nav" title="Export sliders">
                            <a href='<?php echo admin_url( "admin.php?page=nextcode_slider_admin&action=download_json" ); ?>'><?php esc_html_e( 'EXPORT', 'stx' ); ?></a>
                        </div>
                        <div class="STX-slider-import-btn btns-dashboard-nav" title="Import sliders"><?php esc_html_e( 'IMPORT', 'stx' ); ?></div>
                        <div class="dropdown btns-dashboard-nav orderby">
                            <div class="select">
                                <span><?php esc_html_e( 'Order by', 'stx' ); ?></span>
                                <i aria-hidden="true" class="fa fa-chevron-down"></i>
                            </div>
                            <input type="hidden" name="order-by">
                            <ul class="dropdown-menu">
                                <li id="newestFirst"><?php esc_html_e( 'Newest first', 'stx' ); ?></li>
                                <li id="oldestFirst"><?php esc_html_e( 'Oldest first', 'stx' ); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="STX-outer-container">
                        <div id="STX-container">
                            <div class="STX-inner">
                                <div class="STX-container">
                                    <div class="STX-rect STX-h3 STX-uc STX-edit-slider-box">
                                        <div class="STX-create STX-btn STX-btn-l STX-button-green STX-radius-global STX-uc STX-h3" href="#">
                                            <a href='<?php echo admin_url( "admin.php?page=nextcode_slider_admin&action=add_new" ); ?>'><?php esc_html_e( 'NEW SLIDER', 'stx' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="STX-modal-window">
        <div class="STX-modal-window-overlay"></div>
        <div class="STX-modal-window-inside import">
            <div class="STX-heading-bar-modal">
                <div class="STX-heading-bar-left">
                    <div class="STX-h1 STX-heading STX-modal-window-title"><?php esc_html_e( 'Import Sliders', 'stx' ); ?></div>
                </div>
                <div class="STX-modal-close-btn">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </div>
            </div>
            <div class="STX-modal-window-content import">
                <div class="STX-editing-slide-table-wrapp">
                    <div class="slider_preview"></div>
                    <div class="STX-modal-window-import-text" contentEditable=true data-text="To import Sliders copy and paste sliders config here">
                        <form method="post" id="slider-modal-import-form" enctype="multipart/form-data" action="admin.php?page=nextcode_slider_admin&amp;action=import_from_json_confirm">
                            <?php
                            if (isset($_GET['action']) && $_GET['action'] == "download_json") {
                                echo '<textarea id="STX-admin-json-text" rows="20" cols="100" >' . json_encode($sliders) . '</textarea>';
                            }
                            ?>
                            <textarea name="sliders" id="STX-admin-json-text" rows="20" cols="100" placeholder="To import Sliders copy and paste sliders config here"></textarea>
                            <input type="submit" name="submit" id="submit" class="STX-slider-import-btn btns-dashboard-nav STX-slider-import-btn-modal" value="<?php esc_html_e( 'IMPORT', 'stx' ); ?>">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
wp_enqueue_media();

wp_enqueue_script('nextcodeslider-sliders', nextcodeslider()->PLUGIN_DIR_URL."js/sliders.js", array('jquery','jquery-ui-sortable','jquery-ui-resizable','jquery-ui-selectable','jquery-ui-tabs'), $this->PLUGIN_VERSION);
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

wp_enqueue_script("nextcodeslider-build", nextcodeslider()->PLUGIN_DIR_URL."js/build/nextcodeSlider.js", array('jquery'), $this->PLUGIN_VERSION);

wp_localize_script('nextcodeslider-sliders', 'sliders', json_encode($sliders) );

if (isset($_GET['action']) && $_GET['action'] == "download_json") {
    wp_localize_script( 'nextcodeslider-sliders', 'sliders_json', json_encode($sliders) );
}
