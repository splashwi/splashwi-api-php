<?php
/**
 * Class SplashAPI
 *
 * This class is capable of connecting and controlling to the Splash-Wi API
 * of the Versions v3.0 and up of the webinterface. For more information take
 * a quick look at the homepage listed below. This script is licensed under
 * GNU GPL v3. Therefor you are allowed to modify it and use it for private and
 * commercial use cases as long as you do not claim, that the software was written
 * by you!
 *
 * @author MenkMedia
 * @version v1.0
 * @compatibility Splash-Wi v3.0+
 * @homepage https://webinterface.us/
 * @license GNU GPL v3 (See https://www.gnu.org/licenses/gpl-3.0.de.html)
 */
class SplashAPI {
    private $installationurl;
    private $debug;

    public function __construct($url, $debug = false)
    {
        $this->installationurl = $url;
        $this->debug = $debug;
        if($this->debug) {
            echo "<h1>Debug Mode!</h1>";
        }
    }
    public function execute($array) {
        $return = $this->exec($array);
        if(!empty($return)) {
            return $return;
        } else {
            if($this->debug) {
                echo "<pre>No result given! Return: false</pre>";
            }
            return false;
        }
    }
    function executeCurl($arrOptions) {
        $mixCH = curl_init();

        foreach ($arrOptions as $strCurlOpt => $mixCurlOptValue) {
            curl_setopt($mixCH, $strCurlOpt, $mixCurlOptValue);
        }

        $mixResponse = curl_exec($mixCH);
        curl_close($mixCH);
        if($this->debug) {
            echo "<span style='font-weight: bold;'>Mix Response:</span><pre>"; print_r($mixResponse); echo "</pre>";
        }
        return $mixResponse;
    }
    function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {
        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }
        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                $this->http_build_query_for_curl( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
        return $new;
    }
    public function exec($arr) {
        if($this->debug) {
            echo "<span style='font-weight: bold;'>Request:</span><pre>"; print_r($arr); echo "</pre>";
        }

        $requestType = 'POST';
        $post = $this->http_build_query_for_curl($arr);
        $postData = http_build_query($post);

        $mixResponse = $this->executeCurl(array(
            CURLOPT_URL => $this->installationurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS  => $postData
        ));

        $response = json_decode($mixResponse);

        if($this->debug) {
            echo "<span style='font-weight: bold;'>Result:</span><pre>"; print_r($response); echo "</pre>";
        }

        return $response;
    }
}