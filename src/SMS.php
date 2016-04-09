<?php

namespace Impeto\Wire2Air;

class SMS
{
    protected $data;

    public function __construct( array $data = [])
    {
        $this->data = $data;
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
            throw new \Exception( 'Index out of bounds. (' . $name . ')');
        }

        return $this->data[$name];
    }
}