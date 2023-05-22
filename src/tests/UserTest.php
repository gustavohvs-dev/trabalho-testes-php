<?php

use app\models\impetus\ImpetusUtils;
use PHPUnit\Framework\TestCase;

include_once "app/models/impetus/ImpetusUtils.php";

class UserTest extends TestCase
{
    //Pendente - automatizar coleta de token e id
    private $http;
    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['http_errors' => false]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testCreateUserSuccess()
    {
        require "config.php";
        $data = [
            'username' => ImpetusUtils::token(10),
            'permission' => 'supervisor',
            'password' => '1234'
        ];
        $response = $this->http->post($config['path']."createUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);
        $this->assertEquals(200, $body->code);

        //Cria arquivo cache do usuário
        $arquivo = fopen("tests/cache/UserData.json", 'w');
        fwrite($arquivo, $responseJson);

    }

    public function testCreateUserErrorDuplicated()
    {
        
        require "config.php";
        $data = [
            'username' => 'admin',
            'permission' => 'supervisor',
            'password' => '189374983274'
        ];
        $response = $this->http->post($config['path']."createUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(500, $body->code);
    }

    public function testCreateUserErrorWithoutParams()
    {
        
        require "config.php";
        $response = $this->http->post($config['path']."createUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testCreateUserErrorInvalidPermissionEnum()
    {
        
        require "config.php";
        $data = [
            'username' => ImpetusUtils::token(10),
            'permission' => 'superadminfoda',
            'password' => '189374983274'
        ];
        $response = $this->http->post($config['path']."createUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(400, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(0, $body->status);
    }

    public function testListUserSuccess()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListUserSuccessWithParams()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => 1, 'dataPerPage' => 10 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListUserErrorNotFound()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => -1, 'dataPerPage' => -1 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
        $this->assertEquals(0, $body->status);
    }

    public function testGetUserSuccess()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $response = $this->http->get($config['path']."getUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $userData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testGetUserErrorNotFound()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $response = $this->http->get($config['path']."getUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => -1]
        ]);
        $this->assertEquals(404, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

    public function testUpdateUserSuccess()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $data = [
            'id' => $userData->id,
            'username' => ImpetusUtils::token(10),
            'permission' => 'supervisor',
            'password' => '1234'
        ];
        $response = $this->http->put($config['path']."updateUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);
        $this->assertEquals(200, $body->code);
    }

    public function testUpdateUserErrorWithoutParams()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $response = $this->http->put($config['path']."updateUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testUpdateUserErrorInvalidPermissionEnum()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $data = [
            'id' => $userData->id,
            'username' => ImpetusUtils::token(10),
            'permission' => 'QA',
            'password' => '1234'
        ];
        $response = $this->http->put($config['path']."updateUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(400, $response->getStatusCode());
        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);
        $this->assertEquals(0, $body->status);
    }

    public function testDeleteUserSuccess()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $response = $this->http->delete($config['path']."deleteUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $userData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testDeleteUserErrorNotFound()
    {
        require "config.php";
        $userData = json_decode(file_get_contents("tests/cache/UserData.json"));
        $response = $this->http->delete($config['path']."deleteUsers", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $userData->id ]
        ]);
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

}