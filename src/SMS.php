<?php

namespace Impeto\Wire2Air;

class SMS extends Request
{

    public function __construct( Client $client){
        $this->client = $client;
    }

    public function getEndPoint()
    {
        return 'send_message';
    }
}