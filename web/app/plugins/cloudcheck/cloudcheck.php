<?php
/**
 * Plugin Name: Cloudcheck Integration
 * Plugin URI: https://wordpress.org/plugins/cloudcheck_integration/
 * Description: Integration with cloudcheck service for electronic identification verification. Only for New Zealand and Australia
 * Version: 1.0.0
 * Author: Roundkick.Studio, eurohlam
 * Author URI: https://roundkick.studio
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * License: GPLv2 or later

Cloudcheck Integration is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Cloudcheck Integration is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Cloudcheck Integration. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
 */

if (!defined('ABSPATH')) exit;

include_once 'class-cloudcheck-integration.php';
include_once 'cloudcheck-shortcodes.php';

define('CLOUDCHECK_INT_VERSION', '1.0.0');

if (!class_exists('WP_Cloudcheck_Int')) {
	class WP_Cloudcheck_Int {
		/**
		* Plugin's options
		*/
	 	private $options_group = 'cloudcheck_int';
	 	private $url_option = 'cloudcheck_url';
		private $accessKey_option = 'cloudcheck_access_key';
		private $secret_option = 'cloudcheck_secret';

		private $db_table_name = 'cc_message_log';
		private $pdf_folder_name = 'cloudcheck_int';

		static function activate() {
		   	global $wpdb;

 			$table_name = $wpdb->prefix . 'cc_message_log';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  endpoint varchar(20) NOT NULL,
			  request longtext CHARACTER SET utf8 NOT NULL,
			  response longtext CHARACTER SET utf8 NOT NULL,
			  filepath varchar(50),
			  PRIMARY KEY (id)
			) DEFAULT CHARSET=utf8;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			$dir_path = wp_upload_dir()['basedir'] . '/cloudcheck_int';
			if(!file_exists($dir_path)) wp_mkdir_p($dir_path);
        }

		static function deactivate() {
			//nothing so far
		}

		static function uninstall() {
		   	global $wpdb;
			delete_option( 'cloudcheck_url' );
			delete_option( 'cloudcheck_access_key' );
			delete_option( 'cloudcheck_secret' );

 			$table_name = $wpdb->prefix . 'cc_message_log';
			$sql = "DROP TABLE IF EXISTS $table_name";

			$wpdb->query( $sql );
        }

		function __construct() {
			add_action('admin_menu', array( $this, 'cloudcheck_menu'));
			add_action('wp_ajax_cloudcheck_send_request', array( $this,'cloudcheck_send_request'));
            add_action('wp_ajax_cloudcheck_send_request_ss', array( $this,'cloudcheck_send_request_ss'));
            add_action('wp_ajax_cloudcheck_send_email', array( $this,'send_pdf_by_email'));
			add_action('init', 'cloudcheck_shortcodes_init');
			add_action('wp_enqueue_scripts', array( $this,'cloudcheck_load_assets'));
		}

		function cloudcheck_load_assets () {
//		    echo '<script type="text/javascript" src="/app/plugins/cloudcheck/js/jquery-3.5.1.min.js"></script>';
//            echo '<script type="text/javascript" src="/app/plugins/cloudcheck/js/datepicker.min.js"></script>';
//            echo '<script type="text/javascript" src="/app/plugins/cloudcheck/js/dobpicker.js"></script>';
//            echo '<script type="text/javascript" src="/app/plugins/cloudcheck/js/cloudcheck.js"></script>';
//            wp_enqueue_style( 'swiper', get_theme_file_uri( '/asssets/css/swiper-bundle.min.css' ));
//        swiper slider scripts

            if( is_page( array( 'checkout' ))) {
                var_dump('checkout');

                wp_enqueue_script( 'cloudcheck-jquery', plugin_dir_url(__FILE__).'js/jquery-3.5.1.min.js' , array(), '1', true );
                wp_enqueue_script( 'datepicker', plugin_dir_url(__FILE__).'/js/datepicker.min.js' , array('jquery'), '1', true );
                wp_enqueue_script( 'dobpicker', plugin_dir_url(__FILE__).'/js/dobpicker.js' , array('jquery'), '1', true );
                wp_enqueue_script( 'cloudcheck', plugin_dir_url(__FILE__).'/js/cloudcheck.js' , array('jquery'), '1', true );
            } else {
                var_dump('not checkout');
            }

        }


        /**
         * Send MRZ request to cloudcheck
         */

        function cloudcheck_send_request_ss() {

            $accessKey = get_option($this->accessKey_option);
            $secret = get_option($this->secret_option);
            $url = get_option($this->url_option);
            $path = $_POST['path'];
            $data = array("reference"=> "MRZ Check 101", "consent"=> "Yes");
            $data = json_encode($data);
            $file = $_POST['file'];
            $image_object = $_POST['image_object'];
            $nonce = $_POST['nonce'];
            $timestamp = $_POST['timestamp'];
            $signature = $_POST['signature'];
//            $filepath = ABSPATH . 'wp-content/uploads/cloud/' .   $file;
//            $new_file = new CURLFile($filepath );
//            $new_file = new CURLFile($filepath );


            ## Транслитирация кирилических символов
            function cyrillic_translit( $title ){
                $iso9_table = array(
                    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G',
                    'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
                    'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
                    'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
                    'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
                    'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
                    'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
                    'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '',
                    'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
                    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
                    'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
                    'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
                    'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
                    'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
                    'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
                    'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
                    'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '',
                    'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
                );

                $name = strtr( $title, $iso9_table );
                $name = preg_replace('~[^A-Za-z0-9\'_\-\.]~', '-', $name );
                $name = preg_replace('~\-+~', '-', $name ); // --- на -
                $name = preg_replace('~^-+|-+$~', '', $name ); // кил - на концах

                return $name;
            }

            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($_FILES['file']['tmp_name']);
            $error_image = !in_array($detectedType, $allowedTypes);

            if (!$error_image) {
                // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

//                $uploaddir = ABSPATH . 'wp-content/uploads/cloud'; //
                $uploaddir = WP_CONTENT_DIR . '/uploads/cloud'; //
//

                // cоздадим папку если её нет
                if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
                $files      = $_FILES; // полученные файлы






                // переместим файлы из временной директории в указанную
//            $file_name = cyrillic_translit(  $files['file']['name']);
//
                $file_name = cyrillic_translit($files['file']['name']);
                $tmp_name = $files['file']['tmp_name'];


                if(move_uploaded_file( $tmp_name, "$uploaddir/$file_name" )) {
                    $filepath = realpath( "$uploaddir/$file_name");
                    $new_file = new CURLFile($filepath );
                } else {
                    echo 'File upload error';
                }
            }

            $mt = explode(' ', microtime());
            $time = ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));

            // Set up some dummy parameters. Sort alphabetically.
            $parameterMap = array(
                'key' => $accessKey,
                'nonce' => $time,
                'timestamp' => $time,
                'data' => $data,
                'file' => $filepath
            );
            ksort($parameterMap);

            // Build the signature string from the parameters.
            $signatureString = $path;
            foreach ($parameterMap as $key => $value) {
                if ($key === 'signature') {
                    continue;
                }
                $signatureString .= "$key=$value;";
            }
            // Create the HMAC SHA-256 Hash from the signature string.
            $signatureHex = hash_hmac('sha256', $signatureString, $secret, false);

//            print_r($signatureString);
//            echo '<br>';
            $curl = curl_init();
            $params = array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => array('Content-type: multipart/form-data'),
                CURLOPT_URL => 'https://api.cloudcheck.co.nz/mrz/runcheck/',
                CURLOPT_PORT => 443,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_VERBOSE => 1,
                CURLOPT_POSTFIELDS => array(
                    'key' => $accessKey,
                    'nonce' => $time,
                    'timestamp' => $time,
                    'signature' => $signatureHex,
                    'data' => $data,
                    'file'=> $new_file
                )
            );
            curl_setopt_array($curl, $params);
            $result = null;

            try {
                $result = curl_exec($curl);
                echo $result;
                if (!$result) {
                    $errno = curl_errno($curl);
                    $error = curl_error($curl);
                    error_log($error);
                    echo $error;
                }

                curl_close($curl);
            } catch (HttpException $ex) {
                error_log($ex);
            }

            wp_delete_file($filepath);
            wp_die();
        }

		/**
		* Send request to cloudcheck
		*/
		function cloudcheck_send_request() {
		   	global $wpdb;

			$accessKey = get_option($this->accessKey_option);
			$secret = get_option($this->secret_option);
			$url = get_option($this->url_option);
			$request = stripcslashes($_POST['request']);
			$path = $_POST['path'];

			if (!empty($accessKey) && !empty($secret) && !empty($url) && !empty($path)) {
				$cloudcheckInt = new Cloudcheck_Integration();
				$cloudcheckRequest = $cloudcheckInt->prepare_cloudcheck_parameters($accessKey, $secret, $path, $request);
				$result = $cloudcheckInt->send_request($url . $path, $cloudcheckRequest);

				$wpdb->insert(
		 			$wpdb->prefix . $this->db_table_name,
					array(
					'time' => current_time( 'mysql' ),
					'endpoint' => $path,
					'request' => json_encode($cloudcheckRequest),
					'response' => $result,
					)
				);

				echo $result;
			} else {
				error_log('Cloudcheck Integration plugin error: empty one or several required parameters - accessKey, secret, url or path. Please check settings of Cloudcheck Integration plugin');
				echo '{"Cloudcheck Integration plugin error": "empty one or several required parameters - accessKey, secret, url or path"}';
			}
			wp_die();
		}

		function send_pdf_by_email() {
	        $subject = 'Electronic Verification Identification Report';
	        $body = 'Please refer to the attached PDF for more details';
	        $headers = array('Content-Type: text/html; charset=UTF-8');
			$filepath = $_POST['filepath'];
			$emailList = $_POST['emaillist'];

	        wp_mail( $emailList, $subject, $body, $headers, $filepath );

			echo '{ "result" : "success" }';
			wp_die();
	    }

		function cloudcheck_settings() {
			register_setting( $this->options_group, $this->url_option );
			register_setting( $this->options_group, $this->accessKey_option );
			register_setting( $this->options_group, $this->secret_option );
		}

		function cloudcheck_menu() {
		  	add_action('admin_init', array( $this,'cloudcheck_settings'));
			add_options_page('Cloudcheck Integration', 'Cloudcheck Integration', 'manage_options', 'cloudcheck-int', array( $this,'cloudcheck_options_page'));
		}


		/**
		* Admin options page
		*/
		function cloudcheck_options_page() {
			?>
		    <div class="wrap">
		        <h2>Cloudcheck Integration</h2>
		        <p>Cloudcheck is an electronic identification verification (EV) tool that allows you to verify the identity of your customer using biometric checks, Australian and New Zealand data sources and global watchlists in one easy step. More details about
		            <a href="https://www.verifidentity.com/cloudcheck/">Cloudcheck</a></p>
		        <p>Version: <?php echo CLOUDCHECK_INT_VERSION ?></p>
		        <div>
		            <form method="post" action="options.php">
		            <?php
						settings_fields($this->options_group);
						do_settings_sections($this->options_group);
					?>
						<table class="form-table">
			            	<tr valign="top">
								<th scope="row">Cloudcheck URL</th>
								<td>
									<input type="url" class="regular-text" name="cloudcheck_url" value="<?php echo get_option($this->url_option) ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Cloudcheck Access Key</th>
								<td>
									<input type="text" class="regular-text" name="cloudcheck_access_key" value="<?php echo get_option($this->accessKey_option) ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Cloudcheck Secret Key</th>
								<td>
									<input type="text" class="regular-text" name="cloudcheck_secret" value="<?php echo get_option($this->secret_option) ?>" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="page_options" value="cloudcheck_url,cloudcheck_access_key,cloudcheck_secret" />
						<p class="submit">
							<input class="button-primary" type="submit" value="Save Changes" />
						</p>
					</form>
				</div>

                <!--CLOUDCHECK VERIFICATION FORMS-->
                <div class="cloudcheck">
                    <h2>User verification:</h2>
                    <div class="cloudcheck-region-box">
                        <div class="form-group col-xs-12 floating-label-form-group controls ml-3">
                            <label>User's Email</label>
                            <input id="user_id" class="form-control name form-input2" required type="text" placeholder="Email" />
                        </div>
                    </div>

                    <?php if (get_field('cloudcheck', 'option')) : ?>
                        <div class="cloudcheck-region-body">
                            <?php foreach(get_field('cloudcheck', 'option') as $key => $cloudcheck) : ?>
                                <div  data-region="<?php echo sanitize_title($cloudcheck['country']); ?>" class="cloudcheck-region-box <?php  echo ($key == 0 ?  ' show ' :''); ?>">
                                    <?php echo $cloudcheck['body']; ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>
                    <div id="success" class="success"></div>
                </div><!--CLOUDCHECK VERIFICATION FORMS-->
			</div>
			<?php
		}

	} //end class WP_Cloudcheck_Int
}


if (class_exists('WP_Cloudcheck_Int')) {
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_Cloudcheck_Int', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Cloudcheck_Int', 'deactivate'));
	register_uninstall_hook(__FILE__, array('WP_Cloudcheck_Int', 'uninstall'));
	// instantiate the plugin class
	$wp_plugin = new WP_Cloudcheck_Int();
}
?>
