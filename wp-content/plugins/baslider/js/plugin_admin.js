"use strict";

const nextcodeSliderIsLodash = () => {
    let nextcodeSliderIsLodash = false;

    // If _ is defined and the function _.forEach exists then we know underscore OR lodash are in place
    if ( 'undefined' != typeof( _ ) && 'function' == typeof( _.forEach ) ) {

        // A small sample of some of the functions that exist in lodash but not underscore
        const funcs = [ 'get', 'set', 'at', 'cloneDeep' ];

        // Simplest if assume exists to start
        nextcodeSliderIsLodash  = true;

        funcs.forEach( function ( func ) {
            // If just one of the functions do not exist, then not lodash
            nextcodeSliderIsLodash = ( 'function' != typeof( _[ func ] ) ) ? false : nextcodeSliderIsLodash;
        } );
    }

    if ( nextcodeSliderIsLodash ) {
        // We know that lodash is loaded in the _ variable
        return true;
    } else {
        // We know that lodash is NOT loaded
        return false;
    }
};

(function ($) {

$(document).ready(function () {

    var nextcodeSliderLodashCounter = 0
    var nextcodeSliderLodashInterval = setInterval(function(){
        if ( nextcodeSliderIsLodash() ) {
            _.noConflict();
            clearInterval(nextcodeSliderLodashInterval);
        } else if(nextcodeSliderLodashCounter > 20) {
            clearInterval(nextcodeSliderLodashInterval);
        }
        nextcodeSliderLodashCounter++;
    }, 1000);

    //$(".STX-main-table-wrapp").hide();
	//$(".STX-admin-content").fadeIn( "fast", function() { });

	var json_str = options.replace(/&quot;/g, '"');

    var slide;
	var slideItem;
    var slidesWrapper;
    var url;
    var file;
    var title;
    var btns_disabled;
    var $form, o;
    var slider;
    var responseSuccess = false;
    var modal = $('.STX-modal-window')
    var modalTitle = $('.STX-modal-window-title');
    var content = $('.STX-saved-notification-content')
    var btnDeleteAll = $('.STX-slider-trash-btn-large')
    var preloader = $('.STX-preview-preloader');
    var msgSuccess = "Slider saved.";
    var msgNoSlides = "Slider has no slides!";
    var msgError = "Error saving slider. Please refresh the page!";
    var msgDeletedSlides = "All slides deleted.";
    var counterForSlides = 0;
	var currentSlideBaseName;
    var base;
    var modalContent = $('.STX-modal-window-content');
    var currentSlide = 0, currentElement = 0, currentSlideType

	options = jQuery.parseJSON(json_str);

    checkForSlidesOnInit();

    $(window).resize(function() {
        positionModal();
    });

    function convertStrings(obj) {

        $.each(obj, function(key, value) {
            if (typeof(value) == 'object' || typeof(value) == 'array') {
                convertStrings(value)
            } else if (!isNaN(value)) {
                if (obj[key] == "")
                    delete obj[key]
                else
                    obj[key] = Number(value)
            } else if (value == "true") {
                obj[key] = true
            } else if (value == "false") {
                obj[key] = false
            }
        });

    }

    convertStrings(options)

    $form = $("#slider-options-form")

    $form.submit(function(e) {

        e.preventDefault();

        if(btns_disabled) return;
        enableButtons();

        $form.find('.spinner').css('visibility', 'visible')

        $form.find('.save-button').prop('disabled', 'disabled').css('pointer-events', 'none')

        var $slideBoxes = $(".STX-edit-slider-box")

        function handleObject(obj,name){
            for(var key in obj){
                var val = obj[key]
                if(typeof val == "string" || typeof val == "number"){
                    return {name:name+'['+key+']', val:val}
                }else if(typeof val == "object"){
                    handleObject(val, '['+key+']')
                }
            }
        }

        // add slide options to form
        for(var i=0;i < $slideBoxes.length; i++){
            var id = parseInt($slideBoxes[i].id)
        	var slide = options.slides[id]

            var s = handleObject(slide, 'slides['+i+']')

        	for(var key in slide){
        		var val = slide[key]
        		if(typeof val == "string" || typeof val == "number"){
        			$form.append($('<input type="hidden" class="slide-option" name="slides['+i+']['+key+']" value="'+val+'">'))
                }else if(typeof val == "object"){

                    for(var key2 in val){
                        var val2 = val[key2]
                        if(typeof val2 == "string" || typeof val2 == "number"){
                            $form.append($('<input type="hidden" class="slide-option" name="slides['+i+']['+key+']['+key2+']" value="'+val2+'">'))
                        }else if(typeof val2 == "object"){
                            for(var key3 in val2){
                                var val3 = val2[key3]
                                if(typeof val3 == "string" || typeof val3 == "number"){
                                    $form.append($('<input type="hidden" class="slide-option" name="slides['+i+']['+key+']['+key2+']['+key3+']" value="'+val3+'">'))
                                }else if(typeof val3 == "object"){
                                    for(var key4 in val3){
                                        var val4 = val3[key4]
                                        if(typeof val4 == "string" || typeof val4 == "number")
                                            $form.append($('<input type="hidden" class="slide-option" name="slides['+i+']['+key+']['+key2+']['+key3+']['+key4+']" value="'+val4+'">'))

                                    }
                               }
                            }
                       }
                    }
               }

            }

        }



        var data = $form.serialize() + '&action=nextcodeslider_save&id=' + options.id + '&security=' + options.security + '&status=' + options.status

        //remove slide options from form
        $(".slide-option").remove()

        $.ajax({

            type: "POST",

            url: $form.attr('action'),

            data: data,

            success: function(data, textStatus, jqXHR) {
                $form.find('.spinner').css('visibility', 'hidden')
                $form.find('.save-button').prop('disabled', '').css('pointer-events', 'auto')

                o = $.parseJSON(data)
                convertStrings(o)

                // console.log(o)

                if (!checkResponseForSlides(o)) {
                    showNotification("warning",msgNoSlides);
                    e.preventDefault()
                    return false
                }

                showNotification("success",msgSuccess);
                responseSuccess = true
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

                $form.find('.spinner').css('visibility', 'hidden')
                $form.find('.save-button').prop('disabled', '').css('pointer-events', 'auto')

                showNotification("error",msgError);
            }
        })

    })

    $('.slider-preview').click(function(e) {

        if(btns_disabled) return;
        enableButtons();

        $form.find('.spinner').css('visibility', 'visible')

        $form.find('.save-button').prop('disabled', 'disabled').css('pointer-events', 'none')

        openModal('preview', 'Slider preview')



        options.slides[0].layerWidth = options.slides[0].layerWidth || 1920
        options.slides[0].layerHeight = options.slides[0].layerHeight || 950
        // options.slides[0].elements =
        // [
        //                 {
        //                     type: "text",
        //                     content: "The best pizza in town!",
        //                     textColor: "#ffffff",
        //                     fontSize: "70px",
        //                     fontFamily: "Pacifico",
        //                     padding: "10px 100px 10px 100px",
        //                     backgroundColor: "",
        //                     position: {
        //                         x: "center",
        //                         y: "center",
        //                         offsetX: 0,
        //                         offsetY: 30
        //                     },
        //                     startAnimation: {
        //                         animation: "fadeInDown",
        //                         speed: 1000
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutUp",
        //                         speed: 500,
        //                         delay: 500
        //                     }
        //                 },
        //                 {
        //                     type: "text",
        //                     content: "FREE DELIVERY!",
        //                     textColor: "#ffffff",
        //                     fontSize: "30px",
        //                     fontFamily: "Courgette",
        //                     padding: "10px 100px 10px 100px",
        //                     backgroundColor: "rgba(0,0,0,0)",
        //                     position: {
        //                         x: "center",
        //                         y: "center",
        //                         offsetX: 0,
        //                         offsetY: -60
        //                     },
        //                     startAnimation: {
        //                         animation: "fadeInUp",
        //                         speed: 1000,
        //                         delay: 1000
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutDown",
        //                         speed: 500
        //                     }
        //                 },
        //                 {
        //                     type: "image",
        //                     src: "http://localhost/wordpress/wp-content/uploads/2019/04/beer.png",
        //                     position: {
        //                         x: "left",
        //                         y: "top",
        //                         offsetX: 80,
        //                         offsetY: 50
        //                     },
        //                     startAnimation: {
        //                         animation: "rotateInDownLeft",
        //                         speed: 2000,
        //                         delay: 1500
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutUp",
        //                         speed: 500
        //                     }
        //                 },
        //                 {
        //                     type: "image",
        //                     src: "http://localhost/wordpress/wp-content/uploads/2019/04/fork.png",
        //                     position: {
        //                         x: "center",
        //                         y: "bottom",
        //                         offsetX: -510,
        //                         offsetY: -390
        //                     },
        //                     startAnimation: {
        //                         animation: "bounceInUp",
        //                         speed: 1000,
        //                         delay: 2000
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutDown",
        //                         speed: 500
        //                     }
        //                 },
        //                 {
        //                     type: "image",
        //                     src: "http://localhost/wordpress/wp-content/uploads/2019/04/knife.png",
        //                         position: {
        //                         x: "center",
        //                         y: "bottom",
        //                         offsetX: 470,
        //                         offsetY: -260
        //                     },
        //                     startAnimation: {
        //                         animation: "bounceInUp",
        //                         speed: 1000,
        //                         delay: 2000
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutDown",
        //                         speed: 500
        //                     }
        //                 },
        //                 {
        //                     type: "image",
        //                     src: "http://localhost/wordpress/wp-content/uploads/2019/04/plate.png",
        //                     position: {
        //                         x: "center",
        //                         y: "bottom",
        //                         offsetX: -6,
        //                         offsetY: -400
        //                     },
        //                     startAnimation: {
        //                         animation: "bounceInUp",
        //                         speed: 1000,
        //                         delay: 3000
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutDown",
        //                         speed: 500
        //                     }
        //                 },
        //                 {
        //                     type: "image",
        //                     src: "http://localhost/wordpress/wp-content/uploads/2019/04/pizza.png",
        //                     size: 710,
        //                     position: {
        //                         x: "center",
        //                         y: "bottom",
        //                         offsetX: -10,
        //                         offsetY: -470
        //                     },
        //                     startAnimation: {
        //                         animation: "zoomIn",
        //                         speed: 2000,
        //                         delay: 3800
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutDown",
        //                         speed: 500
        //                     }
        //                 },
        //                 {
        //                     type: "button",
        //                     content: "ORDER NOW!",
        //                     url: "https://fianona.hr/hr/naslovna/",
        //                     textColor: "#ffffff",
        //                     fontSize: "30px",
        //                     fontFamily: "Baloo Chettan",
        //                     padding: "10px 30px",
        //                     borderRadius: 30,
        //                     backgroundColor: "rgb(210,75,13)",
        //                     position: {
        //                         x: "center",
        //                         y: "center",
        //                         offsetX: 0,
        //                         offsetY: -140
        //                     },
        //                     startAnimation: {
        //                         animation: "zoomIn",
        //                         speed: 800,
        //                         delay: 5000
        //                     },
        //                     endAnimation: {
        //                         animation: "fadeOutDown",
        //                         speed: 500
        //                     }
        //                 }
        //             ]



        var o = options || {}
        if(o.navigation && !o.navigation.enable)   o.navigation = false;
        if(o.pagination && !o.pagination.enable)   o.pagination = false;
        if(o.keyboard && !o.keyboard.enable)  o.keyboard = false;
        if(o.autoplay && !o.autoplay.enable) o.autoplay = false;
        if(o.shadow && o.shadow == "off") o.shadow = null;
        o.initialSlide = 0
        o.hashNavigation = false
        o.width = 688;
        o.height = 378;
        o.fullscreen = false;

        for(var key in o.slides){
        	var slide = o.slides[key]
        	if(slide.elements){
        		for (var key2 in slide.elements){
        			delete slide.elements[key2].node
        		}
        	}
        }
        
         $(".slider_preview").empty().append('<div class="sp">')
         $(".sp").nextcodeSlider(o);

        // if($.isEmptyObject($('.slider_preview').data()))
        //     $(".slider_preview").nextcodeSlider(o);
        // else{
        //     slider = $(".slider_preview").data('nextcodeSlider');
        //     slider.reloadSlider(o)
        // }
    });

    if(options)
        options.instanceName ? title = 'Edit "' + options.instanceName + '"' : title = 'Add New Slider'

    $(".edit-slider-text").text(title)
	$(".btn-slider-name").text(options.instanceName)

    addOption(false, "publish", "", "publishArea");

    addOption(false, "general-settings", "instanceName", "text", "Slider name", "", "");
    addOption(true, "general-settings", "initialSlide", "text", "Initial slide", "0", "");
    addOption(true, "general-settings", "shadow", "dropdown", "Slider shadow", "effect2", ["effect1", "effect2", "effect3", "effect4", "effect5", "effect6" , "off"], "");
    addOption(true, "general-settings", "grabCursor", "checkbox", "Grab cursor", true, "", "", "");
    addOption(true, "general-settings", "stopOnLastSlide", "checkbox", "Stop on last slide", false, "", "");

    addOption(true, "size", "responsive", "checkbox", "Responsive mode", true, "", "hasSubitem");
    addOption(true, "size", "ratio", "text", "Responsive ratio (width / height)", "", "", "isSubitem");
    addOption(true, "size", "ratio1800", "text", "Responsive ratio (for Slider width under 1800px)", "", "", "isSubitem");
    addOption(true, "size", "ratio1200", "text", "Responsive ratio (for Slider width under 1200px)", "", "", "isSubitem");
    addOption(true, "size", "ratio900", "text", "Responsive ratio (for Slider width under 900px)", "", "", "isSubitem");
    addOption(true, "size", "ratio600", "text", "Responsive ratio (for Slider width under 600px)", "", "", "isSubitem");
    addOption(true, "size", "fullscreen", "checkbox", "Fullscreen mode", false, "", "hasSubitem");
    addOption(true, "size", "sliderSize", "textOnly", "Fixed mode", "", "", "hasSubitem", "");
    addOption(true, "size", "width", "textWithUnit", "Width", "1000", "px", "isSubitem", "");
    addOption(true, "size", "height", "textWithUnit", "Height", "550", "px", "isSubitem", "");
    addOption(true, "size", "height1800", "textWithUnit", "Height (for Slider width under 1800px)", "", "px", "isSubitem", "");
    addOption(true, "size", "height1200", "textWithUnit", "Height (for Slider width under 1200px)", "", "px", "isSubitem", "");
    addOption(true, "size", "height900", "textWithUnit", "Height (for Slider width under 900px)", "", "px", "isSubitem", "");
    addOption(true, "size", "height600", "textWithUnit", "Height (for Slider width under 600px)", "", "px", "isSubitem", "");

    addOption(true, "autoplay", "autoplay[enable]", "checkbox", "Enable", false, "", "");
    addOption(true, "autoplay", "autoplay[delay]", "textWithUnit", "Delay between transitions", 3000, "ms", "");
    addOption(true, "autoplay", "autoplay[disableOnInteraction]", "checkbox", "Disable on user interaction", true, "", "");
    addOption(true, "autoplay", "autoplay[reverseDirection]", "checkbox", "Reverse direction", false, "");

    addOption(true, "buttons", "buttons[pauseVisible]", "checkbox", "Pause button", true, "", "", "");
    addOption(true, "buttons", "buttons[muteVisible]", "checkbox", "Mute button", true, "", "", "");

    addOption(true, "arrows", "navigation", "textOnly", "Arrows", "", "", "hasSubitem", "");
    addOption(true, "arrows", "navigation[enable]", "checkbox", "Enable", true, "", "isSubitem", "");
    addOption(true, "arrows", "navigation[style]", "dropdown", "Style", "effect4", ["effect1","effect2","effect3","effect4","effect5","effect6","effect7","effect8","effect9","effect10"], "isSubitem", "hasPreview");
    addOption(true, "arrows", "keyboard", "textOnly", "Keyboard", "", "", "hasSubitem", "");
    addOption(true, "arrows", "keyboard[enable]", "checkbox", "Enable", true, "", "isSubitem", "");

    addOption(true, "pagination", "pagination[enable]", "checkbox", "Pagination", true, "", "hasSubitem", "");
    addOption(true, "pagination", "pagination[style]", "dropdown", "Style", "effect2", ["effect1", "effect2", "effect3", "effect4", "effect5" , "effect6"], "isSubitem", "");
    addOption(true, "pagination", "pagination[clickable]", "checkbox", "Clickable", true, "", "isSubitem", "");
    addOption(true, "pagination", "pagination[dynamicBullets]", "checkbox", "Dynamic", false, "", "isSubitem", "");

    addOption(true, "hash-navigation", "hashNavigation[enable]", "checkbox", "Enable", false, "", "", "");

    addOption(true, "loading", "loading[fadeEffect]", "checkbox", "Fade in/out effect", true, "", "", "");
    addOption(true, "loading", "loading[backgroundColor]", "color", "Background color", "#000", "", "");

	function addOption(requiresPro, section,name,type,desc,defaultValue,values,subItemType,hasPreview){

	    var proActive = nextcodesliderL10n.is_valid;

		var table = $("#slider-options-"+section+"");
		var tableBody = table.find('tbody');
		var row = $('<tr valign="top"  class="field-row"></tr>').appendTo(tableBody);
		var th = $('<th scope="row" class="STX-th-label">'+desc+'</th>').appendTo(row);

        if(subItemType)
            $(th).addClass(subItemType)

		switch(type){

            case "text":
                var td = $('<td class="STX-element"><div class="STX-form-element-text STX-element-num  STX-text-has-unit  STX-input-border-radius"></div></td>').appendTo(row);
                var input = $('<input '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' class="inputField" type="text" name="'+((!requiresPro || proActive) ? name : '')+'"/>').appendTo(td.children());
				if(typeof(options[name]) != 'undefined'){
					input.attr("value",options[name]);
				}else if (options[name.split("[")[0]] && name.indexOf("[") != -1 && typeof(options[name.split("[")[0]]) != 'undefined') {
                        input.attr("value", options[name.split("[")[0]][name.split("[")[1].split("]")[0]]);
				}else {
					input.attr('value',defaultValue);
				}
                break;

			case "textWithUnit":
                var td = $('<td class="STX-element"><div class="STX-form-element-text STX-element-num  STX-text-has-unit  STX-input-border-radius"></div></td>').appendTo(row);
                var input = $('<input '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' class="inputField" type="text" name="'+((!requiresPro || proActive) ? name : '')+'"/><div class="STX-text-unit STX-unit-font">'+values+'</div>').appendTo(td.children());
				if(typeof(options[name]) != 'undefined'){
					input.attr("value",options[name]);
				}else if (options[name.split("[")[0]] && name.indexOf("[") != -1 && typeof(options[name.split("[")[0]]) != 'undefined') {
                        input.attr("value", options[name.split("[")[0]][name.split("[")[1].split("]")[0]]);
				}else {
					input.attr('value',defaultValue);
				}
				break;

            case "textOnly":
                var td = $('<td class="STX-element"></div></td>').appendTo(row);
                break;

			case "color":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);
				var input = $('<input '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' class="STX-input" type="text" name="' + ((!requiresPro || proActive) ? name : '') + '"/>').appendTo(td);
				if (options[name] && typeof(options[name]) != 'undefined') {
					input.attr("value", options[name]);
				} else if (options[name.split("[")[0]] && name.indexOf("[") != -1 && typeof(options[name.split("[")[0]]) != 'undefined') {
					input.attr("value", options[name.split("[")[0]][name.split("[")[1].split("]")[0]]);
				} else {
					input.attr('value', defaultValue);
				}
				input.wpColorPicker();
				break;

			case "textarea":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);
			    var textarea = $('<textarea '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' class="STX-input" type="text" name="'+((!requiresPro || proActive) ? name : '')+'" cols=45" rows="1"></textarea>').appendTo(td);
				if(typeof(options[name]) != 'undefined'){
					textarea.attr("value",options[name]);
				}else {
					textarea.attr('value',defaultValue);
				}
				break;

			case "checkbox":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);
                var inputHidden = $('<input class="STX-input" type="hidden" name="'+name+'" value="false"/>').appendTo(td);
                var input = $('<div class="STX-onoffswitch"><input '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' type="checkbox" name="'+name+'" value="true" class="STX-onoffswitch-checkbox" id="'+name+'"><label class="STX-onoffswitch-label" for="'+name+'"><span class="STX-onoffswitch-inner"></span><span class="STX-onoffswitch-switch"></span></label></div>').appendTo(td);

                if (typeof(options[name]) != 'undefined') {
                    input.find('input').attr("checked", options[name]);
                } else if (options[name.split("[")[0]] && name.indexOf("[") != -1 && typeof(options[name.split("[")[0]]) != 'undefined') {
                    var val = options[name.split("[")[0]][name.split("[")[1].split("]")[0]]
                    input.find('input').attr("checked", val && val != 'false');

                } else {
                    input.find('input').attr('checked', defaultValue);
                }
				break;

			case "selectImage":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);
				var input = $('<input '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' class="STX-input" type="text" name="'+((!requiresPro || proActive) ? name : '')+'"/><a '+ ((requiresPro && !proActive) ? 'disabled="disabled"' : '') +' class="select-image-button button-secondary button80" href="#">Select image</a>').appendTo(td);
				if(typeof(options[name]) != 'undefined'){
					input.attr("value",options[name]);
				}else {
					input.attr('value',defaultValue);
				}
				break;

			case "dropdown":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);

                var dropdown = $('<div class="dropdown STX-edit-dropdown btns-dashboard-nav"><div class="select"><span></span><i aria-hidden="true" class="fa fa-chevron-down"></i><input type="hidden" name="'+name+'"></div></div>').appendTo(td);
                var ul = $('<ul class="dropdown-menu STX-edit-dropdown-menu"></ul>').appendTo(dropdown)

                for ( var i = 0; i < values.length; i++ )
				{
                    var li = $('<li>'+values[i]+'</li>').appendTo(ul)

                    if(typeof(options[name]) != 'undefined')
					{
						if(options[name] == values[i])
						{
                            $(li).parents('.dropdown').find('span').text(values[i]);
                            //set hidden inputs value for dropdowns
                            $(li).parents('.dropdown').find('input').attr('value', values[i]);
						}
					}
                    else if (options[name.split("[")[0]] && name.indexOf("[") != -1 && typeof(options[name.split("[")[0]]) != 'undefined') {
                        var val = options[name.split("[")[0]][name.split("[")[1].split("]")[0]]
                        $(li).parents('.dropdown').find('span').text(val);
                        //set hidden inputs value for dropdowns
                        $(li).parents('.dropdown').find('input').attr('value', val);
                    }
					else
					{
                        $(li).parents('.dropdown').find('span').text(defaultValue);
                        //set hidden inputs value for dropdowns
                        $(li).parents('.dropdown').find('input').attr('value', defaultValue);
					}

					if(!requiresPro || proActive) {
                        $(li).click(function () {
                            $(this).parents('.dropdown').find('span').text($(this).text());
                            $(this).parents('.dropdown').find('input').attr('value', $(this).text());
                            $(this).parents('.dropdown').find('input').attr('selected','true');
                        });
                    }

                }
				break;
            case "publishArea":
                var publish = $(".STX-publish-table-wrapp")
                tableBody.empty();
                $('<div class="STX-publish-content">'
                    +'<div class="STX-publish-title STX-admin">Shortcode</div>'
                    +'<div class="STX-publish-text STX-admin">Copy and paste this shortcode into your posts or pages:</div>'
                    +'<div class="STX-STX-publish-shortcode">'
                        +'<div class="STX-publish-table">'
                            +'<p class="STX-shortcode-left">[nextcodeslider id="'+options.id+'"]</p>'
                            +'<div id="'+options.id+'" title="Copy shortcode" id="1" class="STX-shortcode-right STX-btn-copy-shortcode">COPY</div>'
                        +'</div>'
                    +'</div>'
                +'</div>').appendTo(tableBody)
            break;
		}
	}

    $('.STX-edit-dropdown').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.STX-edit-dropdown-menu').slideToggle(300);
    });
    $('.STX-edit-dropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.STX-edit-dropdown-menu').slideUp(300);
    });
    $('.STX-edit-dropdown .STX-edit-dropdown-menu li').click(function () {
        $(this).parents('.dropdown').find('span').text($(this).text());
        $(this).parents('.dropdown').find('input').attr('value', $(this).text());
        $(this).parents('.dropdown').find('input').attr('selected','true');
    });
    $('.STX-edit-dropdown-menu li').click(function () {
        var getVal = $(this).parents('.STX-edit-dropdown').find('input').val();
    });

	function setColorOptionValue(optionName, value) {
        var $elem = $("input[name='" + optionName + "']").attr('value', value);
        $elem.wpColorPicker()
        return $elem
    }

    $('body').click(function(e) {
        var target = $(e.target);
        var formElementText = $(".STX-form-element-text")

        if(target.hasClass("inputField")){
            if(formElementText.hasClass("focus"))
                formElementText.removeClass("focus")

            target.parent().addClass("focus")
            $(".STX-text-has-unit").find("STX-text-unit").addClass("focus")
            target.addClass("focus")
        }else{
            if(formElementText.hasClass("focus"))
                formElementText.removeClass("focus")
        }
    });

    if(options.slides){

        enableButtons();

        for(var i= 0; i < options.slides.length; i++){

            slide = options.slides[i];
            slidesWrapper = $("#STX-images-wrapper");

            var slideItem = createSlidesHtml(i, slide.src);
        }
        counterForSlides = $('.slide-item').length;
    }

    function makeSortable() {

        $(".tabs").tabs();
        $(".ui-sortable").sortable();
        $('#STX-images-wrapper').sortable({
            opacity: 0.6,
            stop: function() {}
        });

    }



    /* --------------------
           SLIDE MODAL
     -------------------- */

    var $editSlideModal = $(

       '<div tabindex="0" class="media-modal wp-core-ui">'+
            '<button type="button" class="media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text">Close media panel</span></span></button>'+
            '<div class="media-modal-content">'+
                '<div class="edit-attachment-frame mode-select hide-menu hide-router">'+
                    '<div class="edit-media-header">'+
                        '<button class="left dashicons"><span class="screen-reader-text">Edit previous media item</span></button>'+
                        '<button class="right dashicons"><span class="screen-reader-text">Edit next media item</span></button>'+
                    '</div>'+
                    '<div class="media-frame-title"><h1>Edit slide 1</h1></div>'+

                    '<div class="media-frame-content">'+

                        '<div tabindex="0" data-id="185" class="attachment-details save-ready">'+
                            '<div class="attachment-media-view landscape">'+
                                '<div class="thumbnail thumbnail-image">'+
                                    '<img class="details-image" src="" draggable="false" alt="">'+
                                    '<div class="video-container"></div>'+
                                    '<div class="layer-container"></div>'+
                                    '<div class="attachment-actions">'+
                                        '<button type="button" class="button edit-attachment">Edit</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="attachment-info">'+
                                '<span class="settings-save-status">'+
                                    '<span class="spinner"></span>'+
                                    '<span class="saved">Saved.</span>'+
                                '</span>'+

                                 '<h2 id="stx-tabs" class="nav-tab-wrapper wp-clearfix">'+
                                   '<a href="#" class="nav-tab" data-tab="tab-general">General</a>'+
                                   '<a href="#" class="nav-tab" data-tab="tab-elements">Layers'+(!nextcodesliderL10n.is_valid ? '<span class="nextcodeslider-pro-text"> (PRO)</span>' : '')+'</a>'+
                                '</h2>'+

                                '<div id="tab-general" class="tab">'+

                                    '<div class="settings">'+
                                        //  '<label class="element-setting" data-setting="">'+
                                        //     '<span class="name">Name</span>'+
                                        //     '<input type="text" >'+
                                        // '</label>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">URL</label>'+
                                            '<input type="text" id="src" name="src">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Transition duration</label>'+
                                            '<input type="number" id="transitionDuration" name="transitionDuration">'+
                                            '<span> ms</span>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Transition effect</label>'+
                                            '<select name="transitionEffect" id="transitionEffect">'+
                                                '<option value="">Default</option>'+
                                                '<option value="roll">Roll</option>'+
                                                '<option value="stretch">Stretch</option>'+
                                                '<option value="warp">Warp</option>'+
                                                '<option value="zoom">Zoom</option>'+
                                                '<option value="powerzoom">Power zoom</option>'+
                                                '<option value="flash">Flash</option>'+
                                                '<option value="fade">Fade</option>'+
                                                '<option value="twirl">Twirl</option>'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="element-setting" id="setting-direction">'+
                                            '<label class="name">Transition direction</label>'+
                                            '<select name="direction" id="direction">'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="element-setting" id="setting-brightness">'+
                                            '<label class="name">Transition brightnesss</label>'+
                                            '<select name="brightness" id="brightness">'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="element-setting" id="setting-distance">'+
                                            '<label class="name">Transition distance</label>'+
                                            '<select name="distance" id="distance">'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="element-setting" id="setting-easing">'+
                                            '<label class="name">Transition easing</label>'+
                                            '<select name="easing" id="easing">'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+

                                '<div id="tab-elements" class="tab">'+
									'<div class="settings">'+
										'<div class="element-setting">'+
											'<label class="name">Layer width</label>'+
											'<input '+(!nextcodesliderL10n.is_valid ? 'disabled="disabled"' : '')+' type="number" id="layerWidth" name="'+(nextcodesliderL10n.is_valid ? 'layerWidth': '')+'">'+
                                            '<span> px</span>'+
										'</div>'+
									   '<div class="element-setting">'+
											'<label class="name">Layer height</label>'+
											'<input '+(!nextcodesliderL10n.is_valid ? 'disabled="disabled"' : '')+'      type="number" id="layerHeight" name="'+(nextcodesliderL10n.is_valid ? 'layerHeight': '')+'">'+
                                            '<span> px</span>'+
										'</div>'+
                                    '</div>'+

                                    '<button '+(!nextcodesliderL10n.is_valid ? 'disabled="disabled"' : '')+' type="button" class="button '+(nextcodesliderL10n.is_valid ? 'add-text': '')+'">Add Text</button>'+
                                    '<button '+(!nextcodesliderL10n.is_valid ? 'disabled="disabled"' : '')+' type="button" class="button '+(nextcodesliderL10n.is_valid ? 'add-button': '')+'">Add Button</button>'+
                                    '<button '+(!nextcodesliderL10n.is_valid ? 'disabled="disabled"' : '')+' type="button" class="button '+(nextcodesliderL10n.is_valid ? 'add-image': '')+'">Add Image</button>'+
                                    '<br/>'+
                                    '<br/>'+
                                    '<h3>Layers</h3>'+
                                    '<div class="elements ui-sortable">'+
                                    '</div>'+
                                    '<br/>'+

                                    '<div class="element-settings">'+
                                        '<h3 id="edit-element-title">Edit layer</h3>'+
                                        '<div><a href="#" class="delete-element">Delete element</a></div>'+
                                    '</div>'+

                                    '<div class="element-settings text-element-settings">'+
                                         '<div class="element-setting">'+
                                            '<label class="name">Content</label>'+
                                            '<input type="text" name="content">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Text Color</label>'+
                                            '<div><input type="text" class="cp" data-alpha="0" name="textColor"></div>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Font Size</label>'+
                                            '<input type="text" name="fontSize">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Font Family</label>'+
                                            '<input type="text" name="fontFamily">'+
                                        '</div>'+

                                        '<div class="element-setting">'+
                                            '<label class="name">Padding</label>'+
                                            '<input type="text" name="padding">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Background Color</label>'+
                                            '<input type="text" class="cp" data-alpha="0" name="backgroundColor">'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="element-settings button-element-settings">'+
                                        '<div class="element-setting">'+
                                            '<label class="name">URL</label>'+
                                            '<input type="text" name="url">'+
                                        '</div>'+
                                         '<div class="element-setting">'+
                                            '<label class="name">Content</label>'+
                                            '<input type="text" name="content">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Text Color</label>'+
                                            '<input type="text" class="cp" data-alpha="0" name="textColor">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Font Size</label>'+
                                            '<input type="text" name="fontSize">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Font Family</label>'+
                                            '<input type="text" name="fontFamily">'+
                                        '</div>'+

                                        '<div class="element-setting">'+
                                            '<label class="name">Padding</label>'+
                                            '<input type="text" name="padding">'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Background Color</label>'+
                                            '<input type="text" class="cp" data-alpha="0" name="backgroundColor">'+
                                        '</div>'+
                                    '</div>'+


                                    '<div class="element-settings image-element-settings">'+
                                         '<div class="element-setting">'+
                                            '<label class="name">URL</label>'+
                                            '<input type="text" name="src">'+
                                        '</div>'+
                                    '</div>'+

                                    '<div class="element-settings">'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Position X</label>'+
                                            '<select name="position.x">'+
                                                '<option value="left">Left</option>'+
                                                '<option value="center">Center</option>'+
                                                '<option value="right">Right</option>'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Position Y</label>'+
                                            '<select name="position.y">'+
                                                '<option value="top">Top</option>'+
                                                '<option value="center">Center</option>'+
                                                '<option value="bottom">Bottom</option>'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Offset X</label>'+
                                            '<input type="number" name="position.offsetX">'+
                                            '<span> px</span>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Offset Y</label>'+
                                            '<input type="number" name="position.offsetY">'+
                                            '<span> px</span>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Custom CSS</label>'+
                                            '<textarea id="customCSS"></textarea>'+
                                        '</div>'+
                                        '<h3>Start animation</h3>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Animation name</label>'+
                                            '<select name="startAnimation.animation"></select>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Speed</label>'+
                                            '<input type="number" name="startAnimation.speed">'+
                                            '<span> ms</span>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Delay</label>'+
                                            '<input type="number" name="startAnimation.delay">'+
                                            '<span> ms</span>'+
                                        '</div>'+
                                        '<h3>End animation</h3>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Animation name</label>'+
                                            '<select name="endAnimation.animation"></select>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Speed</label>'+
                                            '<input type="number" name="endAnimation.speed">'+
                                            '<span> ms</span>'+
                                        '</div>'+
                                        '<div class="element-setting">'+
                                            '<label class="name">Delay</label>'+
                                            '<input type="number" name="endAnimation.delay">'+
                                            '<span> ms</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>').hide()

    var $editSlideModalBackdrop = $("<div>").addClass("media-modal-backdrop").hide()

    $("body").append($editSlideModal)
    $("body").append($editSlideModalBackdrop)


    var animationNames = ['bounce','flash', 'pulse', 'rubberBand', 'shake', 'headShake', 'swing', 'tada',
    'wobble', 'jello', 'bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'bounceOut',
    'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig',
    'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeOut', 'fadeOutDown',
    'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig',
    'flipInX', 'flipInY', 'flipOutX', 'flipOutY', 'lightSpeedIn', 'lightSpeedOut', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft',
    'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'hinge', 'jackInTheBox', 'rollIn',
    'rollOut', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp',
    'slideInDown', 'slideInLeft', 'slideInRight', 'slideInUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'slideOutUp']

    var $startAnimationName = $("select[name='startAnimation.animation']")
    var $endAnimationName = $("select[name='endAnimation.animation']")

    for(var key in animationNames){
        $startAnimationName.append('<option value="'+animationNames[key]+'">'+animationNames[key]+'</option>')
        $endAnimationName.append('<option value="'+animationNames[key]+'">'+animationNames[key]+'</option>')
    }

    $(".cp").wpColorPicker();

    var $prev = $(".edit-media-header").find(".left")
    var $next = $(".edit-media-header").find(".right")

    $next.click(function(){

        currentSlide++;
        currentSlide = currentSlide % options.slides.length

        showSlide(currentSlide)

    })

    $prev.click(function(){

        currentSlide += (options.slides.length - 1);
        currentSlide = currentSlide % options.slides.length

        showSlide(currentSlide)
    })


    //tabs
    $editSlideModal.find('.nav-tab').click(function(e) {
            e.preventDefault()
            $('.tab').hide()
            $('.nav-tab-active').removeClass('nav-tab-active')
            var a = jQuery(this).addClass('nav-tab-active')
            var id = "#" + a.attr('data-tab')
            jQuery(id).show()
        }).focus(function(e) {
            this.blur()
        })

    /* --------------------
           ELEMENTS
     -------------------- */

    var $elementSettings = $editSlideModal.find(".element-settings").hide()

    var $textElementSettings = $editSlideModal.find(".text-element-settings")
    var $imageElementSettings = $editSlideModal.find(".image-element-settings")
    var $buttonElementSettings = $editSlideModal.find(".button-element-settings")

    var $addTextButton = $editSlideModal.find(".add-text")
    var $addImageButton = $editSlideModal.find(".add-image")
    var $addButtonButton = $editSlideModal.find(".add-button")
    var $deleteElement = $editSlideModal.find(".delete-element")

    $deleteElement.click(function(e){
        e.preventDefault()
        $('.slide-element').eq(currentElement).remove();
        $elementSettings.hide()
        options.slides[currentSlide].elements.splice(currentElement,1)
        renderLayers()
    })

    var renderLayersDisabled = false

    function renderLayers(){
        if(renderLayersDisabled)
            return
        var sw, sh, lw, lh
        if(currentSlideType == "img"){
            sw = $(".details-image").width()
            sh = $(".details-image").height()
        }else{
            sw = $(".video-container").width()
            sh = $(".video-container").height()
        }
        lw = options.slides[currentSlide].layerWidth || 1920,
        lh = options.slides[currentSlide].layerHeight || 950

        layerRenderer.render(options.slides[currentSlide].elements, sw, sh, lw, lh)
        $(".elements").sortable()

        // console.log("render layers!")
    }

    function focusLayer(index){
        layerRenderer.focusElement(index)
    }

    function clearLayers(){
        layerRenderer.render([])
    }

    $(window).resize(function(){
        renderLayers()
    })

    $elementSettings.find("input").change(function(){
        // console.log(this.name, this.value)
        if(this.name){
            var arr = this.name.split('.')
            if(arr.length == 2)
                options.slides[currentSlide].elements[currentElement][arr[0]][arr[1]] = this.value
            else
                options.slides[currentSlide].elements[currentElement][this.name] = this.value
        }
        renderLayers()
    })

    $elementSettings.find("select").change(function(){
        if(this.name){
            var arr = this.name.split('.')
            if(arr.length == 2)
                options.slides[currentSlide].elements[currentElement][arr[0]][arr[1]] = this.value
            else
                options.slides[currentSlide].elements[currentElement][this.name] = this.value
        }
        renderLayers()
    })

    $(".settings").find("input").change(function(){
        if(this.name){
            var arr = this.name.split('.')
            if(arr.length == 2)
                options.slides[currentSlide][arr[0]][arr[1]] = this.value
            else
                options.slides[currentSlide][this.name] = this.value
        }
    })

    $(".settings").find("select").change(function(){
        if(this.name){
            var arr = this.name.split('.')
            if(arr.length == 2)
                options.slides[currentSlide][arr[0]][arr[1]] = this.value
            else
                options.slides[currentSlide][this.name] = this.value
        }
    })

    $("#customCSS").bind('change paste', function() {

        options.slides[currentSlide].elements[currentElement]["customCSS"] = $(this).val()
        renderLayers()

    })

    $("#layerWidth").bind('change paste', function() {

        renderLayers()

    })

    $("#layerHeight").bind('change paste', function() {

        renderLayers()

    })

    function createTextElement(obj){
         var $elem = {
            type: "text",
            content:"Text",
            fontSize:"50px",
            fontFamily: "",
            textColor:"#FFF",
            backgroundColor:"",
            position: {
                x: "center",
                y: "center",
                offsetX: 0,
                offsetY: 0
            },
            startAnimation: {
                animation: "fadeInUp",
                speed: 500,
                delay: 0
            },
            endAnimation: {
                animation: "fadeOutUp",
                speed: 500,
                delay: 0
            }
        }

        options.slides[currentSlide].elements = options.slides[currentSlide].elements || []

        currentElement = options.slides[currentSlide].elements.length

        options.slides[currentSlide].elements.push($elem)

        addElement($elem)

        renderLayers()
    }

    function createImageElement(){

        var $elem = {
            type: "image",
            src:"",
            position: {
                x: "center",
                y: "center",
                offsetX: 0,
                offsetY: 0
            },
            startAnimation: {
                animation: "",
                speed: 0,
                delay: 0
            },
            endAnimation: {
                animation: "",
                speed: 500
            }
        }

        if (file) file.close();

        file = wp.media.frames.file = wp.media({
            title: 'Select image',
            button: {
                text: 'Select',
            },
            multiple: false
        });

        file.on( 'select', function() {

            var attachment = file.state().get('selection').first().toJSON();
            var attachmentUrl = attachment.url

            $elem.src = attachmentUrl

            options.slides[currentSlide].elements = options.slides[currentSlide].elements || []

            currentElement = options.slides[currentSlide].elements.length

            options.slides[currentSlide].elements.push($elem)

            addElement($elem)

            renderLayers()

        });

        file.open();

    }

    function createButtonElement(){

        var $elem = {
            type: "button",
            content:"Button",
            position: {
                x: "center",
                y: "center",
                offsetX: 0,
                offsetY: 0
            },
            startAnimation: {
                animation: "",
                speed: 0,
                delay: 0
            },
            endAnimation: {
                animation: "",
                speed: 500
            }
        }

        options.slides[currentSlide].elements = options.slides[currentSlide].elements || []

        currentElement = options.slides[currentSlide].elements.length

        options.slides[currentSlide].elements.push($elem)

        addElement($elem)

        renderLayers()

    }

    $addTextButton.click(createTextElement)
    $addImageButton.click(createImageElement)
    $addButtonButton.click(createButtonElement)

    function selectElement(){
        $('.slide-element').first().trigger('click')
    }

    function addElement(obj){

        var $el = $('<button type="button" class="button slide-element '+obj.type+'-element">'+obj.type.toUpperCase()+'</button>').click(function(){

            $(".slide-element").css("background", "#FFF")
            $(this).css("background", "#DDD")
            renderLayersDisabled = true
            currentElement = $(this).index()

            $("#edit-element-title").text("Edit layer " + String(currentElement+1))
            $elementSettings.find("input").val("")
            $elementSettings.find("select").val("")
            var obj = options.slides[currentSlide].elements[currentElement]
            updateVisibleElementSettings(obj.type)
            for(var key in obj){
				var val = obj[key]
				 if (typeof val == 'string' || typeof val == 'number') {
                    if($('input[name="'+key+'"]').hasClass("cp")){
                        $('input[name="'+key+'"]').wpColorPicker("color", val)
                    }else{
                        $('input[name="'+key+'"]').val(val)
                        $('select[name="'+key+'"]').val(val)
                    }
				} else {
					for(var key2 in val){
						var val2 = val[key2]
                        $('input[name="'+key+'.'+key2+'"]').val(val2)
						$('select[name="'+key+'.'+key2+'"]').val(val2)
					}
				}
			}

            $("#customCSS").val(obj.customCSS || "")

            renderLayersDisabled = false
            renderLayers()
            focusLayer(currentElement)
        })
        $editSlideModal.find(".elements").append($el)

        $(".slide-element").css("background", "#FFF")
        $el.css("background", "#DDD")

        updateVisibleElementSettings(obj.type)

		for(var key in obj){
			var val = obj[key]
			 if (typeof val == 'string' || typeof val == 'number') {
				$('input[name="'+key+'"]').val(val)
                $('select[name="'+key+'"]').val(val)
			} else {
				for(var key2 in val){
					var val2 = val[key2]
					$('input[name="'+key+'.'+key2+'"]').val(val2)
                    $('select[name="'+key+'.'+key2+'"]').val(val2)
				}
			}
		}

    }

    function updateVisibleElementSettings(type){
        $elementSettings.show()
        if(type != "text") $textElementSettings.hide()
        if(type != "button") $buttonElementSettings.hide()
        if(type != "image") $imageElementSettings.hide()
    }

    var transitionOptions = {

        "roll" : {
            'direction' : [
                { name:'Left', value:'left'},
                { name:'Right', value:'right'},
                { name:'Top', value:'top'},
                { name:'Bottom', value:'bottom'},
                { name:'Top left', value:'topleft'},
                { name:'Top right', value:'topRight'},
                { name:'Bottom left', value:'bottomlreft'},
                { name:'Bottom right', value:'bottomRight'},
                { name:'Random', value:''}
            ],
            'distance' : [
                { name:'Default', value:''},
                { name:'Long', value:'long'},
                { name:'Short', value:'short'}
            ],
            'easing' : [
                { name:'Default', value:''},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ],
            'brightness' : [
                { name:'Default', value:''},
                { name:'Flash', value:'flash'},
                { name:'Fade', value:'fade'}
            ]
        },

        "stretch" : {
            'direction' : [
                { name:'Left', value:'left'},
                { name:'Right', value:'right'},
                { name:'Top', value:'top'},
                { name:'Bottom', value:'bottom'},
                { name:'Random', value:''}
            ],
            'distance' : [
                { name:'Default', value:''},
                { name:'Long', value:'long'},
                { name:'Short', value:'short'}
            ],
            'easing' : [
                { name:'Default', value:''},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ],
            'brightness' : [
                { name:'Default', value:''},
                { name:'Flash', value:'flash'},
                { name:'Fade', value:'fade'}
            ]
        },

        "warp" : {
            'direction' : [
                { name:'Left', value:'left'},
                { name:'Right', value:'right'},
                { name:'Top', value:'top'},
                { name:'Bottom', value:'bottom'},
                { name:'Random', value:''}
            ],
            'distance' : [
                { name:'Default', value:''},
                { name:'Long', value:'long'},
                { name:'Short', value:'short'}
            ],
            'easing' : [
                { name:'Default', value:''},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ],
            'brightness' : [
                { name:'Default', value:''},
                { name:'Flash', value:'flash'},
                { name:'Fade', value:'fade'}
            ]
        },

        "zoom" : {
            'direction' : [
                { name:'In', value:'in'},
                { name:'Out', value:'out'},
                { name:'Random', value:''}
            ],
            'distance' : [
                { name:'Default', value:''},
                { name:'Long', value:'long'},
                { name:'Short', value:'short'}
            ],
            'easing' : [
                { name:'Default', value:''},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ],
            'brightness' : [
                { name:'Default', value:''},
                { name:'Flash', value:'flash'},
                { name:'Fade', value:'fade'}
            ]
        },

        "powerzoom" : {
            'direction' : [
                { name:'In', value:'in'},
                { name:'Out', value:'out'},
                { name:'Random', value:''}
            ],
            'distance' : [
                { name:'Default', value:''},
                { name:'Long', value:'long'},
                { name:'Short', value:'short'}
            ],
            'easing' : [
                { name:'Default', value:''},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ],
            'brightness' : [
                { name:'Default', value:''},
                { name:'Flash', value:'flash'},
                { name:'Fade', value:'fade'}
            ]
        },

        "flash" : {
            'easing' : [
                { name:'Default', value:''},
                { name:'Fast', value:'fast'},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ]
        },
        "fade" : {
            'easing' : [
                { name:'Default', value:''},
                { name:'Fast', value:'fast'},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ]
        },

        "twirl" : {
            'direction' : [
                { name:'Left', value:'left'},
                { name:'Right', value:'right'},
                { name:'Random', value:''}
            ],
            'distance' : [
                { name:'Default', value:''},
                { name:'Long', value:'long'},
                { name:'Short', value:'short'}
            ],
            'easing' : [
                { name:'Default', value:''},
                { name:'Slow', value:'slow'},
                { name:'Elastic', value:'elastic'}
            ],
            'brightness' : [
                { name:'Default', value:''},
                { name:'Flash', value:'flash'},
                { name:'Fade', value:'fade'}
            ]
        }
    }



    addListeners();
    addDeleteAllListeners();
    addDeleteSlideListeners();
    addEditListeners();
    makeSortable();

	function addListeners(){

        $('.add-slides-button').click(function(e) {

            e.preventDefault();

            if (file) file.close();

            file = wp.media.frames.file = wp.media({
                title: 'Edit image / video',
                button: {
                    text: 'Select',
                },
                multiple: true
            });

            file.on('select', function(){

                var arr = file.state().get('selection');
                var slides = new Array();

                var existingSlides = $('.slide-item').length
                var names=new Array();


                $('.slide-item').each(function(i, obj) {
                    names.push(parseInt($(this).attr('id')))
                })

                options.slides = options.slides || []

                for (var i = 0; i < arr.models.length; i++) {

                    var url = arr.models[i].attributes.url;

                    slides.push({
                        url: url,
                        id: i
                    });

                    options.slides[counterForSlides] = {
                        src: url
                    }

                    createSlidesHtml(counterForSlides, url)

                    counterForSlides++

                }

                addDeleteSlideListeners();
                addEditListeners();
                makeSortable();
                enableButtons();

            })

            file.open();
        });
    };


    function addEditListeners() {

        $('.STX-modal-close-btn, .STX-modal-window-overlay').click(function(e) {
            closeModal();
        });

        $('.slide-settings').click(function(e) {

           currentSlide = parseInt(getSlideId($(this)))

           $('a[data-tab="tab-general"]').click()

           showSlide(currentSlide)

           $("body").css("overflow","hidden")

        });

        $("#transitionEffect").change(function(e){

            options.slides[currentSlide].transitionEffect = this.value

            var dropdowns = ["direction", "brightness", "easing", "distance"]

            for(var key in dropdowns){
                var val = dropdowns[key]
                delete options.slides[currentSlide][val]
                $("#setting-" + val).hide()
            }

            var trOptions = transitionOptions[this.value]
            for(var key in trOptions){
                var dropdownId = key
                var $dropdown = $("#" + dropdownId).empty()
                $("#setting-" + dropdownId).show()
                var dropdownOptions = trOptions[key]
                for(var key2 in dropdownOptions){
                    var obj = dropdownOptions[key2]
                    $('<option value="'+obj.value+'">'+obj.name+'</option>').appendTo($dropdown)
                }
                options.slides[currentSlide][key] = dropdownOptions[0].value
            }

        })

        $("#direction").change(function(e){

            options.slides[currentSlide].direction = this.value

        })

        $("#easing").change(function(e){

            options.slides[currentSlide].easing = this.value

        })

        $("#distance").change(function(e){

            options.slides[currentSlide].distance = this.value

        })

        $("#brightness").change(function(e){

            options.slides[currentSlide].brightness = this.value

        })

        $('.media-modal-close').click(function(e) {
            $editSlideModalBackdrop.hide()
            $editSlideModal.hide()
            $("body").css("overflow","auto")
        })

        $('.edit-attachment').click(function(e) {

            e.preventDefault();

            var btn = $(this);

            if (file) file.close();

            file = wp.media.frames.file = wp.media({
                title: 'Edit image / video',
                button: {
                    text: 'Select',
                },
                multiple: false
            });

            file.on( 'select', function() {

                var attachment = file.state().get('selection').first().toJSON();
                var attachmentUrl = attachment.url

                var img, video, type, ext;
                if ((/\.(jpg|jpeg|gif|png)$/i).test(attachmentUrl)){
                    type = img, ext = 'img'
                }
                else if ((/\.(mp4|ogg|ogv|webm)$/i).test(attachmentUrl)){
                    type = video, ext = 'video'
                }


                options.slides[currentSlide].src = url

                setSlideSrc(currentSlide, attachmentUrl)

                showSlide(currentSlide)

            });

            file.open();
        });





        $('.slider-apply-btn-modal').click(function(e) {
            responseSuccess = false
            var i = setInterval(function() {
                if(responseSuccess){
                    clearInterval(i)
                }
            }, 200);
        });

        $(".slide-item").each(function (i, item) {
            $(item).mouseover(function() {
                $(this).find('.STX-box-on-hover').show()
            });
            $(item).mouseout(function() {
                $(this).find('.STX-box-on-hover').hide()
            });
        })
    }

    function setSlideSrc(index, src){
        options.slides[index].src = src
    }

    function showSlide(index){

        var slide = options.slides[index]
        var src = slide.src, type

        if ((/\.(jpg|jpeg|gif|png)$/i).test(src)){
            type = 'img'
        }
        else if ((/\.(mp4|ogg|ogv|webm)$/i).test(src)){
            type = 'video'
        }

        currentSlideType = type


        $editSlideModalBackdrop.show()
        $editSlideModal.show()

        $('.video-container').empty()

        if(type == 'img'){
            $editSlideModal.find(".details-image").attr('src', src).show()
        }else{
            $editSlideModal.find(".details-image").hide()
            var $vid = $('<video id="edit-slide-video" class="wp-video-shortcode" src="'+src+'" preload="metadata" controls style="width: 100% "></video>')
            .appendTo($('.video-container'))
        }

        $editSlideModal.find(".media-frame-title").find("h1").text("Edit slide " + String(parseInt(index)+1) )

        $editSlideModal.find('[data-setting="url"]').find('input').val(src)

        var dropdowns = ["direction", "brightness", "easing", "distance"]

        for(var key in dropdowns){
            var val = dropdowns[key]
            $("#setting-" + val).hide()
        }


        var slideOptions = options.slides[index]
        var trEffect = slideOptions.transitionEffect || ""
        $("#transitionEffect").val(trEffect)

        var trOptions = transitionOptions[slideOptions.transitionEffect]
        for(var key in trOptions){
            var dropdownId = key
            var $dropdown = $("#" + dropdownId).empty()
            $("#setting-" + dropdownId).show()
            var dropdownOptions = trOptions[key]
            for(var key2 in dropdownOptions){
                var obj = dropdownOptions[key2]
                $('<option value="'+obj.value+'">'+obj.name+'</option>').appendTo($dropdown)
            }
        }

        $('#src').val("")
        $('#transitionDuration').val("")
        $('#layerWidth').val("")
        $('#layerHeight').val("")

        for(var key in slideOptions){
			if(typeof slideOptions[key] == 'number' || typeof slideOptions[key] == 'string')
			$('#' + key).val(slideOptions[key] || "")
        }

        clearSlideElements()

        if(slide.elements){
            for(var key in slide.elements){
                var elem = slide.elements[key]
                addElement(elem)
                // switch(elem.type){
                //     case "text":
                //         addTextElement(elem)
                //         break;
                //     case "image":
                //         addImageElement(elem)
                //         break
                //     case "button":
                //         addButtonElement(elem)
                //         break
                // }
            }
            selectElement(0)
        }else{
            clearLayers()
        }


        // renderLayers()

    }

    function clearSlideElements(){
        $('.slide-element').remove()
        $elementSettings.hide()
    }

    function getSlideName(element){
        return element.parent().parent().attr('data-slide-name');
    }

    function getSlideId(element){
        return element.parent().parent().attr('id');
    }

    function getSlideNameByOption(element){
        return element.parent().parent().attr('data-slide-options-name');
    }

    function openModal(type, title){
        modal.fadeIn( "fast", function() { });

        modal.removeClass('previewActive')
        modal.removeClass('slideActive')
        modalContent.removeClass('previewSize')

        $("body").css("overflow","hidden")

        switch(type){

            case "preview":
                modalContent.addClass('previewSize')
                modal.addClass('previewActive')
                modalTitle.text(title)
                // showPreloader();
                $(".slider_preview").show();
                $('#STX-editing-slide-settings').hide();
                $('.slider-apply-btn-modal').hide();
                break;

            case "navigation":
                modal.addClass('navigationActive')
                modalTitle.text(title)
                hidePreloader();
                $(".slider_preview").hide();
                $('#STX-editing-slide-settings').hide();
                $('.slider-apply-btn-modal').hide();
                break;
        }
        positionModal();
    }

    function closeModal(){

        modal.fadeOut( "fast", function() { });

        $("body").css("overflow","auto")

        if(modal.hasClass('previewActive')){
            if(!$.isEmptyObject($('.slider_preview').data())){
                slider = $(".slider_preview").data('nextcodeSlider');
                slider.stopSlider(o)
            }
        }
        else if (modal.hasClass('slideActive')){
            $('video').each(function () {
                $(this).get(0).pause();
            });
        }

        $("body").css("overflow","auto")
    }

    function positionModal(){
        $('.STX-modal-window-inside').css({
            top: $(window).height()/2 - $('.STX-modal-window-inside').height()/2
        })
    }

    function addDeleteSlideListeners() {
        var btnDelete = $('.remove-image');
        btnDelete.click(function () {

            $(this).parent().parent().animate({
                'opacity': 0
            }, 100).slideUp(200, function () {

                var id = $(this).attr('id')
                removeSlideFromOptions(id);

                $(this).remove();
            });

            $('[data-slide-options-name="'+getSlideName($(this))+'"]').remove();
        });

    }

    function removeSlideFromOptions(id) {

        var toRemove = options.slides[id];
        options.slides.splice($.inArray(toRemove, options.slides), 1);
    }

    function addDeleteAllListeners() {

        btnDeleteAll.click(function (e) {

            if(btns_disabled) return;

			if (confirm('Delete all slides. Are you sure?')) {

                $(".slide-item").animate({
                    'opacity': 0
                }, 100).slideUp(200, function () {
                    $(this).remove();
                });

                showNotification("warning", msgDeletedSlides);

				removeSlides();
			}
        });
    }

    function removeSlides(){

		options.slides = [];
        counterForSlides = 0;

        $('[data-slide-name]').remove();
        $('[data-slide-options-name]').remove();
	}

    function checkForSlidesOnInit() {
        (typeof options.slides !== 'undefined' && options.slides.length > 0) ? (btns_disabled = false) : (btns_disabled = true) ;
    }

    function enableButtons(){

        btns_disabled = false;

        $(".STX-main-table-wrapp").fadeIn( "fast", function() { });

        $('.slider-save-btn-disabled').removeClass('slider-save-btn-disabled').addClass('slider-save-btn-enabled');
        $('.slider-preview-btn-disabled').removeClass('slider-preview-btn-disabled').addClass('slider-preview-btn-enabled');
        $('.STX-slider-trash-btn-large-disabled').removeClass('STX-slider-trash-btn-large-disabled').addClass('STX-slider-trash-btn-large-enabled');
    }

    $('.STX-btn-menu').click(function(e){

		if($(this).parent().hasClass("STX-nav-active"))
			return

        $('.STX-btn-menu').parent().removeClass("STX-nav-active")
        $(this).parent().addClass("STX-nav-active")

        $('.STX-form-tab').hide();
        $('.options_'+$(this).attr('data-form-name')).fadeIn( "fast", function() { });
	});

    $('.STX-form-tab').hide();
    $('.options_publish').show();
    $('.options_slides').show();
    $('.STX-btn-menu[data-form-name="publish"]').parent().addClass("STX-nav-active");

    function createSlidesHtml(i, url){

        var preview

        if ((/\.(jpg|jpeg|gif|png)$/i).test(url)){
            preview = '<img title="Sort"  class="STX-image-preview" src="' + url + '">'
        }
        else if ((/\.(mp4|ogg|ogv|webm)$/i).test(url)){
            preview = '<video title="Sort"  class="STX-video-preview" src="' + url + '"></video>'
        }

        var slideName = 'Slide ' + String(i+1)

		var markup = $('.STX-slides-container').append('<div title="Drag to reorder" id="'+i+'" class="STX-edit-slides-box STX-rect slide-item STX-edit-slider-box" data-slide-name="Slide '+i+'">'
            + preview
			+'<div class="STX-box-overlay STX-box-on-hover"><a name="' + i + '" class="STX-edit-link slide-settings STX-btn STX-button-green STX-radius-global STX-uc STX-h5" title="Edit">Edit</a><div class="STX-slider-settings-btn-small btn-sm slide-settings" title="Settings"></div><div class="STX-slider-trash-btn-small remove-image" name="' + i + '" title="Delete slide"></div></div>'
			+'<div class="STX-box-placeholder" data-align="">'
			    +'<div class="STX-box-placeholder-title">'
					+'<div class="STX-h4">'+slideName+'</div>'
			    +'</div>'
			+'</div>'
		+'</div>')
	}

    function showNotification(type,text){

        $('.STX-saved-notification-wrapper').stop().slideUp(300);

        content.text(text)

        $('.STX-saved-notification-wrapper').stop().slideDown( "fast", function() {
            $(this).delay(3000).slideUp(300);
        });

        content.attr('class','STX-saved-notification-content')

        switch(type){
            case "success":
                content.addClass('STX-saved-notification-success');
            break;
            case "error":
                content.addClass('STX-saved-notification-error');
            break;
            case "warning":
                content.addClass('STX-saved-notification-warning');
            break;
        }
    }

    $('.STX-btn-copy-shortcode').click(function(){
        var id = $(this).attr("id")
        var copied = "[nextcodeslider id='"+id+"']"
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(copied).select();
        document.execCommand("copy");
        $temp.remove();

        $('.STX-btn-copy-shortcode').text("Copy")
        $('.STX-btn-copy-shortcode').removeClass("STX-copy-shortcode-highlight")
        $(this).addClass("STX-copy-shortcode-highlight")
        $(this).text("COPIED!")
    })

    function hidePreloader(){
        preloader.stop().animate({opacity:0},100,function(){$(this).hide()});
    }
    function showPreloader(){
        preloader.stop().animate({opacity:1},100,function(){$(this).show()});
    }

    function checkResponseForSlides(o){
        return (!o.hasOwnProperty('slides') || o.slides.length === 0) ? false : true;
    }






    // layer render

    var LayerRenderer = function(){


        // $( window ).resize(function() {
        //   updateLayerSizeForSlide();
        // })


          var $layers = jQuery(".layer-container").css(
        {
        '-moz-transform-origin': 'top left',
        'transform-origin':'top left',
        '-ms-transform-origin':'top left',
        '-webkit-transform-origin':'top left',
        'overflow': 'hidden',
        'width':'100%',
        'position':'absolute',
        'margin':'16px',
        'margin-top':'16px',
        'background-color':'rgba(200,0,0,.3)'
        });




        this.render = function(elements, sw, sh, lw, lh){

            this.elements = elements

            updateLayerSizeForSlide(sw, sh, lw, lh);

             $layers.empty()


             if(elements){
				$layers.css('visibility','hidden')
				addNodeElements(elements, function(){
				  updateElementProperties(elements);
				  $layers.css('visibility','visible')
				})
             }

        }

        this.clear = function(){
            $layers.empty()
        }

        this.focusElement = function(index){
            // if(this.elements[index] && this.elements[index].node && this.elements[index].node.style){
            //     this.elements[index].node.style.backgroundColor = "#F00";
            // }
        }




          function removeNodeElements(elements) {
            elements.forEach(function(element) {
                  jQuery(element.node).remove();
              })
          }

         function updateElementProperties(elements) {

            // console.log("updateElementProperties")

            elements.forEach(function(element) {
                var node = element.node, $node = jQuery(node)
                if (element.content) node.innerHTML = element.content;
                if (element.fontFamily) $node.css({ "font-family": element.fontFamily });
                if (element.backgroundColor) node.style.setProperty("background-color", element.backgroundColor);
                if (element.fontWeight) node.style.setProperty("font-weight", element.fontWeight);
                if (element.textColor) node.style.setProperty("color", element.textColor);
                if (element.textAlign) node.style.setProperty("text-align", element.textAlign);
                if (element.lineHeight) 
                    node.style.setProperty("line-height", element.lineHeight)
                else
                    node.style.setProperty("line-height", "initial");
                if (element.fontSize) node.style.setProperty("font-size", element.fontSize);
                if (element.padding) node.style.setProperty("padding", element.padding);
                if (element.borderRadius) node.style.setProperty("border-radius", element.borderRadius + "px");
                if (element.width) node.style.setProperty("width", element.width + "px");
                if(element.customCSS) $node.attr("style", $node.attr("style") + "; " + element.customCSS);
                if(!element.position.offsetX) element.position.offsetX = 0;
                if(!element.position.offsetY) element.position.offsetY = 0;
                if(element.position.x === "center") $node.css({ left: "calc(50% - " + $node.outerWidth() / 2 + "px + " + element.position.offsetX + "px)" });
                if(element.position.x === "left") $node.css({ left: "calc(0% + " + element.position.offsetX + "px)" });
                if(element.position.x === "right") $node.css({ left: "calc(100% - " + $node.outerWidth() + "px - " + element.position.offsetX + "px)" });

                if(element.position.y === "center") $node.css({ top: "calc(50% - " + $node.outerHeight() / 2 + "px - " + element.position.offsetY + "px)" });
                if(element.position.y === "top") $node.css({ top: "calc(0% + " + element.position.offsetY + "px)" });
                if(element.position.y === "bottom") $node.css({ top: "calc(100% - " + $node.outerHeight() + "px - " + element.position.offsetY + "px)" });

            })

        }


        function updateLayerSizeForSlide(sw, sh, lw, lh) {
          var layerWidth = lw;
          var layerHeight = lh;
          var slideWidth = sw;
          var slideHeight = sh;

          $layers.css({
            width: layerWidth,
            height: layerHeight
          });

          var scaleX = slideWidth / layerWidth;
          var scaleY = slideHeight / layerHeight;
          var baseScale = scaleX > scaleY ? scaleY : scaleX;

          var newLeftPos = Math.abs(Math.floor((layerWidth * baseScale - slideWidth) / 2));
          var newTopPos = Math.abs(Math.floor((layerHeight * baseScale - slideHeight) / 2));

          $layers.css({
            "-webkit-transform": "scale(" + baseScale + ")",
            left: newLeftPos + "px",
            top: newTopPos + "px"
          })
        }

        function addNodeElements(elements, callback) {

          var numberOfElements = elements.length;

            elements.forEach(function(element) {
              let fontToLoad = element.fontFamily;

            switch (element.type) {
              case "text":
                var node = document.createElement("div");

                loadFont();
                break;

              case "image":
                var node = new Image();
                if (element.src) node.src = element.src;
                if (element.size) {
                  node.style.setProperty("width", element.size + "px");
                  node.style.setProperty("height", "auto");
                }
                node.onload = function() {
                  setProperties();
                  if (callback) checkIsCallbackReady();
                };
                break;

              case "button":
                var node = document.createElement("a");
                node.classList.add("stx-layer-button");

                if (element.url) {
                  node.href = element.url;
                  node.setAttribute("target", "_blank");
                }
                loadFont();
                break;
            }

            function setProperties() {
              node.style.setProperty("position", "absolute");
              element.node = node;
              $layers.append(jQuery(node));
            }

            function loadFont() {
              if (fontToLoad) {
                WebFont.load({
                  google: {
                    families: [fontToLoad]
                  },
                  fontactive: function() {
                    setProperties();
                    if (callback) checkIsCallbackReady();
                  },
                  fontinactive: function() {
                    setProperties();
                    if (callback) checkIsCallbackReady();
                  }
                });
              } else {
                setProperties();
                if (callback) checkIsCallbackReady();
              }
            }

              function checkIsCallbackReady(){
                numberOfElements--;
                if (!numberOfElements) {
                  if (callback) callback();
                }
              }

            })

        }
    };

    var layerRenderer = new LayerRenderer()

});


})(jQuery);

function stripslashes (str) {
  return (str + '').replace(/\\(.?)/g, function (s, n1) {
	switch (n1) {
	case '\\':
	  return '\\';
	case '0':
	  return '\u0000';
	case '':
	  return '';
	default:
	  return n1;
	}
  });
}
function getParameterByName(name, url) {
    if (!url)
        url = window.location.href;
    url = url.toLowerCase();
    // This is just to avoid case sensitiveness
    name = name.replace(/[\[\]]/g, "\\$&").toLowerCase();
    // This is just to avoid case sensitiveness for query parameter name
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
