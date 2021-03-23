<?php
/*
Plugin Name: Advanced Custom Fields options import/export
Plugin URI: http://thewpdev.org/
Description: Allows to migrate site options
Author: Oleh Odeshchak
Author URI: https://thewpdev.org/
Text Domain: acfim
Version: 1.0.4
*/

if ( ! defined( 'ABSPATH' ) ) { return; } // Exit if accessed directly

if ( ! class_exists( 'ACFIM_plugin' ) ) {
	class ACFIM_plugin {

		private $plugin_url;

		private $plugin_path;

		private $plugin_version;


		function __construct() {
			$this->plugin_url 	  = plugins_url( '', __FILE__ );
			$this->plugin_path 	  = plugin_dir_path( __FILE__ );
			$this->plugin_version = '1.0.0';
			
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_init', array( $this, 'import_options' ) );
			add_action( 'admin_init', array( $this, 'exports_options' ) );
		}


		public function admin_menu() {
			$page_hook_suffix = add_submenu_page( 'tools.php', esc_html__( 'ACF import/export', 'acfim-plugin' ), esc_html__( 'ACF import/export', 'acfim-plugin' ), 'manage_options', 'acf-import-export', array($this, 'admin_page' ) ); 
			add_action( 'admin_print_scripts-' . $page_hook_suffix, array( $this, 'admin_enqueue_scripts' ) );
		}


		public function admin_enqueue_scripts() {	
			wp_enqueue_style( 'acfim-styles', $this->plugin_url . '/css/styles.css', array(), $this->plugin_version );
		}


		public function admin_page() {
			$plugin_url = menu_page_url( 'acf-import-export', false );
			?>
			<div class="wrap">
				<h2><?php esc_html_e( 'ACF options import/export', 'acfim-plugin' ); ?></h2>

				<div class="acfim-container">
					<?php if ( ! function_exists( 'get_field' ) ) { ?>
						<p><?php esc_html_e( 'Please install Advanced Custom Fields plugin', 'acfim-plugin' ); ?></p>
					<?php } else { ?>
						<div class="acfim-left">
							<div class="acfim-section">
								<h3><?php esc_html_e( 'Export options', 'acfim-plugin' ); ?></h3>
								<a href="<?php echo $plugin_url ?>&export" class="button"><?php esc_html_e( 'Run Export', 'acfim-plugin' ); ?></a>
							</div>
							<div class="acfim-section">
								<form method="post" enctype="multipart/form-data" action="<?php echo $plugin_url ?>&import">						
									<h3><?php esc_html_e( 'Import options', 'acfim-plugin' ); ?></h3>
									<input type="file" name="backup" required />
									<?php submit_button( esc_html__( 'Upload file and import', 'acfim-plugin' ) ); ?>
									<?php if ( isset( $_GET['imported'] ) && $_GET['imported'] == 1 ): ?>
										<p><?php esc_html_e( 'Options successfully imported.', 'acfim-plugin' ); ?></p>
									<?php endif ?>
									<?php if ( isset( $_GET['imported'] ) && $_GET['imported'] == 2 ): ?>
										<p><?php esc_html_e( 'Some error happened during the upload process.', 'acfim-plugin' ); ?></p>
									<?php endif ?>
									<p class="acfim-info"><?php esc_attr_e( 'Your current options will be overwritten.', 'acfim-plugin' ); ?></p>
								</form>
							</div>
						</div>
						<div class="acfim-right">
							<h2><?php esc_html_e( 'Need help with customization?', 'acfim-plugin' ); ?></h2>
							<ul class="ywca-services">
								<li><?php esc_html_e( 'themes customizations;', 'acfim-plugin' ); ?></li>
								<li><?php esc_html_e( 'plugins customizations;', 'acfim-plugin' ); ?></li>
								<li><?php esc_html_e( 'custom development.', 'acfim-plugin' ); ?></li>
							</ul>
							<h3><?php esc_html_e( 'Contacts:', 'acfim-plugin' ); ?></h3>
							<ul>
								<li>
									<i aria-hidden="true" class="dashicons dashicons-external"></i>
									<a href="<?php echo esc_url( 'http://thewpdev.org/' ); ?>"><?php esc_html_e( 'My portfolio', 'acfim-plugin' ); ?></a>
								</li>
								<li>
									<i aria-hidden="true" class="dashicons dashicons-external"></i>
									<a href="<?php echo esc_url( 'mailto:olezhyk5@gmail.com' ); ?>"><?php esc_html_e( 'Email', 'acfim-plugin' ); ?></a>
								</li>
							</ul>
						</div>		
					<?php } ?>
				</div>
			</div>
			<?php
		}


		public function import_options() {
			if ( isset( $_GET['import'] ) && isset( $_GET['page'] ) && $_GET['page'] == 'acf-import-export' ) {
				$plugin_url = menu_page_url( 'acf-import-export', false );
				if ( ! empty( $_FILES['backup'] ) ) {
					$target_dir  = $this->plugin_path . 'temp/';
					$target_file = $target_dir . basename( $_FILES['backup']['name'] );
					if ( move_uploaded_file( $_FILES['backup']['tmp_name'], $target_file ) ) {
						WP_Filesystem();
						
						$unzip = unzip_file( $target_file, $target_dir );
						unlink( $target_file );

						if ( is_wp_error( $unzip ) || ! file_exists( $this->plugin_path . 'temp/images.json' ) || ! file_exists( $this->plugin_path . '/temp/options.json' ) ) {
							wp_redirect( $plugin_url . '&imported=2' );
							die();
						}

						$json 	  = file_get_contents( $this->plugin_path . 'temp/options.json' );
						$options  = json_decode( $json, true );
						$img_json = file_get_contents( $this->plugin_path . 'temp/images.json' );
						$img_data = array();

						if ( ! empty( $img_json ) ) {
							$img_data = json_decode( $img_json, true );
						}

						if ( ! empty( $img_data ) ) {
							$upload_dir = wp_upload_dir();
							require_once ABSPATH . 'wp-admin/includes/image.php';
							foreach ( $img_data as $key => $image ) {

								$image_url  = $this->plugin_path . 'temp/' . $image['name'];
								$image_data = file_get_contents( $image_url );
								$filename   = basename( $image_url );

								if ( wp_mkdir_p( $upload_dir['path'] ) ) {
									$file = $upload_dir['path'] . '/' . $filename;
								} else {
									$file = $upload_dir['basedir'] . '/' . $filename;
								}

								file_put_contents( $file, $image_data );

								$wp_filetype = wp_check_filetype( $filename, null );

								$attachment = array(
									'post_mime_type' => $wp_filetype['type'],
									'post_title' 	 => sanitize_file_name( $filename ),
									'post_content' 	 => '',
									'post_status' 	 => 'inherit'
								);

								$attach_id = wp_insert_attachment( $attachment, $file );
								$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
								wp_update_attachment_metadata( $attach_id, $attach_data );

								$img_data[ $key ]['new_id'] = $attach_id;
							}
						}
						
						foreach ( $options as $key => $option ) {
							if ( ( $option['type'] == 'image' || $option['type'] == 'gallery' ) && ! empty( $img_data ) ) {
								if ( $option['type'] == 'image' ) {
									$options[ $key ]['value'] = $img_data[ $option['value'] ]['new_id'];
								}
								
								if ( $option['type'] == 'gallery' ) {
									foreach ( $options[ $key ]['value'] as $key2 => $value) {
										$options[ $key ]['value'][ $key2 ] = $img_data[ $options[ $key ]['value'][ $key2 ] ]['new_id'];
									}
								}
							}

							update_option( '_options_' . $key, $options[ $key ]['key'], 'no' );
							update_option( 'options_' . $key, $options[ $key ]['value'], 'no' );
						}

						$files = glob( $this->plugin_path . 'temp/*' );
						foreach( $files as $file ) {
							if( is_file( $file ) ){
								unlink( $file );
							}
						}
					}
				}
				// unzip_file()
				wp_redirect( $plugin_url . '&imported=1' );
				die();
			}
		}
		
		
		public function exports_options() {
			if ( isset( $_GET['export'] ) && isset( $_GET['page'] ) && $_GET['page'] == 'acf-import-export' ) {	
				$plugin_url = menu_page_url( 'acf-import-export', false );
				$opts = array();
				$imgs = array();

				global $wpdb;
				$keys = $wpdb->get_col($wpdb->prepare(
					"SELECT option_value FROM $wpdb->options WHERE option_name LIKE %s",
					'_options_%' 
				));

				foreach ($keys as $key => $option) {
					$opt_data = get_field_object($option, 'options');
					if ( is_array( $opt_data ) ) {
						$option_value = get_option( 'options_' . $opt_data['_name'] );

						if ( $opt_data['type'] == 'repeater' ) {
							foreach ( $opt_data['value'] as $opt_key => $opt_item ) {
								foreach ( $opt_item as $elem_key => $elem_item ) {
									$repeater_key = $opt_data['_name'] . '_' . $opt_key . '_' . $elem_key;
									$repeater_opt_key = get_option( '_options_' . $repeater_key );
									$repeater_opt_val = get_option( 'options_' . $repeater_key );

									$opts[ $repeater_key ] = array(
										'key' => $repeater_opt_key,
										'type' => $elem_key,
										'value' => $repeater_opt_val
									);
								}
							}
						}

						$opts[ $opt_data['_name'] ] = array(
							'key' => $opt_data['key'],
							'type' => $opt_data['type'],
							'value' => $option_value
						);

						if ( ! empty( $option_value ) ) {
							if ( $opt_data['type'] == 'image' ) {
								$imgs[ $option_value ] = array('old_id' => $option_value );
							}
							if ( $opt_data['type'] == 'gallery' && is_array( $option_value ) ) {
								foreach ( $option_value as $img ) {
									$imgs[ $img ] = array('old_id' => $img );
								}
							}
						}
					}
				}

				$json = '';
				if ( ! empty( $imgs ) ) {
					foreach ($imgs as $key => $img) {
						$image_data = wp_get_attachment_image_src( $key, 'full' );
						$parts  	= explode('uploads', $image_data[0] );
						$parts2 	= explode('/', $image_data[0] );

						copy ( WP_CONTENT_DIR . '/uploads' . $parts[1], $this->plugin_path . 'temp/' . end( $parts2 ) );
						$imgs[ $key ]['name'] = end( $parts2 );
					}
					$json = json_encode( $imgs );
					
				}
				file_put_contents( $this->plugin_path . 'temp/images.json', $json );
				
				$json = json_encode( $opts );
				file_put_contents( $this->plugin_path . 'temp/options.json', $json );

				$zip_file_name        = 'acf_options_dump_' . time() . '.zip';
				$zip_file_path        = sys_get_temp_dir() . '/' . $zip_file_name;
				$plugin_or_theme_path = $this->plugin_path . 'temp';
				$files                = $this->get_files( $plugin_or_theme_path );
				$exclude_path         = $plugin_or_theme_path;
				$args                 = array( 'zip_file_path' => $zip_file_path, 'exclude_path' => $exclude_path );
				if ( $this->create_zip( $args, $files ) ) {
					$this->send_file( $zip_file_name, $zip_file_path, $files );
				}
			}
		}


		public function create_zip( $args, $files ) {
			if ( file_exists( $args['zip_file_path'] ) ) {
				unlink( $args['zip_file_path'] );
			}
			$zip_library = get_option( 'alg_download_plugins_dashboard_zip_library', ( class_exists( 'ZipArchive' ) ? 'ziparchive' : 'pclzip' ) );
			switch ( $zip_library ) {
				case 'pclzip':
					return $this->create_zip_pclzip( $args, $files );
				default: // 'ziparchive':
					return $this->create_zip_ziparchive( $args, $files );
			}
		}


		public function create_zip_pclzip( $args, $files ) {
			require_once( ABSPATH . 'wp-admin/includes/class-pclzip.php' );
			$zip = new PclZip( $args['zip_file_path'] );
			if ( 0 == $zip->create( $files, PCLZIP_OPT_REMOVE_PATH, $args['exclude_path'] ) ) {
				$this->last_error = sprintf( '%s %s.', '<code>PclZip</code>', $zip->errorInfo( true ) );
				return false;
			}
			return true;
		}


		public function create_zip_ziparchive( $args, $files ) {
			$zip = new ZipArchive();
			if ( true !== ( $result = $zip->open( $args['zip_file_path'], ZipArchive::CREATE | ZipArchive::OVERWRITE ) ) ) {
				$this->last_error = sprintf( __( '%s can not open a new zip archive (error code %s).', 'download-plugins-dashboard' ),
					'<code>ZipArchive</code>', '<code>' . $result . '</code>' );
				return false;
			}
			$exclude_from_relative_path = strlen( $args['exclude_path'] ) - 1;
			foreach ( $files as $file_path ) {
				$zip->addFile( $file_path, substr( $file_path, $exclude_from_relative_path ) );
			}
			$zip->close();
			return true;
		}


		public function send_file( $zip_file_name, $zip_file_path, $files ) {
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename=' . urlencode( $zip_file_name ) );
			header( 'Content-Type: application/download' );
			header( 'Content-Description: File Transfer' );
			header( 'Content-Length: ' . filesize( $zip_file_path ) );
			flush();
			if ( false !== ( $fp = fopen( $zip_file_path, 'r' ) ) ) {
				while ( ! feof( $fp ) ) {
					echo fread( $fp, 65536 );
					flush();
				}
				fclose( $fp );
				unlink( $zip_file_path );
				foreach ($files as $key => $file) {
					unlink($file);
				}
				die();
			} else {
				die( __( 'Unexpected error', 'download-plugins-dashboard' ) );
			}
		}


		public function get_files( $plugin_or_theme_path ) {
			$files       = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $plugin_or_theme_path ), RecursiveIteratorIterator::LEAVES_ONLY );
			$files_paths = array();
			foreach ( $files as $name => $file ) {
				if ( ! $file->isDir() ) {
					$file_path = str_replace( '\\', '/', $file->getRealPath() );
					$files_paths[] = $file_path;
				}
			}
			return $files_paths;
		}
	}
}
new ACFIM_plugin();