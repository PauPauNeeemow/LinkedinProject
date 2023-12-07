<?php

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;



class AuthContoller{
    private $model;
    private $db;
    public function __construct($model, $db){
        $this->model = $model;
        $this->db = $db;
    }
    public function AuthVerif($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        $token = $data['token'];
        $id = $data['id'];
        $adm = $data['adm'];
        try {
            $privateKey = 'OpenJobs';
            $decoded = JWT::decode($token, $privateKey, array('HS256'));
            $expirationTime = $decoded->exp;
            $currentTime = time();

            if ($currentTime > $expirationTime) {
                http_response_code(401);
                echo json_encode(['token' => "", 'verif' => "False", "id" =>"$id", "adm" => ""]);
               
            } else {
                http_response_code(200);
                echo json_encode(['token' => "$token", 'verif' => "True", "id" =>"$id", "adm" => $adm ]);
            }
        } catch (Exception $e) {
            // Une exception est levée si le décodage échoue
            echo json_encode(['verif' => "False", "message" =>"$decoded"]);
        }
    }
    public function Auth($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        if ($data === null) {
            // Les données JSON sont invalides
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Les données JSON sont invalides']);
            exit;
        }
        else{
            if (isset($data['password'])){
                $password = $data['password'];
                $email = $data['email'];
                $sql = $this->model->User_Auth($email,$password);
                $verif = $this->db->query($sql);
                if ($verif->num_rows > 0) {
                    $privateKey = 'OpenJobs';
                    $row = $verif->fetch_assoc();
                    $id = $row['id'];
                    $verif = $row['is_admin'];
                    if ($verif > 0) {
                        $adm = true;
                    }else{
                        $adm = false;
                    }
                    $tokenId = base64_encode(random_bytes(32));
                    $issuedAt = time();
                    $notBefore = $issuedAt;
                    $expire = $issuedAt + 3600;
    
                    $data = [
                        'iat'  => $issuedAt,
                        'jti'  => $tokenId,
                        'nbf'  => $notBefore,
                        'exp'  => $expire,
                        'data' => [ 
                            'user_id' => $id,
                            'email' => $email
                        ]
                    ];
    
                    $token = JWT::encode($data, $privateKey, 'HS256');
                    http_response_code(200);
                    echo json_encode(['token' => "$token", 'verif' => "True", "id" =>"$id", "adm" => $adm]);
                } else {
                    http_response_code(401);
                    echo json_encode(['message' => "connexion echouer !"]);
                    exit;
                }
                
            }
        }
    }


}