<?php

use app\models\impetus\ImpetusUtils;
use PHPUnit\Framework\TestCase;

include_once "app/models/impetus/ImpetusUtils.php";

class TopicTest extends TestCase
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

    public function testCreateTopicSuccess()
    {
        require "config.php";
        $data = [
            'title' => ImpetusUtils::token(10),
            'description' => ImpetusUtils::token(10),
            'keywords' => ImpetusUtils::token(10)
        ];
        $response = $this->http->post($config['path']."createTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);

        //Cria arquivo cache do usuário
        $arquivo = fopen("tests/cache/TopicData.json", 'w');
        fwrite($arquivo, $responseJson);

    }

    public function testCreateTopicErrorWithoutParams()
    {
        
        require "config.php";
        $response = $this->http->post($config['path']."createTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testListTopicSuccess()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListTopicSuccessWithParams()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => 1, 'dataPerPage' => 10 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListTopicErrorNotFound()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => -1, 'dataPerPage' => -1 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
        $this->assertEquals(0, $body->status);
    }

    public function testGetTopicSuccess()
    {
        require "config.php";
        $topicData = json_decode(file_get_contents("tests/cache/TopicData.json"));
        $response = $this->http->get($config['path']."getTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $topicData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testGetTopicErrorNotFound()
    {
        require "config.php";
        $topicData = json_decode(file_get_contents("tests/cache/TopicData.json"));
        $response = $this->http->get($config['path']."getTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => -1]
        ]);
        $this->assertEquals(404, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

    public function testUpdateTopicSuccess()
    {
        require "config.php";
        $topicData = json_decode(file_get_contents("tests/cache/TopicData.json"));
        $data = [
            'id' => $topicData->id,
            'title' => ImpetusUtils::token(10),
            'description' => ImpetusUtils::token(10),
            'keywords' => ImpetusUtils::token(10)
        ];
        $response = $this->http->put($config['path']."updateTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);
        $this->assertEquals(200, $body->code);
    }

    public function testUpdateTopicErrorWithoutParams()
    {
        require "config.php";
        $topicData = json_decode(file_get_contents("tests/cache/TopicData.json"));
        $response = $this->http->put($config['path']."updateTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteTopicSuccess()
    {
        require "config.php";
        $topicData = json_decode(file_get_contents("tests/cache/TopicData.json"));
        $response = $this->http->delete($config['path']."deleteTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $topicData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testDeleteTopicErrorNotFound()
    {
        require "config.php";
        $topicData = json_decode(file_get_contents("tests/cache/TopicData.json"));
        $response = $this->http->delete($config['path']."deleteTopics", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $topicData->id ]
        ]);
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

}