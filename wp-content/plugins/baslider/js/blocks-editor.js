/*
 * Gutenberg block Javascript code
 */
"use strict"; 
var __ = wp.i18n.__, // The __() function for internationalization.
    el = wp.element.createElement, // The wp.element.el() function to create elements.
    registerBlockType = wp.blocks.registerBlockType, // The registerBlockType() function to register blocks.
    InspectorControls = wp.editor.InspectorControls,
    ServerSideRender = wp.components.ServerSideRender,
    Button = wp.components.Button,
    Dashicon = wp.components.Dashicon,
    IconButton = wp.components.IconButton,
    RichText = wp.editor.RichText,
    Editable = wp.blocks.Editable, // Editable component of React.
    MediaUpload = wp.editor.MediaUpload,
    MediaUploadCheck = wp.editor.MediaUploadCheck,
    TextControl = wp.components.TextControl,
    SelectControl = wp.components.SelectControl,
    RadioControl = wp.components.RadioControl
Toolbar = wp.components.Toolbar

slider_ids = jQuery.parseJSON(slider_ids);

var available_sliders = [
 { label: '', value: '' }
]

for (var key in slider_ids){
    available_sliders.push({label:slider_ids[key], value:slider_ids[key]})
}

var make_title_from_url = function(url) {
    var re = RegExp('/([^/]+?)(\\.pdf(\\?[^/]*)?)?$', 'i');
    var matches = url.match(re);
    if (matches.length >= 2) {
        return matches[1];
    }
    return url;
}
/**
 * Register block
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          Block itself, if registered successfully,
 *                             otherwise "undefined".
 */
registerBlockType(
    'nextcodeslider/embed', // Block name. Must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.  
    {
        title: 'Slider', // Block title. __() function allows for internationalization.
        description: 'Awesome slider',

        icon: {
            // Specifying a background color to appear with the icon e.g.: in the inserter.
            // background: '#999',
            // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
            // foreground: '#000',
            // Specifying a dashicon for the block
            src: 'image-flip-horizontal',
        },


        // icon: 'book', // Block icon from Dashicons. https://developer.wordpress.org/resource/dashicons/.
        category: 'common', // Block category. Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
        attributes: {
            id: {
                type: 'string'
            },
        },

        // Defines the block within the editor.
        edit: function(props) {

            var { attributes, setAttributes, focus, className } = props;

            var onSelectPDF = function(media) {
                return props.setAttributes({
                    pdf: media.url
                });
            }

            function onSelectImages(media) {
               
            }

            function onChangeWidth(v) {
                setAttributes({ width: v });
            }

            function onChangeHeight(v) {
                setAttributes({ height: v });
            }

            function onChangeMode(v) {
                setAttributes({ mode: v });
            }

            function onChangeId(v) {
                setAttributes({ id: v });
            }

            function onChangeToolbarfixed(v) {
                setAttributes({ toolbarfixed: v });
            }

            var attributes = props.attributes || "";
            var pdf = attributes.pdf || ''

            return [


                el(
                    'div',
                    null,
                    'Transitionslider'
                ),
                el(
                            SelectControl, {
                                label: 'Select Slider',
                                value: attributes.id,
                                options: available_sliders,
                                onChange: onChangeId
                            }
                        ),
                // el(
                //     'div', { className: "wp-block-shortcode" },
                //     el(
                //         MediaUploadCheck,
                //         null,
                //         el(
                //             Toolbar,
                //             null,
                //             el(
                //                 MediaUpload, {
                //                     onSelect: onSelectPDF,
                //                     allowedTypes: ['application/pdf'],
                //                     // value: "val",
                //                     render: function render(_ref5) {
                //                         var open = _ref5.open;
                //                         return el(IconButton, {
                //                             // className: "components-toolbar__control",
                //                             label: 'Select PDF',
                //                             icon: "media-document",
                //                             onClick: open
                //                         }, "Select PDF");
                //                     }
                //                 }
                //             ),
                //             el(
                //                 TextControl, {
                //                     // label: 'PDF url',
                //                     value: attributes.pdf,
                //                     onChange: onChangeWidth
                //                 }
                //             ),
                //         )
                //     ),
                // ),



                el(
                    InspectorControls, { key: 'inspector' }, // Display the block options in the inspector pancreateElement.
                    el(
                        'div', { className: 'nextcodeslider' },
                        el(
                            'hr', {},
                        ),


                        el(
                            SelectControl, {
                                label: 'Select Slider',
                                value: attributes.id,
                                options: available_sliders,
                                onChange: onChangeId
                            }
                        ),
                    ),
                ),
            ];
        },


        save: function save(props) {
            var attributes = props.attributes || "";
            attributes.id = attributes.id || "1"
            return '[nextcodeslider id="' + attributes.id + '"]'
        }


    }
);
