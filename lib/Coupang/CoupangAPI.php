<?php
namespace CCPP\Coupang;
use GuzzleHttp\Client;

class CoupangAPI{
    public $client;

    function __construct(Client $client){
        global $config;
        $this->accessKey = "{$config['cf_1']}";
        $this->secrectKey = "{$config['cf_2']}";
        $this->client = $client;
        $this->url = 'https://api-gateway.coupang.com';
        $this->basePath = '/v2/providers/affiliate_open_api/apis/openapi/v1';
        $this->endpoints= [
            'products' => [
                'bestcategories' => '/products/bestcategories',
                'search' => '/products/search'
            ],
            'links' => [
                'deeplink' => '/deeplink'
            ],
        ];
        $this->productArr = [
            '1001' => "여성패션",
            '1002' => "남성패션",
            '1010' => "뷰티",
            '1011' => "출산/유아동",
            '1012' => "식품",
            '1013' => "주방용품",
            '1014' => "생활용품",
            '1015' => "홈인테리어",
            '1016' => "가전디지털",
            '1017' => "스포츠/레저",
            '1018' => "자동차용품",
            '1019' => "도서/음반/DVD",
            '1020' => "완구/취미",
            '1021' => "문구/오피스",
            '1024' => "헬스/건강식품",
            '1025' => "국내여행",
            '1026' => "해외여행",
            '1029' => "반려동물용품",
            '1030' => "유아동패션"
        ];
    }

    public function resolveAuth($endpoint, $method='GET')
    {
        date_default_timezone_set("GMT+0");
        $result = [];
        $datetime = date("ymd").'T'.date("His").'Z';
        $endpoint = trim($endpoint);
        $message = $datetime.$method.str_replace("?", "", $endpoint);
        $ACCESS_KEY = $this->accessKey;
        $SECRET_KEY = $this->secrectKey;
        $signature = hash_hmac('sha256', $message, $SECRET_KEY);

        $authorization  = "CEA algorithm=HmacSHA256, access-key=".$ACCESS_KEY.", signed-date=".$datetime.", signature=".$signature;
        $url = $this->url.$endpoint;
        $urlJson = json_encode($url);

        $result['signature']     = $signature;
        $result['authorization'] = $authorization;
        $result['url']           = $url;
        $result['urlJson']       = $urlJson;

        return $result;
    }

    public function request($endpoint, $method="GET", $request=[])
    {
        $result = false;
        $auth = $this->resolveAuth($endpoint, $method);
        $url = $auth['url'];
        $authorization = $auth['authorization'];
        $header = [
            'headers' => [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => $authorization
            ]
        ];

        if($request){
            $header = array_merge($header, $request);
        }

        $response = $this->client->request($method, $url, $header);

        if($response->getStatusCode() == '200'){
            $body = $response->getBody();
            $result = $body->getContents();
            $result = json_decode($result);
        }

        return $result;
    }

    public function getBestcategories($resource='', $method='GET', $limit = null){
        $limit = $limit ? "?limit=".$limit : '';
        $endpoint = $this->basePath.$this->endpoints['products']['bestcategories'].'/'.$resource.$limit;

        return $this->request($endpoint, $method);
    }

    public function getDeeplink($urlArr=[]){
        $endpoint = $this->basePath.$this->endpoints['links']['deeplink'];
        $method = 'POST';
        $request = [
            'json' => ['coupangUrls' => $urlArr]
        ];

        return $this->request($endpoint, $method, $request);
    }

    public function getSearch($keyword, $limit = null){
        $arr = [
            'keyword' => $keyword,
            'limit' => $limit
        ];
        $queryStr = http_build_query($arr);
        $endpoint = $this->basePath.$this->endpoints['products']['search'].'?'.$queryStr;

        return $this->request($endpoint);
    }

    public function downloadImage($url, $path=null)
    {
        $path = $path ? $path : $this->downLoadedImagePath;
        $fname = uniqid().'.jpg';
        $opt = [
            'sink' => "$path/$fname",
        ];
        $response = $this->client->request('GET', $url, $opt);
        return $response;
    }

    public function dd($dump)
    {
        echo '<pre>';
        var_dump($dump);
        echo '</pre>';
    }
}