<?php

use app\models\impetus\ImpetusUtils;
use PHPUnit\Framework\TestCase;

include_once "app/models/impetus/ImpetusUtils.php";

class ImprovementSuggestionsTest extends TestCase
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

    public function testCreateImprovementSuggestionsSuccess()
    {
        require "config.php";
        $data = [
            'fk_user' => 1,
            'suggestion' => ImpetusUtils::token(10)
        ];
        $response = $this->http->post($config['path']."createImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);

        //Cria arquivo cache do usuário
        $arquivo = fopen("tests/cache/ImprovementSuggestionsData.json", 'w');
        fwrite($arquivo, $responseJson);

    }

    public function testCreateImprovementSuggestionsErrorWithoutParams()
    {
        
        require "config.php";
        $response = $this->http->post($config['path']."createImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testListImprovementSuggestionsSuccess()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListImprovementSuggestionsSuccessWithParams()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => 1, 'dataPerPage' => 10 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListImprovementSuggestionsErrorNotFound()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => -1, 'dataPerPage' => -1 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
        $this->assertEquals(0, $body->status);
    }

    public function testGetImprovementSuggestionsSuccess()
    {
        require "config.php";
        $ImprovementSuggestionsData = json_decode(file_get_contents("tests/cache/ImprovementSuggestionsData.json"));
        $response = $this->http->get($config['path']."getImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $ImprovementSuggestionsData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testGetImprovementSuggestionsErrorNotFound()
    {
        require "config.php";
        $ImprovementSuggestionsData = json_decode(file_get_contents("tests/cache/ImprovementSuggestionsData.json"));
        $response = $this->http->get($config['path']."getImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => -1]
        ]);
        $this->assertEquals(404, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

    public function testUpdateImprovementSuggestionsSuccess()
    {
        require "config.php";
        $ImprovementSuggestionsData = json_decode(file_get_contents("tests/cache/ImprovementSuggestionsData.json"));
        $data = [
            'id' => $ImprovementSuggestionsData->id,
            'fk_user' => 1,
            'suggestion' => ImpetusUtils::token(10)
        ];
        $response = $this->http->put($config['path']."updateImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);
        $this->assertEquals(200, $body->code);
    }

    public function testUpdateImprovementSuggestionsErrorWithoutParams()
    {
        require "config.php";
        $ImprovementSuggestionsData = json_decode(file_get_contents("tests/cache/ImprovementSuggestionsData.json"));
        $response = $this->http->put($config['path']."updateImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteImprovementSuggestionsSuccess()
    {
        require "config.php";
        $ImprovementSuggestionsData = json_decode(file_get_contents("tests/cache/ImprovementSuggestionsData.json"));
        $response = $this->http->delete($config['path']."deleteImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $ImprovementSuggestionsData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testDeleteImprovementSuggestionsErrorNotFound()
    {
        require "config.php";
        $ImprovementSuggestionsData = json_decode(file_get_contents("tests/cache/ImprovementSuggestionsData.json"));
        $response = $this->http->delete($config['path']."deleteImprovementsuggestions", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $ImprovementSuggestionsData->id ]
        ]);
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

}