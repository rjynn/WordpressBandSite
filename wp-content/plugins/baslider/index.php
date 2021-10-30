<?php
/*
 * Plugin Name: Image Slider by NextCode
 * Plugin URI:  https://pluginjungle.com/downloads/image-slider/
 * Description: Make more impact to your website visitors with your images and videos in Nextcode slider plugin.
 * Version:     1.1.2
 * Author:      NextCode
 * Author URI:  https://pluginjungle.com/downloads/image-slider/
 * License:     GPL-2.0+
 * Text Domain: baslider
 */




include_once( __DIR__.'/com/nextcode-slider.php' );

$nextcodeslider = NextCodeSlider::get_instance();
$nextcodeslider->PLUGIN_VERSION = '1.1.2';
$nextcodeslider->LICENSE = 1;
$nextcodeslider->PLUGIN_DIR_URL = plugin_dir_url( __FILE__ );
$nextcodeslider->PLUGIN_DIR_PATH = plugin_dir_path( __FILE__ );

/**
 * @return NextCodeSlider|null
 */
function nextcodeslider() {
    return NextCodeSlider::get_instance();
}

register_activation_hook( __FILE__, array('NextCodeSlider', 'activate' ));
