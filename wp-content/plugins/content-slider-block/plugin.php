<?php
/**
 * Plugin Name: Content Slider Block
 * Description: Display your goal to your visitor in bountiful way with content slider block
 * Version: 2.0.0
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: content-slider-block
 */

// ABS PATH
if ( !defined( 'ABSPATH' ) ) { exit; }

// Constant
define( 'CSB_PLUGIN_VERSION', 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '2.0.0' );
define( 'CSB_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'assets/' );

// Generate Styles
class CSBStyleGenerator {
    public static $styles = [];
    public static function addStyle($selector, $styles){
        if(array_key_exists($selector, self::$styles)){
           self::$styles[$selector] = wp_parse_args(self::$styles[$selector], $styles);
        }else { self::$styles[$selector] = $styles; }
    }
    public static function renderStyle(){
        $output = '';
        foreach(self::$styles as $selector => $style){
            $new = '';
            foreach($style as $property => $value){
                if($value == ''){ $new .= $property; }else { $new .= " $property: $value;"; }
            }
            $output .= "$selector { $new }";
        }
        return $output;
    }
}

// Content Slider
class CSBContentSliderBlock {
    protected static $_instance = null;

    function __construct(){
        add_action( 'enqueue_block_assets', [$this, 'enqueue_assets'] );
        add_action( 'init', [$this, 'register'] );
    }

    public static function instance(){
        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function enqueue_assets() { wp_enqueue_script( 'swiperJS', CSB_ASSETS_DIR . 'js/swiper-bundle.min.js', [], '7.0.3', true ); }
    
    function register() {
        wp_register_script( 'csb_editor_script', plugins_url( 'dist/editor.js', __FILE__ ), array( 'wp-blob', 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-compose', 'wp-data', 'wp-element', 'wp-html-entities', 'wp-i18n', 'wp-rich-text', 'jquery', 'swiperJS' ), CSB_PLUGIN_VERSION, false ); // Backend Script
        wp_register_style( 'csb_editor_style', plugins_url( 'dist/editor.css', __FILE__ ), array( 'wp-edit-blocks' ), CSB_PLUGIN_VERSION ); // Backend Style
        wp_register_script( 'csb_script', plugins_url( 'dist/script.js', __FILE__ ), array( 'jquery', 'swiperJS' ), CSB_PLUGIN_VERSION, true ); // Frontend Script
        wp_register_style( 'csb_style', plugins_url( 'dist/style.css', __FILE__ ), array( 'wp-editor' ), CSB_PLUGIN_VERSION ); // Frontend Style

        // Register Blocks
        register_block_type( 'csb/content-slider-block', array(
            'editor_script' => 'csb_editor_script',
            'editor_style'  => 'csb_editor_style',
            'script'        => 'csb_script',
            'style'         => 'csb_style',
            'render_callback' => [$this, 'render']
        ) );

        wp_set_script_translations( 'csb_editor_script', 'content-slider-block', plugin_dir_path( __FILE__ ) . 'languages' ); // Translate
    }
    
    // Render
    function render($attributes){
        extract( $attributes );
        $align = $align ?? '';
        $cId = $cId ?? '';
        $slides = $slides ?? array( 
            array( 'background' => array( 'color' => '#00000080' ), 'position' => 'center center', 'title' => 'Slide Title 1', 'titleColor' => '#fff', 'description' => 'This content area describes slider 1 descriptions/details.', 'descColor' => '#fff', 'btnText' => 'Button 1', 'btnLink' => '#', 'btnColors' => array( 'color' => '#fff', 'bg' => '#4527a4' ), 'btnHovColors' => array( 'color' => '#fff', 'bg' => '#8344c5' ) ),
            array( 'background' => array( 'color' => '#00000080' ), 'position' => 'center center', 'title' => 'Slide Title 2', 'titleColor' => '#fff', 'description' => 'This content area describes slider 2 descriptions/details.', 'descColor' => '#fff', 'btnText' => 'Button 2', 'btnLink' => '#', 'btnColors' => array( 'color' => '#fff', 'bg' => '#4527a4' ), 'btnHovColors' => array( 'color' => '#fff', 'bg' => '#8344c5' ) )
        );
        $sliderWidth = $sliderWidth ?? '100%';
        $sliderHeight = $sliderHeight ?? '400px';
        $sliderAlign = $sliderAlign ?? 'center';
        $isPage = $isPage ?? true;
        $pageColor = $pageColor ?? '#fff';
        $pageWidth = $pageWidth ?? '15px';
        $pageHeight = $pageHeight ?? '15px';
        $pageBorder = $pageBorder ?? array( 'radius' => '50%' );
        $isPrevNext = $isPrevNext ?? true;
        $prevNextColor = $prevNextColor ?? '#fff';
        $isTitle = $isTitle ?? true;
        $titleTypo = $titleTypo ?? array( 'fontSize' => 25 );
        $titleColor = $titleColor ?? '#fff';
        $titleMargin = $titleMargin ?? array( 'bottom' => '15px' );
        $isDesc = $isDesc ?? true;
        $descTypo = $descTypo ?? array( 'fontSize' => 15 );
        $descColor = $descColor ?? '#fff';
        $descMargin = $descMargin ?? array( 'bottom' => '15px' );
        $isBtn = $isBtn ?? true;
        $btnTypo = $btnTypo ?? array( 'fontSize' => 16 );
        $btnColors = $btnColors ?? array( 'color' => '#fff', 'bg' => '#ff4500' );
        $btnHovColors = $btnHovColors ?? array( 'color' => '#fff', 'bg' => '#ff7500' );
        $btnPadding = $btnPadding ?? array( 'vertical' => '12px', 'horizontal' => '35px' );
        $btnBorder = $btnBorder ?? array( 'radius' => '3px' );

        $contentSliderStyle = new CSBStyleGenerator(); // Generate Styles
        $contentSliderStyle::addStyle("#csbContentSlider-$cId", array( 'text-align' => $sliderAlign ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider", array(
            'width' => $sliderWidth,
            'height' => $sliderHeight
        ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .slide", array( 'height' => $sliderHeight ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .slide .sliderTitle", array(
            'color' => $titleColor,
            $titleTypo['styles'] ?? 'font-size: 25px;' => '',
            'margin' => $titleMargin['styles'] ?? '0 0 15px 0'
        ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .slide .sliderDescription", array(
            'color' => $descColor,
            $descTypo['styles'] ?? 'font-size: 15px;' => '',
            'margin' => $descMargin['styles'] ?? '0 0 15px 0'
        ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .slide .sliderBtn", array(
            $btnColors['styles'] ?? 'color: #fff; background: #ff4500;' => '',
            $btnTypo['styles'] ?? 'font-size: 16px;' => '',
            'padding' => $btnPadding['styles'] ?? '12px 35px',
            $btnBorder['styles'] ?? 'border-radius: 3px;' => ''
        ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .slide .sliderBtn:hover", array( $btnHovColors['styles'] ?? 'color: #fff; background: #ff7500;' => '' ));

        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .swiper-pagination .swiper-pagination-bullet", array(
            'background' => $pageColor,
            'width' => $pageWidth,
            'height' => $pageHeight,
            $pageBorder['styles'] ?? 'border-radius: 50%;' => ''
        ));
        $contentSliderStyle::addStyle("#csbContentSlider-$cId .csbContentSlider .swiper-button-prev, #csbContentSlider-$cId .csbContentSlider .swiper-button-next", array( 'color' => $prevNextColor ));

        $jsonData = json_encode( array( 'columns' => $columns ?? array( 'desktop' => 1, 'tablet' => 1, 'mobile' => 1 ), 'columnGap' => $columnGap ?? 15, 'isLoop' => $isLoop ?? true, 'isTouchMove' => $isTouchMove ?? false, 'isAutoplay' => $isAutoplay ?? true, 'speed' => $speed ?? 1.5, 'effect' => $effect ?? 'slide', 'isPageClickable' => $isPageClickable ?? true, 'isPageDynamic' => $isPageDynamic ?? true ) );

        ob_start(); ?>
        <div class='wp-block-csb-content-slider-block <?php echo 'align' . esc_attr( $align ); ?>' id='csbContentSlider-<?php echo esc_attr($cId); ?>' data-swiper='<?php echo esc_attr($jsonData); ?>'>
            <style>@import url(<?php echo esc_url($titleTypo['googleFontLink'] ?? ''); ?>); @import url(<?php echo esc_url($descTypo['googleFontLink'] ?? ''); ?>); @import url(<?php echo esc_url($btnTypo['googleFontLink'] ?? ''); ?>);<?php echo wp_kses($contentSliderStyle::renderStyle(), []);
            foreach ( $slides as $index => $slide ) {
                $slideBGStyle = $slide['background']['styles'] ?? 'background-color: #00000080;';
                $slideBtnStyle = $slide['btnColors']['styles'] ?? 'color: #fff; background: #4527a4;';
                $slideBtnHovStyle = $slide['btnHovColors']['styles'] ?? 'color: #fff; background: #8344c5;';
                $slideStyles = "#csbContentSlider-$cId .csbContentSlider .slide-$index{ $slideBGStyle }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderTitle{ color: ". $slide['titleColor'] ." }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderDescription{ color: ". $slide['descColor'] ." }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderBtn{ ". $slideBtnStyle ." }#csbContentSlider-$cId .csbContentSlider .slide-$index .sliderBtn:hover{ ". $slideBtnHovStyle ." }";
                echo esc_html( $slideStyles );
            } ?>
        </style>
            <div class='csbContentSlider'>
                <div class='swiper-wrapper'>
                    <?php foreach ($slides as $index => $slide) {
                        $slideBtnLink = $slide['btnLink'] ?? ''; ?>
                        <div class='slide slide-<?php echo esc_attr( $index ); ?> swiper-slide'>
                            <div class='sliderContent <?php echo esc_attr( str_replace( ' ', '-', $slide['position'] ?? 'center center' ) ); ?>'>
                                <?php echo $isTitle && !empty( $slide['title'] ) ? "<h2 class='sliderTitle'>". wp_kses_post( $slide['title'] ) ."</h2>" : ''; ?>
                                <?php echo $isDesc && !empty( $slide['description'] ) ? "<p class='sliderDescription'>". wp_kses_post( $slide['description'] ) ."</p>" : ''; ?>
                                <?php echo $isBtn && !empty( $slide['btnText'] ) ? "<a href='$slideBtnLink' class='sliderBtn' target='_blank' rel='noreferrer'>". wp_kses_post( $slide['btnText'] ) ."</a>" : ''; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php echo $isPage ? "<div class='swiper-pagination'></div>" : ''; ?>
                <?php echo $isPrevNext ? "<div class='swiper-button-prev'></div><div class='swiper-button-next'></div>" : ''; ?>
            </div>
        </div>

        <?php $contentSliderStyle::$styles = []; // Empty styles
        return ob_get_clean();
    }
}
CSBContentSliderBlock::instance();