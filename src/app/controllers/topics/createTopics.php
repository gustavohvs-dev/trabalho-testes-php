<?php

//Importando models e middlewares
include_once "app/models/impetus/ImpetusJWT.php";
include_once "app/models/impetus/ImpetusUtils.php";
include_once "app/models/Topics.php";
include_once "app/middlewares/Auth.php";
use app\models\impetus\ImpetusJWT;
use app\models\impetus\ImpetusUtils;
use app\models\Topics;
use app\middlewares\Auth;

function wsmethod(){

    require "app/config/config.php";
    $secret = $systemConfig["api"]["token"];

    if($_SERVER["REQUEST_METHOD"] != "POST"){
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
                
                //Validar permissão de usuário
                if($auth->data["permission"] != "admin"){
                    $response = [
                        "code" => "401 Unauthorized",
                        "response" => [
                            "status" => 1,
                            "info" => "Usuário não possui permissão para realizar ação"
                        ]
                    ];
                    return (object)$response;
                }

                //Coletar params do body (JSON)
                $jsonParams = json_decode(file_get_contents("php://input"),false);

                //Validação de campos
                $validate = ImpetusUtils::validator("title", $jsonParams->title, ['type(string)', 'uppercase', 'length(256)']);
                    if($validate["status"] == 0){
                        $response = [
                            "code" => "400 Bad Request",
                            "response" => $validate
                        ];
                        return (object)$response;
                    }
					$validate = ImpetusUtils::validator("description", $jsonParams->description, ['type(string)', 'specialChar', 'length()']);
                    if($validate["status"] == 0){
                        $response = [
                            "code" => "400 Bad Request",
                            "response" => $validate
                        ];
                        return (object)$response;
                    }
					$validate = ImpetusUtils::validator("keywords", $jsonParams->keywords, ['type(string)', 'uppercase', 'length(256)']);
                    if($validate["status"] == 0){
                        $response = [
                            "code" => "400 Bad Request",
                            "response" => $validate
                        ];
                        return (object)$response;
                    }
					

                //Organizando dados para a request
                $data = [
                    "title" => $jsonParams->title,
						"description" => $jsonParams->description,
						"keywords" => $jsonParams->keywords,
                ];

                //Criar dados
                $request = Topics::createTopics($data);
                if($request->status == 0){
                    $response = [
                        "code" => "400 Bad request",
                        "response" => $request
                    ];
                    return (object)$response;
                }else{
                    $response = [
                        "code" => "200 OK",
                        "response" => $request
                    ];
                    return (object)$response;
                }


            }
        }
    }

}

$response = wsmethod();
header("HTTP/1.1 " . $response->code);
header("Content-Type: application/json");
echo json_encode($response->response);
