<?php

//Importando models e middlewares
include_once "app/models/impetus/ImpetusJWT.php";
include_once "app/models/impetus/ImpetusUtils.php";
include_once "app/models/Comments.php";
include_once "app/middlewares/Auth.php";
use app\models\impetus\ImpetusJWT;
use app\models\impetus\ImpetusUtils;
use app\models\Comments;
use app\middlewares\Auth;

function wsmethod(){

    require "app/config/config.php";
    $secret = $systemConfig["api"]["token"];

    if($_SERVER["REQUEST_METHOD"] != "GET"){
        $response = [
            "code" => "401 Unauthorized",
            "response" => [
                "status" => 0,
                "code" => 401,
                "info" => "Método não encontrado",
            ]
        ];
        return (object)$response;
    }else{
        //Coletar bearer token
        $bearer = ImpetusJWT::getBearerToken();
        $jwt = ImpetusJWT::decode($bearer, $secret);

        if($jwt->status == 0){
            $response = [
                "code" => "400 Bad request",
                "response" => [
                    "status" => 0,
                    "code" => 400,
                    "info" => $jwt->error,
                ]
            ];
            return (object)$response;
        }else{
            $auth = Auth::validate($jwt->payload->id, $jwt->payload->username);
            if($auth->status == 0){
                $response = [
                    "code" => "401 Unauthorized",
                    "response" => [
                        "status" => 0,
                        "code" => 401,
                        "info" => "Falha ao autenticar",
                    ]
                ];
                return (object)$response;
            }else{
                /**
                 * Regra de negócio do método
                 */
                $urlParams = ImpetusUtils::urlParams();
                $buscar = Comments::listComments($urlParams);
                $response = [
                    "code" => "200 OK",
                    "response" => $buscar
                ];
                return (object)$response;
            }
        }
    }

}

$response = wsmethod();
header("HTTP/1.1 " . $response->code);
header("Content-Type: application/json");
echo json_encode($response->response);
