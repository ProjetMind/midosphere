<?php

namespace Mind\UserBundle;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

/**
 * Description of OAuth
 *
 * @author nsi
 */
class TwitterApi {
 
    protected $baseUrl  = 'http://api.twitter.com/1.1';
    protected $client;


    public function __construct() {
        
        $this->client = new Client();
        $this->client->setBaseUrl($this->baseUrl);
        $oauth = new OauthPlugin(array(
            'consumer_key'    => 'ZOirAXMLdi3Egu6JtxLGMw',
            'consumer_secret' => 'DKo2mQ9XH6QaeZoVctdKpVrSsHHg0OqdlN9BXfodA',
            'token'           => '2244172584-Iy0wgiDLMRymUcIdYlKmCT4wppE8SWbN7wXmufa',
            'token_secret'    => 'yrDxtag1lKtCwHL8FkzXFefUVD9wPMRjJImpjhkQADhrS'
        ));
        $this->client->addSubscriber($oauth);

    }
    
    public function getNbFollows(){
        
       $client = new Client('https://api.twitter.com/1.1');
       $oauth = new OauthPlugin(array(
            'consumer_key'    => 'ZOirAXMLdi3Egu6JtxLGMw',
            'consumer_secret' => 'DKo2mQ9XH6QaeZoVctdKpVrSsHHg0OqdlN9BXfodA',
            'token'           => '2244172584-Iy0wgiDLMRymUcIdYlKmCT4wppE8SWbN7wXmufa',
            'token_secret'    => 'yrDxtag1lKtCwHL8FkzXFefUVD9wPMRjJImpjhkQADhrS'
        ));
      
       $client->addSubscriber($oauth);
     
       $data =$client->createRequest('GET', 'https://api.twitter.com/1.1/users/lookup.json?screen_name=midosphere')->send()->getParams();
       print_r($data);
       //$response = $client->get('users/lookup.json')->send();
       //print_r($response);
       return ""; 
    }
}
