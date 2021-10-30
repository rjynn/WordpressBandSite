<?php

$current_action = $current_id = '';

if (isset($_GET['action']) ) {
    $current_action = sanitize_text_field($_GET['action']);
}

if (isset($_GET['id']) ) {
    $current_id = absint($_GET['id']);
}

$slider_ids = get_option('nextcodeslider_ids');

if(!$slider_ids){
    $slider_ids = array();
}
$sliders = array();

foreach ($slider_ids as $id) {
    $slider = get_option('nextcodeslider_'.$id);
    if($slider){
        $sliders[$id] = $slider;
    }else{
        //remove id from array
        $slider_ids = array_diff($slider_ids, array($id));
    }
}
update_option('nextcodeslider_ids', $slider_ids);

if(!nextcodeslider()->is_valid()) {
    ?>
    <div class="nextcodeslider-update-notice-wrap" style="margin-left: 0;" id="message">
        <!--<a href="javascript:void(0);" style="float: right;" id="nextcodeslider-dismiss-notice">×</a>-->
        Get Access to PRO features of Slider Plugin <a href="https://pluginjungle.com/downloads/image-slider/" target="_blank">here</a>
        <p class="nextcodeslider-update-notice-footer">
            <a href="https://pluginjungle.com/contact/" target="_blank">Contact Us</a>
            <a href="https://wordpress.org/support/plugin/baslider" target="_blank">Support Forum</a>
        </p>
    </div>
<?php
}

switch( $current_action ) {

    case 'edit':

        include("edit-slider.php");

        break;

    case "save_settings":
        if(!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'saving-nextcodeslider')) {
            include("edit-slider.php");
            break;
        }
        //now saving with ajax - posting to main.php, function save_options()

        if(count($_POST) == 0){
            include("edit-slider.php");
            break;
        }
        //clear slides array if delete all slides
        if (!isset($_POST['slides']) ) {
            $_POST['slides'] = array();
        }
        if($sliders && $current_id != ''){
            $slider = $sliders[$current_id];
            if($slider){
                $slides = $slider["slides"];
            }else{
                $slider = array();
            }
        }


        $new = array_merge($slider, nextcodeslider()->sanitizeSliderData($_POST));
        $sliders[$current_id] = $new;
        //reset indexes because of sortable slides can be rearranged
        $oldSlides = $sliders[$current_id]["slides"];
        $newSlides = array();
        $index = 0;
        foreach($oldSlides as $p){
            $newSlides[$index] = $p;
            $index++;
        }
        $sliders[$current_id]["slides"] = $newSlides;

        update_option('nextcodeslider_'.$current_id, $sliders[$current_id]);

        include("edit-slider.php");

        break;
    case "add_new":

        //generate ID
        $new_id = 0;
        $highest_id = 0;

        foreach ($slider_ids as $id) {
            if((int)$id > $highest_id) {
                $highest_id = (int)$id;
            }
        }

        $current_id = $highest_id + 1;
        //create new slider
        $slider = array("id" => $current_id,
            "name" => "slider " . $current_id,
            "instanceName" => "slider " . $current_id,
            "date" => current_time( 'mysql' ),
            "status" => "draft"
        );
        //save new slider to database
        /*delete_option('nextcodeslider_'.(string)$current_id);

        add_option('nextcodeslider_'.(string)$current_id,$slider);
        */
        //add new slider to sliders
        $sliders[$current_id] = $slider;

        //save new id to array of id-s
        /*array_push($slider_ids,$current_id);
        update_option('nextcodeslider_ids',$slider_ids);
        */
        include("edit-slider.php");

        break;

    case 'duplicate':

        $new_id = 0;
        $highest_id = 0;

        foreach ($slider_ids as $id) {
            if((int)$id > $highest_id) {
                $highest_id = (int)$id;
            }
        }
        $new_id = $highest_id + 1;

        $sliders[$new_id] = $sliders[$current_id];
        $sliders[$new_id]["id"] = $new_id;
        $sliders[$new_id]["name"] = $sliders[$current_id]["name"]." (copy)";
        $sliders[$new_id]["instanceName"] = $sliders[$current_id]["instanceName"]." (copy)";

        $sliders[$new_id]["date"] = current_time( 'mysql' );

        delete_option('nextcodeslider_'.(string)$new_id);
        add_option('nextcodeslider_'.(string)$new_id,$sliders[$new_id]);

        array_push($slider_ids,$new_id);

        delete_option('nextcodeslider_ids');
        add_option('nextcodeslider_ids',$slider_ids);

        include("sliders.php");

        break;

    case 'delete':
        delete_option('nextcodeslider_ids_back');
        add_option('nextcodeslider_ids_back',$slider_ids);
        foreach ($slider_ids as $id) {
            update_option("nextcodeslider_ids",array());
        }

        $ids = explode(',', $current_id);

        foreach ($ids as $id) {
            unset($sliders[$id]);
        }
        $slider_ids = array_diff($slider_ids, $ids);
        update_option('nextcodeslider_ids', $slider_ids);

        include("sliders.php");

        break;

    case "delete_all":

        delete_option('nextcodeslider_ids_back');
        add_option('nextcodeslider_ids_back',$slider_ids);
        foreach ($slider_ids as $id) {
            delete_option('nextcodeslider_'.(string)$id);
        }
        delete_option('nextcodeslider_ids');
        $sliders = array();
        include("sliders.php");

        break;

    case 'import_from_json_confirm':
        $json = nextcodeslider()->sanitizeImportData($_POST['sliders']);

        $newSliders = slider_objectToArray(json_decode($json));
        if((string)$json != "" && is_array($newSliders)){
            $slider_ids = array();
            foreach ($newSliders as $b) {
                $id = $b['id'];
                add_option('nextcodeslider_'.(string)$id, $b);
                array_push($slider_ids,(string)$id);
            }
            update_option('nextcodeslider_ids', $slider_ids);
            $sliders = $newSliders;
        }

        include("sliders.php");
        break;

    default:

        include("sliders.php");

        break;

}

function slider_objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}


