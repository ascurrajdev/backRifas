<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class TpagoClient{
    private $httpClient;
    public function __construct()
    {
        $this->httpClient = Http::withOptions([
            'base_uri' => config('tpago.base_uri'),
            'verify' => false,
        ])->acceptJson()->withBasicAuth(config('tpago.public_key'), config('tpago.private_key'));
    }
    
    public function post($url, $data){
        $response = $this->httpClient->post($url, $data);
        return $response->json();
    }
    public function put($url){
        $response = $this->httpClient->put($url);
        return $response->json();
    }
}