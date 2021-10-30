"use strict";
( function( $ ) {

$( document ).ready(function() {

    var self = this;
	this.sliders = $.parseJSON(sliders);
    var arr = []
    
    for(var key in this.sliders){
        convertStrings(this.sliders[key])
        arr.push(this.sliders[key])
    }
    this.sliders = arr
    
    var modal = $('.STX-modal-window')
    var modalTitle = $('.STX-modal-window-title');
    var preloader = $('.STX-preview-preloader');
    var importText = $(".STX-modal-window-import-text");
    var slider;
    var _s;
    
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
    
    function downloadObjectAsJson(exportObj, exportName){
        var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(exportObj);
        var downloadAnchorNode = document.createElement('a');
        downloadAnchorNode.setAttribute("href",     dataStr);
        downloadAnchorNode.setAttribute("download", exportName + ".json");
        document.body.appendChild(downloadAnchorNode); // required for firefox
        downloadAnchorNode.click();
        downloadAnchorNode.remove();
    }

    if(typeof sliders_json != "undefined"){
        downloadObjectAsJson(sliders_json, "sliders")
    }
    
    function addSlider(slider) {
        
        var slider_display_name;
        var url = "";
        
        slider.instanceName != "" ? slider_display_name = slider.instanceName : slider_display_name = slider.name
        
        if(!jQuery.isEmptyObject(slider.slides)){
            slider.slides.length > 0 ? url = slider.slides[0].src : url = ""
        }
        
        var img, video, noslide, type, ext;
        img = '<img title="Sort"  class="STX-image-preview" src="' + url + '">'
        video = '<video title="Sort"  class="STX-video-preview" src="' + url + '"></video>'
        noslide = '<div title="Sort"  class="STX-noslides"><p>No slides added</p></div>'
        
        if ((/\.(jpg|jpeg|gif|png)$/i).test(url)){            
            type = img, ext = 'img'
        }
        else if ((/\.(mp4|ogg|ogv|webm)$/i).test(url)){
            type = video, ext = 'video'
        }
        else 
            type = noslide
        
        
        var markup = $('<div class="STX-rect STX-isAdded STX-edit-slider-box" data-title="'+slider_display_name+'" data-sliderid="'+slider.id+'">'
            + type
            +'<div class="STX-box-overlay STX-box-on-hover">'
                +'<a name="' + slider.id + '" class="STX-edit-link STX-btn STX-button-green STX-radius-global STX-uc STX-h5 edit" title="Edit '+slider_display_name+'">Edit</a>'
                +'<div class="STX-slider-settings-btn-small btn-sm settings" name="' + slider.id + '" title="Settings">'
                    +'<div class="STX-slider-small-settings-wrapper">'
                        +'<div class="STX-slider-view-btn-small view btn-sm" title="View"></div>'
                        +'<div class="STX-slider-copy-btn-small btn-sm duplicate" name="' + slider.id + '" title="Duplicate"></div>'
                    +'</div>'
                +'</div>'
                +'<div class="STX-slider-trash-btn-small trash" name="' + slider.id + '" title="Delete"></div>'
            +'</div>'
            +'<div class="STX-box-placeholder" data-align="">'
                +'<div class="STX-box-placeholder-title">'
                    +'<a class="STX-h4">'+slider_display_name+'</a>'
                +'</div>'
                +'<div class="STX-box-placeholder-buttons">'
                +'</div>'
            +'</div>'
        +'</div>').appendTo($('.STX-container'))
    }
    
    function addOption(section,name,type,desc,defaultValue,values,subItemType){

		var table = $("#slider-options-"+section+"");
		var tableBody = table.find('tbody');
		var row = $('<tr valign="top"  class="field-row"></tr>').appendTo(tableBody);
		var th = $('<th scope="row" class="STX-th-label">'+desc+'</th>').appendTo(row);
        
            if(subItemType)
                $(th).addClass(subItemType)	

		switch(type){
            
            case "text":
                var td = $('<td class="STX-element"><div class="STX-form-element-text STX-element-num  STX-text-has-unit  STX-input-border-radius"></div></td>').appendTo(row);
                var input = $('<input class="inputField" type="text" name="'+name+'"/>').appendTo(td.children());
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
                var input = $('<input class="inputField" type="text" name="'+name+'"/><div class="STX-text-unit STX-unit-font">'+values+'</div>').appendTo(td.children());
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
				var input = $('<input class="STX-input" type="text" name="' + name + '"/>').appendTo(td);
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
			    var textarea = $('<textarea class="STX-input" type="text" name="'+name+'" cols=45" rows="1"></textarea>').appendTo(td);
				if(typeof(options[name]) != 'undefined'){
					textarea.attr("value",options[name]);
				}else {
					textarea.attr('value',defaultValue);
				}
				break;
                
			case "checkbox":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);
                var inputHidden = $('<input class="STX-input" type="hidden" name="'+name+'" value="false"/>').appendTo(td);
                var input = $('<div class="STX-onoffswitch"><input type="checkbox" name="'+name+'" value="true" class="STX-onoffswitch-checkbox" id="'+name+'"><label class="STX-onoffswitch-label" for="'+name+'"><span class="STX-onoffswitch-inner"></span><span class="STX-onoffswitch-switch"></span></label></div>').appendTo(td);
                if(typeof(options[name]) != 'undefined'){
                    $(input).find('input').attr("checked",options[name]);
				}else {
                    $(input).find('input').attr("checked",defaultValue);
				}
				break;
                
			case "selectImage":
                var td = $('<td class="STX-td-element"></td>').appendTo(row);
				var input = $('<input class="STX-input" type="text" name="'+name+'"/><a class="select-image-button button-secondary button80" href="#">Select image</a>').appendTo(td);
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
						}
					}
					else if(defaultValue == values[i])
					{
                        $(li).parents('.dropdown').find('span').text(defaultValue);
					}
                }
				break;
		}
	}

    var keys = []
    for (var key in this.sliders) {
        keys.push(key);
        if(typeof this.sliders[key].date == 'undefined')
            this.sliders[key].date = '';
    }

    function dynamicSort(property) {
        var sortOrder = 1;
        if(property[0] === "-") {
            sortOrder = -1;
            property = property.substr(1);
        }
        return function (a,b) {
            var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
            return result * sortOrder;
        }
    }
    this.sliders.sort(dynamicSort("date"))
    this.sliders.reverse()


    function showSlider() {
        $('#sliders-table').empty()
        $('.STX-isAdded').remove()
        for (var i=0; i < arr.length ; i++) {
            var slider = arr[i]
            if (slider)
                addSlider(slider)
        }
        
        $('.edit').click(function(e) {
            e.preventDefault()
            var id = this.getAttribute("name")
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=edit&id=' + id
        })
        $('.duplicate').click(function(e) {
            e.preventDefault()
            var id = this.getAttribute("name")
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=duplicate&id=' + id
        })
        $('.trash').click(function(e) {
            e.preventDefault()
            var id = this.getAttribute("name")
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=delete&id=' + id
        })
        $('.undo').click(function(e) {
            e.preventDefault()
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=undo'
        })
    }

    showSlider()

    $('.delete_all_sliders').click(function() {
        
        if (confirm('Delete all sliders. Are you sure?')) {
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=delete_all'
        }
    })
    
    $('.bulkactions-apply').click(function() {
        var action = $(this).parent().find('select').val()
        if (action != '-1') {
            var list = []
            $('.row-checkbox').each(function() {
                if ($(this).is(':checked'))
                    list.push($(this).attr('name'))
            })
            if (list.length > 0) {
                window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=delete&id=' + list.join(",")
            }
        }
    })
    
    $(".STX-dashboard-wrapp").show();
	
	$('.STX-btn-menu').click(function(e){
        $('.STX-btn-menu').parent().removeClass("STX-nav-active")
        $(this).parent().addClass("STX-nav-active")
        
        $('.STX-form-tab').hide();
        $('.options_'+$(this).attr('data-form-name')).fadeIn( "fast", function() { });
	});
    
    $('.STX-form-tab').hide();
    $('.STX-btn-menu[data-form-name="general"]').parent().addClass("STX-nav-active");

    
    $('.STX-btn-topbar').click(function(e){
		$('.STX-form-tab').hide();
        $('.options_'+$(this).attr('data-form-name')).fadeIn( "fast", function() { });
	});  
    
    $('.copy-shortcode').click(function(){
        var id = $(this).attr("id")
        var copied = "[nextcodeslider id='"+id+"']"
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(copied).select();
        document.execCommand("copy");
        $temp.remove();
        $('.copy-shortcode').text("Copy")
        $(this).parent().addClass("slider-highlightText")
        $('.copy-shortcode').removeClass("STX-copy-shortcode-highlight")
        $(this).addClass("STX-copy-shortcode-highlight")
        $(this).text("Copied!")
    })
    
    $('.dropdown').click(function () {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropdown-menu').slideToggle(300);
    });
    $('.dropdown').focusout(function () {
        $(this).removeClass('active');
        $(this).find('.dropdown-menu').slideUp(300);
    });
    $('.dropdown .dropdown-menu li').click(function () {
        $(this).parents('.dropdown').find('span').text($(this).text());
        $(this).parents('.dropdown').find('input').attr('value', $(this).attr('id'));
        $(this).parents('.dropdown').find('input').attr('selected','true');;
    });
    $('.dropdown-menu li').click(function () {
        var getVal = $(this).parents('.dropdown').find('input').val();
        switch (getVal){
            case "newestFirst": sortByNewest(); break;
            case "oldestFirst": sortByOldest(); break;
        }
        showSlider()
        addListeners()
    });
    
    addListeners()
    
    function sortByNewest(){
        self.sliders.sort(dynamicSort("date"))
        self.sliders.reverse()
    }
    
    function sortByOldest(){
        self.sliders.sort(dynamicSort("date"))
    }
    
    function addListeners(){
        $('.trash').click(function(e) {
            e.preventDefault()
            var id = this.getAttribute("name")
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=delete&id=' + id
        })
        $('.duplicate').click(function(e) {
            e.preventDefault()
            var id = this.getAttribute("name")
            window.location = window.location.origin + window.location.pathname + '?page=nextcode_slider_admin&action=duplicate&id=' + id
        })
        $('.view').click(function(e) {
            e.preventDefault()
            
            
            openModal('preview', getSliderTitle($(this).parent().parent()));
        })
        $(".STX-isAdded").each(function (i, item) {
            $(item).mouseover(function() { 
                $(this).find('.STX-box-on-hover').stop().slideDown(100);
            });
            $(item).mouseout(function() { 
                $(this).find('.STX-box-on-hover').stop().slideUp(100);
            }); 
        })
        $(".settings").each(function (i, item) {
            $(item).mouseover(function() { 
                $(this).parent().find('.STX-slider-small-settings-wrapper').stop().fadeIn( "slow", function() { });
            });
            $(item).mouseout(function() { 
                $(this).parent().find('.STX-slider-small-settings-wrapper').stop().fadeOut( "fast", function() { });
            }); 
        })
    }
    
    function openModal(type, title){
        modal.fadeIn( "fast", function() { });
        
        modalTitle.text(title)
        $(".slider_preview").hide();
        
        modal.removeClass('previewActive')
        modal.removeClass('importActive')
        
        switch(type){
            case "import":
                modal.addClass('importActive')
                importText.show();
            break;
            
            case "preview":
                modal.addClass('previewActive')
                importText.hide();
                
                for(var key in self.sliders){
                    if(title ==  self.sliders[key].instanceName){
                        _s = self.sliders[key]
                    }
                }
                $(".slider_preview").fadeIn( "slow", function() { });
                
                if($.isEmptyObject($('.slider_preview').data()))
                    $(".slider_preview").nextcodeSlider(_s);
                else{
                    slider = $(".slider_preview").data('nextcodeSlider');
                    slider.reloadSlider(_s)
                }
            break;
        }
    }
    function closeModal(){
        
        modal.fadeOut( "fast", function() { });
        
        if(modal.hasClass('previewActive')){
            if(!$.isEmptyObject($('.slider_preview').data())){
                slider = $(".slider_preview").data('nextcodeSlider');
                slider.stopSlider(_s)
            }
        }
        else if (modal.hasClass('importActive')){
            $('video').each(function () {
                $(this).get(0).pause();
            });
        }
        
    }
    
    $('.STX-modal-close-btn, .STX-modal-window-overlay').click(function(e) {
        closeModal();
    });
    
    $('.STX-slider-import-btn').click(function(e) {
        openModal('import','Import Sliders');
    });
    
    function getSliderTitle(element){
        return element.parent().parent().attr('data-title')
    }

});
}( jQuery ));
