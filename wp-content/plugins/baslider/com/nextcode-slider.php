<?php

/*plugin class*/

class NextCodeSlider
{

    public $PLUGIN_VERSION;
    public $PLUGIN_DIR_URL;
    public $PLUGIN_DIR_PATH;
    public $LICENSE;

    // Singleton
    private static $instance = null;

    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    protected function __construct()
    {
        $this->add_actions();
        register_activation_hook($this->my_plugin_basename(), array($this, 'activation_hook'));
    }

    public function activation_hook($network_wide)
    {
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style("nextcodeslider-animate-css", $this->PLUGIN_DIR_URL . "css/animate.min.css", array(), $this->PLUGIN_VERSION);
        wp_enqueue_style("nextcodeslider", $this->PLUGIN_DIR_URL . "css/style.min.css", array(), $this->PLUGIN_VERSION);
        wp_enqueue_style("nextcodeslider-swiper", $this->PLUGIN_DIR_URL . "css/swiper.min.css", array(), $this->PLUGIN_VERSION);
        wp_enqueue_style("nextcodeslider-fontawesome", "https://use.fontawesome.com/releases/v5.8.1/css/all.css", array(), $this->PLUGIN_VERSION);

        wp_enqueue_script("nextcodeslider-lib-three", $this->PLUGIN_DIR_URL . "js/lib//three.min.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_enqueue_script("nextcodeslider-lib-swiper", $this->PLUGIN_DIR_URL . "js/lib/swiper.min.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_enqueue_script("nextcodeslider-lib-tween", $this->PLUGIN_DIR_URL . "js/lib/Tween.min.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_enqueue_script("nextcodeslider-lib-webfontloader", $this->PLUGIN_DIR_URL . "js/lib/webfontloader.js", array('jquery'), $this->PLUGIN_VERSION);

        wp_enqueue_script("nextcodeslider-embed", $this->PLUGIN_DIR_URL . "js/embed.js", array('jquery'), $this->PLUGIN_VERSION);
        wp_enqueue_script("nextcodeslider-build", $this->PLUGIN_DIR_URL . "js/build/nextcodeSlider.js", array('jquery'), $this->PLUGIN_VERSION);
    }


    public function admin_link($links)
    {
        array_unshift($links, '<a href="' . get_admin_url() . 'options-general.php?page=sliders">Admin</a>');
        return $links;
    }


    public function admin_menu()
    {

        add_options_page(
            esc_html__("NextCode Slider Admin", "stx"),
            esc_html__("NextCode Slider", "stx"),
            "publish_posts",
            "nextcode_slider_admin",
            array($this, "nextcode_slider_admin")
        );

        add_menu_page(
            esc_html__("Slider", "stx"), //page title
            esc_html__("Slider", "stx"), // menu title
            'publish_posts', //capability
            'nextcode_slider_admin',//menu slug
            array($this, 'nextcode_slider_admin'), // function
            'dashicons-image-flip-horizontal' // icon
        );

        add_submenu_page(
            'nextcode_slider_admin',
            esc_html__("Sliders", "stx"),
            esc_html__("Sliders", "stx"),
            'publish_posts',
            'nextcode_slider_admin',
            array($this, 'nextcode_slider_admin')
        );

        add_submenu_page(
            'nextcode_slider_admin',
            esc_html__("Add New Slider", "stx"),
            esc_html__("Add New Slider", "stx"),
            'publish_posts',
            'nextcodeslider_add_new',
            array($this, 'nextcodeslider_add_new')
        );


        // Gutenberg block
        if (function_exists('register_block_type')) {

            // Register block, and explicitly define the attributes we accept.
            register_block_type('nextcodeslider/embed', array(
                'attributes' => array(
                    'id' => array(
                        'type' => 'string',
                    )
                ),
            ));

            add_action('enqueue_block_assets', array($this, 'enqueue_block_assets'));
            add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));

        }

    }

    public function nextcodeslider_add_new()
    {
        $_GET['action'] = "add_new";
        $this->nextcode_slider_admin();
    }

    public function enqueue_block_assets()
    {

    }

    public function enqueue_block_editor_assets()
    {

        wp_enqueue_script("nextcodeslider-blocks-js", nextcodeslider()->PLUGIN_DIR_URL . "js/blocks-editor.js", array('wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element'), $this->PLUGIN_VERSION);

        $slider_ids = get_option('nextcodeslider_ids');

        wp_localize_script('nextcodeslider-blocks-js', 'slider_ids', json_encode($slider_ids));

    }

    //options page
    public function nextcode_slider_admin()
    {

        include_once(__DIR__ . '/admin.php');

    }

    public function init()
    {
        add_shortcode('nextcodeslider', array($this, 'on_shortcode'));

    }

    public function plugins_loaded()
    {
        load_plugin_textdomain('nextcodeslider', false, dirname($this->my_plugin_basename()) . '/lang/');
    }

    protected function add_actions()
    {

        add_action('plugins_loaded', array($this, 'plugins_loaded'));

        add_action('init', array($this, 'init'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 5, 0);

        if (is_admin()) {
            add_action('admin_menu', array($this, 'admin_menu'));
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'admin_link'));
            add_action('wp_ajax_nextcodeslider_save', array($this, 'nextcodeslider_save_callback'));
            add_action('wp_ajax_nopriv_nextcodeslider_save', array($this, 'nextcodeslider_save_callback'));

        }
    }

    public function on_shortcode($atts, $content = null)
    {

        $args = shortcode_atts(
            array(
                'id' => '-1',
                'name' => '-1',
                'width' => '600',
                'height' => '400'
            ),
            $atts
        );

        // trace($atts);

        $id = (int)$args['id'];
        $name = $args['name'];

        if ($name != -1) {
            $slider_ids = get_option('slider_ids');

            foreach ($slider_ids as $id) {
                $_s = get_option('nextcodeslider_' . $id);
                if ($_s && $_s['name'] == $name) {
                    $slider = $_s;
                    $id = $slider['id'];
                    break;
                }
            }
        } else if ($id != -1) {
            $slider = get_option('nextcodeslider_' . $id);
        }

        $slider['rootFolder'] = nextcodeslider()->PLUGIN_DIR_URL;

        $output = "<div id='slider-wrapper' class='slider_instance " . $id . "' data-slider-options='" . json_encode($slider) . "'></div>";

        return $output;

    }

    public function nextcodeslider_save_callback()
    {
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'saving-nextcodeslider')) {
            echo 0;
            die;
        }

        $current_id = $page_id = '';
        // handle action from url

        if (isset($_GET['id'])) {
            $current_id = absint($_GET['id']);
        }

        $slider_ids = get_option('nextcodeslider_ids');
        if (!$slider_ids) {
            $slider_ids = array();
        }
        $sliders = array();
        foreach ($slider_ids as $id) {
            $_slider = get_option('nextcodeslider_' . $id);
            if ($_slider) {
                $sliders[$id] = $_slider;
            } else {
                //remove id from array
                $slider_ids = array_diff($slider_ids, array($id));
            }
        }

        if ($_POST['status'] == 'draft') {
            array_push($slider_ids, $current_id);
            add_option('nextcodeslider_' . $current_id, array());
            $sliders[$current_id] = array();
        }

        update_option('nextcodeslider_ids', $slider_ids);

        $new = array_merge($sliders[$current_id], $this->sanitizeSliderData($_POST));
        $sliders[$current_id] = $new;

        $sliders[$current_id]['status'] = 'published';

        update_option('nextcodeslider_' . $current_id, $sliders[$current_id]);

        echo json_encode($new);
        // echo json_encode($sliders[$current_id]);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    protected function my_plugin_basename()
    {
        $basename = plugin_basename(__FILE__);
        if ('/' . $basename == __FILE__) { // Maybe due to symlink
            $basename = basename(dirname(__FILE__)) . '/' . basename(__FILE__);
        }
        return $basename;
    }

    public function sanitizeImportData($data)
    {
        $sanitizedData = array();
        $data = json_decode($data, true);

        if (is_array($data) && !empty($data)) {
            foreach ($data as $key=>$slide) {
                $sanitizedData[$key] = $this->sanitizeSliderData($slide);
            }
        }


        return $sanitizedData;
    }

    protected function my_plugin_url()
    {
        $basename = plugin_basename(__FILE__);
        if ('/' . $basename == __FILE__) { // Maybe due to symlink
            return plugins_url() . '/' . basename(dirname(__FILE__)) . '/';
        }
        // Normal case (non symlink)
        return plugin_dir_url(__FILE__);
    }

    public function sanitizeSliderData($data)
    {
        $sanitized = array();
        $sanitized['instanceName'] = $this->sanitize($data['instanceName'], 'text');
        $sanitized['initialSlide'] = $this->sanitize($data['initialSlide'], 'absint');
        $sanitized['shadow'] = $this->sanitize($data['shadow'], 'text');
        $sanitized['grabCursor'] = $this->sanitize($data['grabCursor'],'text');
        $sanitized['stopOnLastSlide'] = $this->sanitize($data['stopOnLastSlide'], 'text');
        $sanitized['fullscreen'] = $this->sanitize($data['fullscreen'], 'text');
        $sanitized['responsive'] = $this->sanitize($data['responsive'], 'text');
        $sanitized['ratio'] = $this->sanitize($data['ratio'], 'text');
        $sanitized['ratio1800'] = $this->sanitize($data['ratio1800'], 'text');
        $sanitized['ratio1200'] = $this->sanitize($data['ratio1200'], 'text');
        $sanitized['ratio900'] = $this->sanitize($data['ratio900'], 'text');
        $sanitized['ratio600'] = $this->sanitize($data['ratio600'], 'text');
        $sanitized['width'] = $this->sanitize($data['ratio600'], 'text');
        $sanitized['height'] = $this->sanitize($data['height'], 'text');
        $sanitized['slides'] = $this->sanitize($data['slides'], 'slides');
        $sanitized['height600'] = $this->sanitize($data['height600'], 'text');
        $sanitized['height900'] = $this->sanitize($data['height900'], 'text');
        $sanitized['height1800'] = $this->sanitize($data['height1800'], 'text');
        $sanitized['height1200'] = $this->sanitize($data['height1200'], 'text');
        $sanitized['autoplay']['enable'] = $this->sanitize($data['autoplay']['enable'], 'text');
        $sanitized['autoplay']['disableOnInteraction'] = $this->sanitize($data['autoplay']['disableOnInteraction'], 'text');
        $sanitized['autoplay']['reverseDirection'] = $this->sanitize($data['autoplay']['reverseDirection'], 'text');
        $sanitized['autoplay']['delay'] = $this->sanitize($data['autoplay']['delay'], 'text');
        $sanitized['navigation']['enable'] = $this->sanitize($data['navigation']['enable'], 'text');
        $sanitized['navigation']['style'] = $this->sanitize($data['navigation']['style'], 'text');
        $sanitized['keyboard']['enable'] = $this->sanitize($data['keyboard']['enable'], 'text');
        $sanitized['pagination']['enable'] = $this->sanitize($data['pagination']['enable'], 'text');
        $sanitized['pagination']['clickable'] = $this->sanitize($data['pagination']['clickable'], 'text');
        $sanitized['pagination']['dynamicBullets'] = $this->sanitize($data['pagination']['dynamicBullets'], 'text');
        $sanitized['pagination']['style'] = $this->sanitize($data['pagination']['style'], 'text');
        $sanitized['hashNavigation']['enable'] = $this->sanitize($data['hashNavigation']['enable'], 'text');
        $sanitized['buttons']['pauseVisible'] = $this->sanitize($data['buttons']['pauseVisible'], 'text');
        $sanitized['buttons']['muteVisible'] = $this->sanitize($data['buttons']['muteVisible'], 'text');
        $sanitized['loading']['fadeEffect'] = $this->sanitize($data['loading']['fadeEffect'], 'text');
        $sanitized['loading']['backgroundColor'] = $this->sanitize($data['loading']['backgroundColor'], 'text');
        $sanitized['status'] = $this->sanitize($data['status'], 'text');
        $sanitized['id'] = $this->sanitize($data['id'], 'text');
        return $sanitized;
    }

    public function sanitize($data, $type = 'text')
    {
        switch ($type){
            case 'absint':
                return absint($data);
                break;
            case 'text':
                return sanitize_text_field($data);
                break;
            case 'email':
                return sanitize_email($data);
                break;
            case 'html':
                return wp_kses_post($data);
                break;
            case 'title':
                return sanitize_title($data);
                break;
            default:
                return $data;
                break;
        }
    }

    public static function activate()
    {
        update_option('nextcodeslider_valid', nextcodeslider()->LICENSE === 2 ? 'true' : 'false');
    }

    public function is_valid()
    {
        return get_option('nextcodeslider_valid', 'false') === 'true';
    }
}

if (!function_exists("trace_stx")) {

    function trace_stx($var)
    {
        echo("<pre style='z-index:999999;background:#fcc;color:#000;font-size:12px;'>");
        print_r($var);
        echo("</pre>");
    }

}
