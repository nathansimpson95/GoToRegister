(function() {
    tinymce.PluginManager.add( 'custom_link_class', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('custom_link_class', {
            title: 'GoToRegister',
            cmd: 'custom_link_class',
            image: url + '/tinymce-icon.png',

        });
		// Add Command when Button Clicked
		editor.addCommand('custom_link_class', function() {
		    // Check we have selected some text that we want to link

		    // Ask the user to enter a URL
		    var webinarKey = prompt('GoToRegister\nPlease enter the webinar key');
		    if ( !webinarKey ) {
		        // User cancelled - exit
		        return;
		    }
		    if (webinarKey.length === 0) {
		        // User didn't enter a URL - exit
		        return;
		    }

		    // Insert selected text back into editor, wrapping it in an anchor tag
		    editor.execCommand('mceInsertContent', false, '[gotoregister webinar_key="'+ webinarKey +'"]');
		});
    });
})();
