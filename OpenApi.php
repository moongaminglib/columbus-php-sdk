<?php
namespace com\moongaming\columbus;

/**
 * Blockchain transformation solution php sdk
 */
class OpenApi
{
  protected $app_id;
  protected $app_secret;
  // sandbox Api gateway
  // protected $api_gateway = '';
  // production mainnet Api gateway
  protected $api_gateway = 'http://api.open.moonswap.fi';

  public function __construct($app_id, $app_secret)
  {
    $this->app_id  = $app_id;
    $this->app_secret = $app_secret;
  }

  /**
   *  user info query
   */
  public function getUserInfo($openid)
  {
    $uri = '/operator/user/info';
    $data = [
      'openid' => $openid,
    ];

    return $this->urlCall($uri, $data);
  }

  /**
   * query order
   */
  public function queryOrder($order_no)
  {
    $uri = '/trade/order/find-one';
    $data = [
      'order_no' => $order_no,
    ];

    return $this->urlCall($uri, $data);
  }



  protected function urlCall($uri, $postdata)
  {
    $url = $this->api_gateway . $uri;
    $_timestamp = time();
    $_signature = md5($this->app_id.$_timestamp.$this->app_secret);

    $postdata['app_id'] = $this->app_id;
    $postdata['_timestamp'] = $_timestamp;
    $postdata['_signature'] = $_signature;

    $post_array = [];
    foreach ($postdata as $key => $value)
    {
        $post_array[] = urlencode($key) . "=" . urlencode($value);
    }

    $method = 'POST';
    $post_string = implode("&", $post_array);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // var_dump("[open_api_url][{$url}][{$post_string}][http_code: {$status}]");

    if(!$response){
      return false;
    }

    return json_decode($response, true);
  }

}
