<?php


class SimpleTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $dotenv = new \Dotenv\Dotenv( dirname( __DIR__), '.env.test');
        $dotenv->load();
    }

    /**
     * Initializes a Client and asserts that the configuration is right.
     */
//    public function testCreateNewClient()
//    {
//        $props = include dirname( __DIR__) . '/wire2air.php';
//
//        $client = new \Impeto\Wire2Air\Wire2AirAPI( $props);
//
//        $result = $client->sms( '13307801648', 'This is the body of the SMS text');
//
//        var_dump( $result);
//
//        $this->assertTrue( true);
//
//    }

    public function testCheckCredits(){

        $client = new \Impeto\Wire2Air\Wire2AirAPI();

        $result = $client->credits();

        var_dump( $result);

        $this->assertTrue($result->isError());
    }
}