<?php

namespace Impeto\Wire2Air;

abstract class Request
{
    /**
     * @var Client
     */
    protected $client;

    private $data;

    public function process()
    {
        return $this->client->makeCall( $this->getEndPoint(), $this->data);
    }

    public function __get( $name)
    {
        return $this->data[$name];
    }

    public function __set( $name, $value)
    {
        $this->data[$name] = $value;
    }

    public abstract function getEndPoint();
}