(function() {
	tinymce.create( 'tinymce.plugins.instapageShortcodes',
	{
		init: function( ed, url ) {

			ed.addButton( 'divider',
			{
				text: 'divider',
				icon: false,
				title: 'Divider',
				cmd : 'divider'
			} );

			ed.addButton( 'banner',
			{
				text: 'banner',
				icon: false,
				title: 'Banner',
				cmd: 'banner'
			} );

			ed.addButton( 'quote',
			{
				text: 'quote',
				icon: false,
				title: 'Quote',
				cmd: 'quote'
			} );

			ed.addButton( 'ip_cta',
			{
				text: 'CTA',
				icon: false,
				title: 'CTA',
				cmd: 'ip_cta'
			} );
                        
			ed.addButton( 'ip_cta_image',
			{
				text: 'CTA Image',
				icon: false,
				title: 'CTA Image',
				cmd: 'ip_cta_image'
			} );

			ed.addButton( 'chapter_listing',
			{
				text: 'chapter_listing',
				icon: false,
				title: 'Chapter Listing',
				cmd: 'chapter_listing'
			} );

			ed.addButton( 'special_info',
			{
				text: 'special_info',
				icon: false,
				title: 'Add special-info section',
				cmd: 'special_info'
			} );

			ed.addButton( 'important',
			{
				text: 'important',
				icon: false,
				title: 'Add special styling - important',
				cmd: 'important'
			} );

			ed.addButton( 'page_jump',
			{
				text: 'page_jump',
				icon: false,
				title: 'Add page jump links',
				cmd: 'page_jump'
			} );

			ed.addCommand( 'divider', function()
			{
				var shortcode;

				shortcode = '[divider /]';
				ed.execCommand('mceInsertContent', 0, shortcode);
			} );

			ed.addCommand( 'special_info', function()
			{
				var selected_text = ed.selection.getContent();
				var return_text = '';

				return_text = '[special_info]' + selected_text + '[/special_info]';
				ed.execCommand('mceInsertContent', 0, return_text);
			} );

			ed.addCommand( 'page_jump', function()
			{
				var selected_text = ed.selection.getContent();
				var return_text = '';

				return_text = '[page_jump]' + selected_text + '[/page_jump]';
				ed.execCommand('mceInsertContent', 0, return_text);
			} );

			ed.addCommand( 'important', function()
			{
				var selected_text = ed.selection.getContent();
				var return_text = '';

				return_text = '<span class="important">' + selected_text + '</span>';
				ed.execCommand('mceInsertContent', 0, return_text);
			} );

			ed.addCommand( 'chapter_listing', function()
			{
				var shortcode;

				shortcode = '[chapter_listing /]';
				ed.execCommand('mceInsertContent', 0, shortcode);
			} );

			ed.addCommand( 'banner', function()
			{
				var banner_img = prompt( "Enter the banner image URL", "http://" );
				var banner_url = prompt( "Enter the banner hyperlink URL", "http://" );
				var param = '';
				var pattern = /^(http:\/\/|https:\/\/)/;

				if( banner_img.match( pattern ) === null )
				{
					banner_img = 'http://' + banner_img;
				}

				if( banner_url.match( pattern ) === null )
				{
					banner_url = 'http://' + banner_url;
				}

				param = ' img="' + banner_img + '" url="' + banner_url + '"';
				return_text = '[banner' + param + ' /]';
				ed.execCommand( 'mceInsertContent', 0, return_text );
			} );

			ed.addCommand( 'ip_cta', function()
			{
				return_text = '[ip_cta text="CTA button text" url="https://instapage.com" spacing_top="0" spacing_bottom="0" /]';
				ed.execCommand( 'mceInsertContent', 0, return_text );
			} );

			ed.addCommand( 'ip_cta_image', function()
			{
				var selected_text = ed.selection.getContent();
				return_text = '[ip_cta_image url="https://instapage.com" spacing_top="0" spacing_bottom="0"]' + selected_text + '[/ip_cta_image]';
				ed.execCommand( 'mceInsertContent', 0, return_text );
			} );

			ed.addCommand( 'quote', function()
			{
				var author = prompt( "Enter quote author", "" );
				var author_role = prompt( "Enter quote author role", "" );
				var link = prompt( "Enter author's link", "http://" );
				var param = '';
				var pattern = /^(http:\/\/|https:\/\/)/;
				var selected_text = ed.selection.getContent();

				if( link && link.match( pattern ) === null )
				{
					link = 'http://' + link;
				}

				if( typeof author !== 'undefined' && author )
				{
					param += ' author="' + author + '"';
				}

				if( typeof author_role !== 'undefined' && author_role )
				{
					param += ' author_role="' + author_role + '"';
				}

				if( typeof link !== 'undefined' && link && link !== 'http://' )
				{
					param += ' link="' + link + '"';
				}

				return_text = '[quote' + param + ']' + selected_text + '[/quote]';
				ed.execCommand( 'mceInsertContent', 0, return_text );
			} );
		},

		createControl: function( n, cm )
		{
			return null;
		},

		getInfo: function()
		{
			return {
				longname: 'Instapage Shortcodes',
				author: 'Instapage',
				authorurl: 'https://instapage.com',
				infourl: 'https://instapage.com',
				version: "0.1"
			};
		}
	} );
	
	tinymce.PluginManager.add( 'instapage_buttons', tinymce.plugins.instapageShortcodes );
})();