<?php

namespace Impeto\Wire2Air;

class IncomingSMS
{
    private $data = [];

    public function __construct( array $data){

        $this->from = $data['mobilenumber'];

        $body = explode( ' ', $data['message'], 2);
        $this->keyword = strtoupper( trim($body[0]));

        $this->sent_at = $data['Rcvd'];

        $this->to = $body['SHORTCODE'];

        $this->text = $body['message'];

        $this->session = $body['SESSIONID'];
    }

    public function getData()
    {
        return $this->data;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if ( ! array_key_exists( $name, $this->data))
        {
            throw new \Exception( 'Index out of bounds.');
        }

        return $this->data[$name];
    }
}