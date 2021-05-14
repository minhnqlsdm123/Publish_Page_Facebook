/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.height = '40vh';
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'youtube';
    // config.allowedContent = true;
    config.removeDialogTabs = 'link:upload;image:Upload;;flash:Upload';
    config.contentsCss = 'fonts.css';
//the next line add the new font to the combobox in CKEditor
    config.font_names = 'Calibri/Calibri;' + config.font_names;
    config.font_names = 'Helvetica/Helvetica;' + config.font_names;
    config.font_names = '微软正黑体/微软正黑体;' + config.font_names;
};
