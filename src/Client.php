<?php

namespace Impeto\Wire2Air;

class Client
{
    private static $USER_AGENT = "impeto/wire2air/1.0";
    private $endpoints = [
        'send_message' => [
            'url' =>'http://smsapi.wire2air.com/smsadmin/submitsm.aspx',
            'required' => [
                'version', 'userid', 'password', 'vasid', 'profileid', 'from', 'to', 'text'
            ]
        ],
        'register_keyword' => 'http://mzone.wire2air.com/mserver/servicemanager/api/RegisterKeywordAPI.aspx',
        'check_credits' => 'http://smsapi.wire2air.com/smsadmin/checksmscredits.aspx',
        'check_keyword' => 'http://mzone.wire2air.com/mserver/servicemanager/api/checkkeywordapi.aspx',
        'subscribe_keyword' => 'http://mzone.wire2air.com/mserver/api/subscribekeywords.aspx',
        'subscribe_user' => 'http://mzone.wire2air.com/mserver/api/SubscribeUser.aspx',
    ];

    private $apiData;

    public function __construct( $props = []){
        $this->apiData = $props;
    }

    /**
     * This is basically a checkpoint
     *
     * @param $endPoint
     * @return mixed
     * @throws \Exception
     */
    private function getEndpoint( $endPoint)
    {

        if ( ! array_key_exists( $endPoint, $this->endpoints))
        {
            throw new \Exception( 'Endpoint does not exist');
        }

        return $this->endpoints[$endPoint];
    }

    private function validate( $data, $required)
    {
        $data = array_merge( $this->apiData, $data);

        $intersect = array_intersect( array_keys( $data), $required);

        if ( count( $intersect) != count( $required))
        {
            throw new \Exception( 'Required fields are not set. Please check the data.');
        }
    }

    public function getApiData()
    {
        return $this->apiData;
    }

    public function makeCall( $endPoint, $data)
    {
        $endPointData = $this->getEndpoint( $endPoint);

        $this->validate( $data, $endPointData['required']);

        if ( ( $ch = curl_init()) === false) {
            throw new \Exception( 'Could not initialize cURL.');
        }

        $curlOpts = [
            CURLOPT_URL                 => $endPointData['url'],
            CURLOPT_RETURNTRANSFER      => true,
            CURLOPT_POST                => true,
            CURLOPT_CONNECTTIMEOUT      => 10,
            CURLOPT_USERAGENT           => static::$USER_AGENT,
            CURLOPT_POSTFIELDS          => http_build_query($data)
        ];

        curl_setopt_array( $ch, $curlOpts);

        try {
            if ( ( $data = curl_exec( $ch)) === false) {
                throw new \Exception( curl_error( $ch), curl_errno( $ch));
            }

            return $data;
        } finally {
            curl_close( $ch);
        }
    }
}
