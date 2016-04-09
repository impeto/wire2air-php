<?php

namespace Impeto\Wire2Air;

class IncomingSMS extends SMS
{

    public function __construct( array $data){

        parent::__construct( []);

        $this->from = $data['mobilenumber'];

        $body = explode( ' ', $data['message'], 2);
        $this->keyword = strtoupper( trim($body[0]));

        $this->sent_at = $data['Rcvd'];

        $this->to = $data['SHORTCODE'];

        $this->text = $data['message'];

        $this->session = $data['SESSIONID'];
    }
}