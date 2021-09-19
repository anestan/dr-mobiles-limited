<?php
/*
Plugin Name: Advanced TinyMCE Configuration
Plugin URI: http://www.laptoptips.ca/projects/advanced-tinymce-configuration/
Description: Set advanced TinyMCE options for the classic block and classic editor.
Version: 1.6
Author: Andrew Ozz
Author URI: http://www.laptoptips.ca/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: adv-mce-config
Domain Path: /languages

	Advanced TinyMCE Configuration is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 2 of the License, or
	any later version.

	Advanced TinyMCE Configuration is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License along
	with Advanced TinyMCE Configuration. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

	Copyright 2011-2020 Andrew Ozz. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

add_filter( 'tiny_mce_before_init', 'advmceconf_config_mce', 1111 );
function advmceconf_config_mce( $config ) {
	global $plugin_page;

	if ( ! empty( $plugin_page ) && $plugin_page == 'advanced-tinymce-configuration' ) {
		global $advmceconf_show_defaults;

		$advmceconf_show_defaults = $config;
		return $config;
	}

	$options = get_option( 'advmceconf_options' );

	if ( empty( $options ) || ! is_array( $options ) ) {
		return $config;
	}

	return array_merge( $config, $options );
}

add_action( 'admin_head-settings_page_advanced-tinymce-configuration', 'advmceconf_style' );
function advmceconf_style() {
	?>
	<style type="text/css">
		.wrap.advmceconf {
			max-width: 80em;
		}

		.advmceconf-wrap {
			border: 1px solid #ddd;
			border-radius: 3px;
			background-color: #f8f8f8;
			padding: .5em 2em 1em;
			margin: 1em 0;
		}

		.advmceconf-wrap img.advmceconf-example {
			border: 1px solid #bbb;
			max-width: 100%;
			height: auto;
		}

		.advmceconf-form {
			padding: 2em 0 0;
		}

		.advmceconf-table {
			table-layout: fixed;
			border-collapse: collapse;
			margin: 0 0 3em;
			width: 100%;
			clear: both;
		}

		.advmceconf-table td {
			padding: 0.3em;
			line-height: 1.5;
			vertical-align: top;
		}

		.advmceconf-table th {
			font-weight: bold;
			text-shadow: rgba(255,255,255,1) 0 1px 0;
			padding: 0.5em 0.5em 0;
			text-align: left;
		}

		.advmceconf-table td.names input {
			width: 100%;
		}

		.advmceconf-table textarea {
			width: 100%;
			min-height: 100px;
			margin: 1px;
		}

		.advmceconf-table th.names {
			width: 24%;
		}

		.advmceconf-table .sep {
			width: 1em;
			text-align: center;
		}

		.advmceconf-table .actions {
			width: 100px;
			text-align: center;
			vertical-align: middle;
		}

		.advmceconf .advmceconf-defaults {
			white-space: -moz-pre-wrap !important;
			word-wrap: break-word;
			white-space: pre-wrap;
		}

		.advmceconf .advmceconf-defaults td,
		.advmceconf .advmceconf-defaults th {
			border-bottom: 1px solid #ddd;
			padding: .6em .3em;
		}

		.advmceconf .advmceconf-defaults th {
			padding-bottom: 0.4em;
		}

		.advmceconf .advmceconf-defaults .names {
			text-align: right;
		}

		.advmceconf .advmceconf-defaults td.actions {
			padding: .3em 0 .4em;
		}

		.advmceconf-code-links a {
			text-decoration: none;
		}

		.advmceconf input[type="text"],
		.advmceconf select,
		.advmceconf textarea,
		.advmceconf .button {
			border-color: #aaa;
		}

		.advmceconf input[type="text"]:focus,
		.advmceconf select:focus,
		.advmceconf textarea:focus,
		.advmceconf .button:focus {
			    border-color: #bbb;
			    box-shadow: 0 0 0 2px #bbb;
		}

		@media screen and (max-width: 782px) {
			.advmceconf-table .actions {
				display: none;
			}
		}
	</style>
	<?php
}

add_filter( 'plugin_action_links', 'advmceconf_add_settings_link', 10, 2 );
function advmceconf_add_settings_link( $links, $file ) {
	if ( $file === 'advanced-tinymce-configuration/adv-mce-config.php' && current_user_can( 'manage_options' ) ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			admin_url( 'options-general.php?page=advanced-tinymce-configuration' ),
			__( 'Settings', 'adv-mce-config' )
		);

		$links = (array) $links;
		array_unshift( $links, $settings_link );
	}

	return $links;
}

add_action( 'admin_menu', 'advmceconf_menu' );
function advmceconf_menu() {
	if ( function_exists( 'add_options_page' ) ) {
		add_options_page( 'TinyMCE Config', 'TinyMCE Config', 'manage_options', 'advanced-tinymce-configuration', 'advmceconf_admin' );
	}
}

function advmceconf_admin() {
	global $advmceconf_show_defaults;

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Invalid request' );
	}

	$message = '';
	$options = get_option( 'advmceconf_options', array() );
	$version = get_option( 'advmceconf_version', 0 );

	if ( ! empty( $_POST['advmceconf_save'] ) ) {
		check_admin_referer( 'advmceconf-save-options' );
		$old_options = $options;

		if ( empty( $_POST['advmceconf_options'] ) || ! is_array( $_POST['advmceconf_options'] ) ) {
			$new_options = array();
		} else {
			$new_options = $_POST['advmceconf_options'];
		}

		if ( ! empty( $_POST['advmceconf-new'] ) && isset( $_POST['advmceconf-new-val'] ) ) {
			$new_options[ $_POST['advmceconf-new'] ] = $_POST['advmceconf-new-val'];
		}

		foreach ( $new_options as $key => $val ) {
			$key = preg_replace( '/[^a-z0-9_]+/i', '', $key );
			if ( empty( $key ) )
				continue;

			if ( isset( $_POST[ $key ] ) && empty( $_POST[ $key ] ) ) {
				unset( $options[ $key ] );
				continue;
			}

			$val = trim( stripslashes( $val ) );

			if ( 'true' === $val ) {
				$options[ $key ] = true;
			} elseif ( 'false' === $val ) {
				$options[ $key ] = false;
			} else {
				$options[ $key ] = $val;
			}
		}

		if ( $options != $old_options ) {
			update_option( 'advmceconf_options', $options );
			$message = '<div class="updated fade"><p>' . __( 'Options saved.', 'adv-mce-config' ) . '</p></div>';
		}

		if ( $version < 12 ) {
			update_option( 'advmceconf_version', 12 );
			$version = 12;
		}
	}

	?>
	<div class="wrap advmceconf">
	<h1><?php _e( 'Advanced TinyMCE Settings', 'adv-mce-config' ); ?></h1>
	<?php

	if ( $message ) {
		echo $message;
	}

	$img_src = plugins_url( 'images/', __FILE__ );

	?>
	<div class="advmceconf-wrap">
	<h2><?php _e( 'How-to:', 'adv-mce-config' ); ?></h2>
	<ol>
		<li><?php _e( 'To add a setting to TinyMCE, type the name on the left and the value on the right.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'Do not add quotes around the name or value.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'To remove a setting, delete both name and value.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'To add boolean values type <code>true</code> or <code>false</code>. These strings are converted to boolean when saving.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'You can add JavaScript arrays, objects and functions in the value field.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'When copying settings from the examples in the TinyMCE documentation, make sure you copy only the setting name and value, not the whole example.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'When pasting, make sure both the name and value do not start or end with empty spaces.', 'adv-mce-config' ); ?></li>
		<li><?php _e( 'Both the name and value must follow the JavaScript syntax. Line breaks are only allowed when using arrays or objects.', 'adv-mce-config' ); ?></li>
	</ol>

	<h3><?php _e( 'Example:', 'adv-mce-config' ); ?></h3>
	<p><?php _e( 'To add the <code>block_formats</code> setting from the example in the TinyMCE documentation:', 'adv-mce-config' ); ?></p>
	<p><img width="880" height="170" class="advmceconf-example" src="<?php echo $img_src . 'block-formats-example.png'; ?>" title="<?php esc_attr_e( 'Screenshot of the example.', 'adv-mce-config' ); ?>"></p>
	<p><?php _e( 'you need to enter <code>block_formats</code> in the Option name field and <code>Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3</code> in the Value field:', 'adv-mce-config' ); ?></p>
	<p><img width="880" height="170" class="advmceconf-example" src="<?php echo $img_src . 'block-formats-setting.png'; ?>" title="<?php esc_attr_e( 'Screenshot of the added setting.', 'adv-mce-config' ); ?>"></p>

	<p>
		<?php _e( 'Description of all settings is available in the', 'adv-mce-config' ); ?>
		<a href="https://www.tiny.cloud/docs-4x/" target="_blank" rel="noreferrer noopener">
			<?php _e( 'TinyMCE 4.x documentation', 'adv-mce-config' ); ?>
		</a>.
	</p>
	<p><?php _e( 'Several of the more commonly used settings are:', 'adv-mce-config' ); ?></p>
	<ul class="ul-disc advmceconf-code-links">
		<li><a href="https://www.tiny.cloud/docs-4x/configure/content-formatting/#block_formats" target="_blank" rel="noreferrer noopener"><code>block_formats</code></a></li>
		<li><a href="https://www.tiny.cloud/docs-4x/configure/content-formatting/#style_formats" target="_blank" rel="noreferrer noopener"><code>style_formats</code></a></li>
		<li><a href="https://www.tiny.cloud/docs-4x/configure/content-filtering/#invalid_elements" target="_blank" rel="noreferrer noopener"><code>invalid_elements</code></a></li>
		<li><a href="https://www.tiny.cloud/docs-4x/configure/content-filtering/#extended_valid_elements" target="_blank" rel="noreferrer noopener"><code>extended_valid_elements</code></a></li>
	</ul>
	</div>

	<h2><?php _e( 'Defaults', 'adv-mce-config' ); ?></h2>
	<div class="showhide" style="display: none;">
	<?php

	ob_start();
	wp_editor( '', 'content', array( 'media_buttons' => false, 'quicktags' => false ) );
	ob_end_clean();

	$edit   = esc_html( _x( 'Edit', 'Edit options button', 'adv-mce-config' ) );
	$change = esc_html( __( 'Change', 'adv-mce-config' ) );

	if ( ! empty( $advmceconf_show_defaults ) && is_array( $advmceconf_show_defaults ) ) {
		?>
		<table class="advmceconf-table advmceconf-defaults advmceconf-initial">
		<thead>
			<tr>
				<th class="names"><?php _e( 'Name', 'adv-mce-config' ); ?></th>
				<th class="sep">:</th>
				<th><?php _e( 'Default value', 'adv-mce-config' ); ?></th>
				<th class="actions">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php

		foreach ( $advmceconf_show_defaults as $def_field => $def_value ) {
			if ( is_bool( $def_value ) ) {
				$def_value = $def_value ? 'true' : 'false';
			}

			if ( array_key_exists( $def_field, $options ) ) {
				$tr_class = ' class="highlight"';
				$edit_class = ' changed';
				$button = $edit;
			} else {
				$tr_class = '';
				$edit_class = '';
				$button = $change;
			}

			?>
			<tr<?php echo $tr_class; ?>>
				<td class="names"><?php echo $def_field; ?></td>
				<td class="sep">:</td>
				<td class="values"><?php echo htmlspecialchars( $def_value, ENT_QUOTES ); ?></td>
				<td class="actions"><button type="button" class="button<?php echo $edit_class; ?>" data-optname="<?php echo esc_attr( $def_field ); ?>"><?php echo $button; ?></button></td>
			</tr>
			<?php

		}

		?>
		</tbody>
		</table>
		<?php

		if ( ! empty( $options ) ) {
			$added_options   = array_diff_key( $options, $advmceconf_show_defaults );
			$changed_options = array_intersect_key( $options, $advmceconf_show_defaults );


			if ( ! empty( $added_options ) ) {
				?>
				<h3><?php _e( 'Options added with this plugin', 'adv-mce-config' ) ?></h3>
				<table class="advmceconf-table advmceconf-defaults advmceconf-added">
				<thead>
					<tr>
						<th class="names"><?php _e( 'Name', 'adv-mce-config' ); ?></th>
						<th class="sep">:</th>
						<th><?php _e( 'Value', 'adv-mce-config' ); ?></th>
						<th class="actions">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				<?php

				foreach ( $added_options as $opt_field => $opt_value ) {
					if ( is_bool( $opt_value ) ) {
						$opt_value = $opt_value ? 'true' : 'false';
					}

					?>
					<tr>
						<td class="names"><?php echo $opt_field; ?></td>
						<td class="sep">:</td>
						<td><?php echo htmlspecialchars( $opt_value, ENT_QUOTES ); ?></td>
						<td class="actions"><button type="button" class="button current-option" data-optname="<?php echo esc_attr( $opt_field ); ?>"><?php echo $edit; ?></button></td>
					</tr>
					<?php
				}

				?>
				</tbody>
				</table>
				<?php
			}

			if ( ! empty( $changed_options ) ) {
				?>
				<h3><?php _e( 'Options changed from this plugin', 'adv-mce-config' ) ?></h3>
				<table class="advmceconf-table advmceconf-defaults advmceconf-changed">
				<thead>
					<tr>
						<th class="names"><?php _e( 'Name', 'adv-mce-config' ); ?></th>
						<th class="sep">:</th>
						<th><?php _e( 'Value', 'adv-mce-config' ); ?></th>
						<th class="actions">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				<?php

				$edit = esc_attr( _x( 'Edit', 'Edit options button', 'adv-mce-config' ) );

				foreach ( $changed_options as $opt_field => $opt_value ) {
					if ( is_bool( $opt_value ) ) {
						$opt_value = $opt_value ? 'true' : 'false';
					}

					?>
					<tr>
						<td class="names"><?php echo $opt_field; ?></td>
						<td class="sep">:</td>
						<td><?php echo htmlspecialchars( $opt_value, ENT_QUOTES ); ?></td>
						<td class="actions"><button type="button" class="button current-option" data-optname="<?php echo esc_attr( $opt_field ); ?>"><?php echo $edit; ?></button></td>
					</tr>
					<?php
				}

				?>
				</tbody>
				</table>
				<?php
			}
		}
	}

	?>
	</div>

	<p>
		<button type="button" class="button showhide"><?php _e( 'Show the default TinyMCE settings', 'adv-mce-config' ); ?></button>
		<button type="button" class="button showhide" style="display: none;"><?php _e( 'Hide the default TinyMCE settings', 'adv-mce-config' ); ?></button>
	</p>

	<form method="post" action="" class="advmceconf-form">
	<h2><?php _e( 'Edit options', 'adv-mce-config' ); ?></h2>
	<table class="advmceconf-table advmceconf-set">
	<?php

	if ( empty( $options ) ) {
		?>
		<tr><td><?php _e( 'No options have been added yet. After adding a new option, it will be available here for editing.', 'adv-mce-config' ); ?></td></tr>
		<?php
	} else {
		$remove = esc_attr( __( 'Clear', 'adv-mce-config' ) );

		?>
		<thead>
			<tr>
				<th class="names"><?php _e( 'Name', 'adv-mce-config' ); ?></th>
				<th class="values"><?php _e( 'Value', 'adv-mce-config' ); ?></th>
				<th class="actions">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php

		foreach ( $options as $field => $value ) {
			$field = esc_attr( $field );
			$id = "advmceconf_option-{$field}";
			$name = "advmceconf_options[{$field}]";

			if ( is_bool( $value ) ) {
				$value = $value ? 'true' : 'false';
			}

			?>
			<tr>
				<td class="names">
					<input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $field; ?>" spellcheck="false">
				</td>
				<td class="values">
					<textarea name="<?php echo $name; ?>" id="<?php echo $id; ?>" spellcheck="false"><?php echo htmlspecialchars( $value, ENT_NOQUOTES ); ?></textarea>
				</td>
				<td class="actions">
					<button type="button" class="button remove"><?php echo $remove; ?></button>
				</td>
			</tr>
			<?php
		}
	}

	?>
	</tbody>
	</table>

	<h2><?php _e( 'Add new option', 'adv-mce-config' ); ?></h2>
	<table class="advmceconf-table advmceconf-set">
	<thead>
		<tr>
			<th class="names"><?php _e( 'Name', 'adv-mce-config' ); ?></th>
			<th class="values"><?php _e( 'Value', 'adv-mce-config' ); ?></th>
			<th class="actions">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr id="advmceconf-new-row">
			<td class="names">
				<input type="text" name="advmceconf-new" id="advmceconf-new" value="" spellcheck="false">
			</td>
			<td class="values">
				<textarea name="advmceconf-new-val" id="advmceconf-new-val" spellcheck="false"></textarea>
			</td>
			<td class="actions">&nbsp;</td>
		</tr>
	</tbody>
	</table>


	<p class="submit">
		<?php wp_nonce_field( 'advmceconf-save-options' ); ?>
		<input type="submit" value="<?php esc_attr_e( 'Save Changes', 'adv-mce-config' ); ?>" class="button-primary" name="advmceconf_save" />
	</p>
	</form>
	</div>

	<script type="text/javascript">
	jQuery( document ).ready( function( $ ) {

		function scrollToRow( row ) {
			$( '.advmceconf-set tr' ).removeClass( 'highlight' );

			if ( row.length ) {
				row.addClass( 'highlight' );
				row[0].scrollIntoView( {
					behavior: 'smooth',
					block: 'center',
				} );
			}
		}

		$( 'button.showhide' ).on( 'click', function() {
			$( 'div.showhide, button.showhide' ).toggle();
		});


		$( '.advmceconf-initial button' ).on( 'click', function( event ) {
			var target     = $( event.target );
			var optionName = target.data( 'optname' );
			var row;

			if ( target.hasClass( 'changed' ) ) {
				scrollToRow( $( '#' + optionName ).closest( 'tr' ) );
			} else {
				row = target.closest( 'tr' );
				$( '#advmceconf-new' ).val( row.find( 'td.names' ).text() );
				$( '#advmceconf-new-val' ).val( row.find( 'td.values' ).text() );

				scrollToRow( $( '#advmceconf-new-row' ) );
			}
		});


		$( '.advmceconf-added button, .advmceconf-changed button' ).on( 'click', function( event ) {
			var optionName = $( event.target ).data( 'optname' );

			scrollToRow( $( '#' + optionName ).closest( 'tr' ) );
		});

		$( '.advmceconf-set button' ).on( 'click', function( event ) {
			var target = $( event.target );

			if ( target.hasClass( 'remove' ) ) {
				target.closest( 'tr' ).find( 'input[type="text"], textarea' ).val( '' );
			}
		});
	});
	</script>
	<?php
}
