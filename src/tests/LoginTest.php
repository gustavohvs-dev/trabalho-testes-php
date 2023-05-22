<?php

use PHPUnit\Framework\TestCase;
use app\Api;

class ApiTest extends TestCase
{
    public function testWsmethodReturnsCorrectResponse()
    {
        // Configuração
        $systemConfig = [
            "api" => [
                "token" => "your_secret_token"
            ]
        ];

        $api = new Api($systemConfig);

        // Dados de entrada
        $data = (object) [
            "username" => "your_username",
            "password" => "your_password"
        ];

        // Execução do método sendo testado
        $response = $api->wsmethod($data);

        // Verificações/assertions
        $this->assertEquals("200 OK", $response->code);
        $this->assertEquals(1, $response->response["status"]);
        $this->assertEquals(200, $response->response["code"]);
        $this->assertNotEmpty($response->response["token"]);
    }
}
