<?php


class IncomingSMSTest extends PHPUnit_Framework_TestCase
{
    public function testCreateIncomingSMSObject()
    {
        $data = [
            'mobilenumber' => '12345678901',
            'shortcodeid' => '14',
            'Operatorid' => '470',
            'message' => 'keyword here we go',
            'Serviceid' => '9406',
            'smsinboxid' => '2515777',
            'SHORTCODE' => '27126',
            'Rcvd' => '2016-04-09 13:43:09',
            'SESSIONID' => '8016S-04096-1343P-14VTA',
            'TAGSUBREF' => '',
            'origmsg' => 'keyword here we go',
            'MOLOGID' => '2599199',
        ];

        $sms = new \Impeto\Wire2Air\IncomingSMS( $data);

        $this->assertEquals( 'KEYWORD', $sms->keyword);
        $this->assertEquals( '12345678901', $sms->from);
        $this->assertEquals( '2016-04-09 13:43:09', $sms->sent_at);
    }

    public function testSMS()
    {
        $dot = new Dotenv\Dotenv( dirname(__DIR__), '.env.test');
        $dot->load();

        $config = require dirname(__DIR__).'/wire2air.php';

        $api = new \Impeto\Wire2Air\Wire2AirAPI( $config);

        $response = $api->sms(
            getenv( 'W2A_TESTTO'),
            'Please reply with Y to get communication. Just a test.',
            [
                'replypath' => getenv('W2A_REPLYPATH')
            ]
        );

        var_dump( $response);
    }
}