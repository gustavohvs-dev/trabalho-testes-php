<?php

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $http;
    private $token = "eyJhbGciOiAiSFMyNTYiLCAidHlwIjogIkpXVCJ9.eyJzdWIiOiAiMSIsICJuYW1lIjogImFkbWluIiwgImlhdCI6IDE2ODQ3MTY3MDUsICJleHAiOiAxNjg0ODAzMTA1LCJpZCI6ICIxIiwidXNlcm5hbWUiOiAiYWRtaW4ifQ.CHBO8PLj1E80DarPkY8V3UEWVIBEEC4i0iDvpOGWboU";

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['http_errors' => false]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    /**
     * Verify if the server is working normally
     */
    public function testCreateUserSuccesfully()
    {
        
        require "config.php";
        $data = [
            'username' => 'gustavosoares',
            'permission' => 'supervisor',
            'password' => '189374983274'
        ];
        $response = $this->http->post($config['path']."createUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $this->token ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        var_dump($body);
        $this->assertEquals(200, $body->code);
        $this->assertEquals("Registro criado com sucesso", $body->info);
    }

}