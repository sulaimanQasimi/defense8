// import LineHeight from 'plugins/LineHeight/plugin.js'; // Import
/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

/*CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
};*/
// CKEDITOR.config.extraPlugins = 'lineheight';
CKEDITOR.editorConfig = function (config) {
    // config.extraPlugins = 'richcombo';

    config.uiColor = '#AADC6E';

    config.language = 'fa';
    config.extraPlugins = 'lineheight';
    config.line_height="0.1em;0.2em;0.3em;0.4em;0.5em;1em;1.1em;1.2em;1.3em;1.4em;1.5em";
    config.toolbar = [
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'] },
        { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
        { name: 'insert', items: ['HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'] },
        { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        { name: 'tools', items: ['Maximize', 'ShowBlocks','lineheight'] },
    ];

    config.contentCss = "../font.css";
    config.font_names = 'nasim/persian-font;nazanin/nazanin-font' + config.font_names;
};
