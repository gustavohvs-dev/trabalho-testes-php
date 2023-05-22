<?php

use app\models\impetus\ImpetusUtils;
use PHPUnit\Framework\TestCase;

include_once "app/models/impetus/ImpetusUtils.php";

class CommentTest extends TestCase
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

    public function testCreateCommentSuccess()
    {
        require "config.php";
        $data = [
            'fk_topic' => 1,
            'fk_user' => 1,
            'comment' => ImpetusUtils::token(10)
        ];
        $response = $this->http->post($config['path']."createComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);

        //Cria arquivo cache do usuário
        $arquivo = fopen("tests/cache/CommentData.json", 'w');
        fwrite($arquivo, $responseJson);

    }

    public function testCreateCommentErrorWithoutParams()
    {
        
        require "config.php";
        $response = $this->http->post($config['path']."createComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testListCommentSuccess()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListCommentSuccessWithParams()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => 1, 'dataPerPage' => 10 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
        $this->assertEquals(1, $body->status);
    }

    public function testListCommentErrorNotFound()
    {
        
        require "config.php";
        $response = $this->http->get($config['path']."listComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'currentPage' => -1, 'dataPerPage' => -1 ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
        $this->assertEquals(0, $body->status);
    }

    public function testGetCommentSuccess()
    {
        require "config.php";
        $CommentData = json_decode(file_get_contents("tests/cache/CommentData.json"));
        $response = $this->http->get($config['path']."getComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $CommentData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testGetCommentErrorNotFound()
    {
        require "config.php";
        $CommentData = json_decode(file_get_contents("tests/cache/CommentData.json"));
        $response = $this->http->get($config['path']."getComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => -1]
        ]);
        $this->assertEquals(404, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

    public function testUpdateCommentSuccess()
    {
        require "config.php";
        $CommentData = json_decode(file_get_contents("tests/cache/CommentData.json"));
        $data = [
            'id' => $CommentData->id,
            'fk_topic' => 1,
            'fk_user' => 1,
            'comment' => ImpetusUtils::token(10)
        ];
        $response = $this->http->put($config['path']."updateComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'body' => json_encode($data)
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $responseJson = $response->getBody()->getContents();
        $body = json_decode($responseJson);
        $this->assertEquals(200, $body->code);
    }

    public function testUpdateCommentErrorWithoutParams()
    {
        require "config.php";
        $CommentData = json_decode(file_get_contents("tests/cache/CommentData.json"));
        $response = $this->http->put($config['path']."updateComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testDeleteCommentSuccess()
    {
        require "config.php";
        $CommentData = json_decode(file_get_contents("tests/cache/CommentData.json"));
        $response = $this->http->delete($config['path']."deleteComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $CommentData->id ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(200, $body->code);
    }

    public function testDeleteCommentErrorNotFound()
    {
        require "config.php";
        $CommentData = json_decode(file_get_contents("tests/cache/CommentData.json"));
        $response = $this->http->delete($config['path']."deleteComments", [
            'headers' => [ 'Authorization' => 'Bearer ' . $config['token'] ],
            'query' => [ 'id' => $CommentData->id ]
        ]);
        $body = json_decode($response->getBody()->getContents());
        $this->assertEquals(404, $body->code);
    }

}