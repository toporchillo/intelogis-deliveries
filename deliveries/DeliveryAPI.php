<?php
abstract class DeliveryAPI {
    protected $base_url;
    protected $login;
    protected $password;

    public $last_url;
    public $last_request;
    public $last_response;

    public $api_error = '';

    protected $curl_params = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 3,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    );

    public function __construct($base_url, $login, $password)
    {
        $this->base_url = $base_url;
        $this->login = $login;
        $this->password = $password;
    }

    public function apicall($url_path, $method, $post, $json=false)
    {
        $this->api_error = '';
        $curl = curl_init();
        if (strpos($url_path, 'http://') === 0 || strpos($url_path, 'https://') === 0) {
            $url = $url_path;
        }
        else {
            $url = $this->base_url . $url_path;
        }

        $curl_params = $this->curl_params;
        $curl_params[CURLOPT_URL] = $url;
        $curl_params[CURLOPT_CUSTOMREQUEST] =  $method;
        $curl_params[CURLOPT_POSTFIELDS] = $post;

        curl_setopt_array($curl, $curl_params);
        $response = curl_exec($curl);

        $this->last_url = $url;
        $this->last_request = $post;
        $this->last_response = $response;

        if ($error = curl_errno($curl)) {
            $message = 'Ошибка доступа к API: "'.curl_error($curl).'", URL: '.$this->base_url.$url_path;
            $this->api_error = $message;
            curl_close($curl);
            return false;
        }
        curl_close($curl);

        if ($json) {
            try {
                $answer = json_decode($response, true);
                return $answer;
            }
            catch(Exception $e) {
                //Невалидный JSON
                $message = 'ТО вернул невалидный JSON, URL: '.$this->base_url.$url_path."\n".$json;
                $this->api_error = $message;
                return false;
            }
        }
        else {
            return $response;
        }
    }

    /**
     * @param int $sourceKladr
     * @param int $targetKladr
     * @param float $weight
     */
    abstract public function calculate($sourceKladr , $targetKladr, $weight);
}