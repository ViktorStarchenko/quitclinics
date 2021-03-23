<?php
if (!defined('ABSPATH')) exit;

class Cloudcheck_Integration {

  public function __construct() {
  }

  public function milliseconds() {
      date_default_timezone_set("Pacific/Auckland");
      $mt = explode(' ', microtime());
      return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
  }

  public function prepare_cloudcheck_parameters($accessKey, $secret, $path, $data) {

      $nonce = $this->milliseconds();
      $timestamp = $this->milliseconds();

      $dataKeyName = 'data';
      if ($path == '/verify/pdf') {
          $dataKeyName = 'reference';
      }

      // Set up some dummy parameters. Sort alphabetically.
      $parameterMap = array(
          'key' => $accessKey,
          'nonce' => $nonce,
          'timestamp' => $timestamp,
          $dataKeyName => $data
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

      $resultMap = array(
          'key' => $accessKey,
          'nonce' => $nonce,
          'timestamp' => $timestamp,
          $dataKeyName => $data,
          'signature' => $signatureHex
      );

      return $resultMap;
  }

  public function send_request($url, $requestParams) {
      $curl = curl_init();
      $isPDF = false;
      if (strpos($url, 'pdf') !== false) {
          $isPDF = true;
      }
      $params = array(
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_HTTPHEADER => array('Content-type: application/x-www-form-urlencoded'),
              CURLOPT_URL => $url,
              CURLOPT_PORT => 443,
              CURLOPT_POST => !$isPDF, //if pdf then method=GET otherwise method=POST
              CURLOPT_SSL_VERIFYHOST => false,
              CURLOPT_VERBOSE => 1,
              CURLOPT_POSTFIELDS => http_build_query($requestParams)
          );
      curl_setopt_array($curl, $params);
      $result = null;
      try {
          $result = curl_exec($curl);
          if (!$result) {
              $errno = curl_errno($curl);
              $error = curl_error($curl);
              error_log($error);
          }
          if ($isPDF) {
              $result = $this->save_pdf_as_file($result);
          }
          curl_close($curl);
      } catch (HttpException $ex) {
            error_log($ex);
      }
      return $result;
  }

  private function save_pdf_as_file ($file) {
      $upload = wp_upload_dir();
      $path = $upload['path'];
      $url = $upload['url'];
      if(file_exists($upload['basedir'] . '/cloudcheck_int')) {
          $path = $upload['basedir'] . '/cloudcheck_int';
          $url = $upload['baseurl'] . '/cloudcheck_int';
      }
      //wp_mkdir_p($upload['basedir'] . '/cloudcheck');
      $filename = $this->milliseconds() . '.pdf';
      file_put_contents($path . '/' . $filename, $file);
      $result = '{"pdfUrl" : "' . $url . '/' . $filename .'",'.
                 '"pdfPath" : "' . $path . '/' . $filename . '"}';
      return $result;
  }

}

?>
