<?php

use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $http;
    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['http_errors' => false]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testLoginSuccess()
    {
        require "config.php";
        $data = [
            'username' => "admin",
            'password' => 'admin'
        ];
        $response = $this->http->post($config['path']."login", [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLoginErrorWrongCredentials()
    {
        require "config.php";
        $data = [
            'username' => '10923840912384091238409',
            'password' => '91203840193284091328409'
        ];
        $response = $this->http->post($config['path']."login", [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testLoginErrorWithoutCredentials()
    {
        require "config.php";
        $response = $this->http->post($config['path']."login");
        $this->assertEquals(401, $response->getStatusCode());
    }

}