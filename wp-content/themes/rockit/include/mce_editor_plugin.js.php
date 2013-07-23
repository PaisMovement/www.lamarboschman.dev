<?php 
	require_once '../../../../wp-load.php';
	require_once '../../../../wp-admin/includes/admin.php';
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
	if(!isset($shortcodesES))
		$shortcodesES = new ShortcodesEditorSelector();
	
	global $shortcode_tags;
	$ordered_sct = array_keys($shortcode_tags);
	$neworder = sort($ordered_sct);

?>

(function() {
	tinymce.create('tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>', {
		init : function(ed, url) {
		},	
		createControl : function(n, cm) {
			if(n=='<?php echo $shortcodesES->buttonName; ?>'){
                var mlb = cm.createListBox('<?php echo $shortcodesES->buttonName; ?>', {
                     title : 'Shortcode',
                         onselect : function(v) { //Add shortcode data onClick
                             if(v == 'toogle'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_toggle title="Toggle Title 1"]Toggle Content 1[/cs_toggle]<br /><br />');
                                }
                             else if(v == 'tabs'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_tab] <br />\
                                            [cs_tab_item title="Tab Title 1" tabs="tabs"]Tab Content 1[/cs_tab_item]<br />\
                                            [cs_tab_item title="Tab Title 2" tabs="tabs"]Tab Content 2[/cs_tab_item]<br />\
                                            [cs_tab_item title="Tab Title 3" tabs="tabs"]Tab Content 3[/cs_tab_item]<br />\
                                            [/cs_tab]<br /><br />');
                                }
                             else if(v == 'accordion'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_accordion] <br />\
                                            [cs_accordion_item title="Accordion Title 1" accordion="accordion"]Accordion Content 1[/cs_accordion_item] <br />\
                                            [cs_accordion_item title="Accordion Title 2" accordion="accordion"]Accordion Content 2[/cs_accordion_item] <br />\
                                            [cs_accordion_item title="Accordion Title 3" accordion="accordion"]Accordion Content 3[/cs_accordion_item] <br />\
                                            [/cs_accordion]<br /><br />');
                                }
                             else if(v == 'divider'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_divider title="Divider Content"]<br /><br />');
                                }
                             else if(v == 'quote'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_quote align="center" color="#COLOR_CODE"]Quote Content[/cs_quote]<br /><br />');
                                }
                             else if(v == 'button'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_button color="#COLOR_CODE" background="#COLOR_CODE" src="LINK_URL"]Button Content[/cs_button]<br /><br />');
                                }
                             else if(v == 'column'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_column size="1/2"]Column Content[/cs_column]<br /><br />');
                                }
                             else if(v == 'dropcap'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_dropcap]Dropcap Content[/cs_dropcap]<br /><br />');
                                }
                             else if(v == 'message_box'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_message_box color="#COLOR_CODE" background="#COLOR_CODE" border_color="#COLOR_CODE" title="Message Title"]Message Content[/cs_message_box]<br /><br />');
                                }
                             else if(v == 'frame'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_frame src="IMAGE_SOURCE" width="IMAGE_WIDTH" height="IMAGE_HEIGHT" lightbox="on" title="Image Title"]<br /><br />');
                                }
                             else if(v == 'list'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_list type="default"]<br />\
                                                [cs_list_item]List Item 1[/cs_list_item]<br />\
                                                [cs_list_item]List Item 2[/cs_list_item]<br />\
                                                [cs_list_item]List Item 3[/cs_list_item]<br />\
                                             [/cs_list]<br /><br />');
                                }
                             else if(v == 'table'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_table color="#Color_Code"]<br />\
                                                [thead]<br />\
                                                  [tr]<br />\
                                                    [th]Column 1[/th]<br />\
                                                    [th]Column 2[/th]<br />\
                                                    [th]Column 3[/th]<br />\
                                                    [th]Column 4[/th]<br />\
                                                  [/tr]<br />\
                                                [/thead]<br />\
                                                [tbody]<br />\
                                                  [tr]<br />\
                                                    [td]Item 1[/td]<br />\
                                                    [td]Item 2[/td]<br />\
                                                    [td]Item 3[/td]<br />\
                                                    [td]Item 4[/td]<br />\
                                                  [/tr]<br />\
                                                  [tr]<br />\
                                                    [td]Item 11[/td]<br />\
                                                    [td]Item 22[/td]<br />\
                                                    [td]Item 33[/td]<br />\
                                                    [td]Item 44[/td]<br />\
                                                  [/tr]<br />\
                                                [/tbody]<br />\
                                         [/cs_table]<br /><br />');
                                }
                             else if(v == 'gallery'){
                                        tinyMCE.activeEditor.selection.setContent('[cs_minigallery width="WIDTH" post_id="Gallery_Page_ID"]<br /><br />');
                                }
                     }
                });
                // Add Elements for DropDown
                	mlb.add('toogle','toogle');
                	mlb.add('tabs','tabs');
                	mlb.add('accordion','accordion');
                	mlb.add('divider','divider');
                	mlb.add('quote','quote');
                	mlb.add('button','button');
                	mlb.add('column','column');
                	mlb.add('dropcap','dropcap');
                	mlb.add('message_box','message_box');
                	mlb.add('frame','frame');
                	mlb.add('list','list');
                	mlb.add('table','table');
                	mlb.add('gallery','gallery');
                // Return the new listbox instance
                return mlb;
             }
             return null;
		},
	});
	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesES->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>);
})();
