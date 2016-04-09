<?php

namespace Impeto\Wire2Air;

use GuzzleHttp\Client;

class Wire2AirAPI
{

    private $endpoints = [
        'send_message' => [
            'url' =>'http://smsapi.wire2air.com/smsadmin/submitsm.aspx',
            'required' => [
                'version', 'userid', 'password', 'vasid', 'profileid', 'from', 'to', 'text'
            ]
        ],
        'check_credits' => [
            'url' =>'http://smsapi.wire2air.com/smsadmin/checksmscredits.aspx',
            'required' => [
                'userid', 'password', 'vasid'
            ]
        ],
        'register_keyword' => 'http://mzone.wire2air.com/mserver/servicemanager/api/RegisterKeywordAPI.aspx',
        'check_keyword' => 'http://mzone.wire2air.com/mserver/servicemanager/api/checkkeywordapi.aspx',
        'subscribe_keyword' => 'http://mzone.wire2air.com/mserver/api/subscribekeywords.aspx',
        'subscribe_user' => 'http://mzone.wire2air.com/mserver/api/SubscribeUser.aspx',
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    public function __construct( $config = [])
    {
        if ( ! $config){
            $this->config = $this->getConfigFromEnv();
        } else {
            $this->config = $config;
        }

        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'impeto/wire2air/1.2.1'
            ]
        ]);
    }

    public function sms( $to, $message)
    {
        return $this->createRequestAndSend( 'send_message', ['to' => $to, 'text' => $message]);
    }

    public function credits(){
        return $this->createRequestAndSend( 'check_credits', []);
    }

    private function createRequestAndSend( $endpoint, array $data){
        $data = $this->config + $data;

        return $this->send( $endpoint, $data);
    }

    private function send( $endpoint, array $data){

        $this->validate( $endpoint, $data);

        $result =  $this->client->request( 'POST', $this->endpoints[$endpoint]['url'], ['form_params' => $data]);

        return new W2AResponse( $result);
    }

    private function getConfigFromEnv()
    {
        $config = [];

        $required = [
            'version', 'userid', 'password', 'vasid', 'profileid', 'from'
        ];

        foreach ( $required as $item){
            $varName = 'W2A_'. strtoupper( $item);
            $varVal = getenv( $varName);

            if ( $varVal !== false)
            {
                $config[$item] = $varVal;
            }
        }

        return $config;
    }

    private function validate($endpoint, array $data)
    {
        if ( !array_key_exists( $endpoint, $this->endpoints))
        {
            throw new \Exception( "Sorry, $endpoint does not exist as an API endpoint");
        }

        $required = $this->endpoints[$endpoint]['required'];

        $intersect = array_intersect( array_keys( $data), $required);

        if ( count( $intersect) !== count( $required))
        {
            throw new \Exception( 'Data validation has failed. Please set all these values: ' . join(', ', $required));
        }
    }
}