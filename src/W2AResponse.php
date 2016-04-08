<?php

namespace Impeto\Wire2Air;

class W2AResponse
{

    private $statusCode;

    private $body;

    private $isError;

    private $errorNum;

    private $errorText;

    /**
     * W2AResponse constructor.
     * @param mixed|\Psr\Http\Message\ResponseInterface $result
     */
    public function __construct( $result)
    {
        $this->statusCode = $result->getStatusCode();
        $this->body = trim($result->getBody()->getContents());

        if ( strpos($this->body, 'ERR:') === 0)
        {
            $this->isError = true;

            list( $err, $num, $txt) = explode(':', $this->body );

            $this->errorNum = trim( $num);

            $this->errorText = trim( $txt);
        }
    }

    public function isError()
    {
        return $this->isError;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return boolean
     */
    public function isIsError()
    {
        return $this->isError;
    }

    /**
     * @return string
     */
    public function getErrorNum()
    {
        return $this->errorNum;
    }

    /**
     * @return string
     */
    public function getErrorText()
    {
        return $this->errorText;
    }

}