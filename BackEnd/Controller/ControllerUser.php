<?php
use Firebase\JWT\JWT;

require 'model/model.php';



class UserController{
    private $model;
    private $db;
    public function __construct($model, $db){
        $this->model = $model;
        $this->db = $db;
    }

    public function getUser(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        $sql = $this->model->getUser('user');
        $result = $this->db->query($sql);
        if ( $result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " ;
        } else {
            $datadb = array();
            while ($row = $result->fetch_assoc()) {
                $datadb[] = $row;
            }
            // Retournez les données sous forme de JSON
            header('Content-Type: application/json');
            echo json_encode($datadb);
        }

    }
    public function getUserById($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        if ($data === null ){
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Les données JSON sont invalides']);
            exit;
        }else{
            $id = $data;
            $sql = $this->model->getUserById('user', $id);
            $result = $this->db->query($sql);
           
            if ($result === FALSE){
                echo "Erreur :  " . $this->db->error;
               
            }else{
                $datadb =  $result->fetch_assoc();
                header('Content-Type: application/json');
                echo json_encode($datadb);
               
            }
        }
    }


    public function creatUser($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        if($data === null){
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Les données JSON sont invalides']);
            exit;
        }else{
            $name = $data["name"];
            $email = $data["email"];
            $surname = $data["surname"];
            $number = $data["number"];
            $password = $data["password"];
            $sql = $this->model->createUser('user', $name, $email, $surname, $number, $password);
            if ($this->db->query($sql) === TRUE) {
                $privateKey = 'OpenJobs';
                $sqlAuth = $this->db->query($this->model->getUserByEmail('user', $name));
                if ($sqlAuth->num_rows > 0) {
                    $row = $sqlAuth->fetch_assoc();
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
            }else{
                http_response_code(401);
                echo json_encode(["message"=> "connexion echouer"]);
            }

        }
    }

    public function modifyUser($data){
        
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        if ($data === null) {
            // Les données JSON sont invalides
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Les données JSON sont invalides']);
            exit;
        }
        else{
            $name = $data["name"];
            $email = $data["email"];
            $password = $data["password"];
            $surname = $data["surname"];
            $number = $data["number"];
            $id = $data["id"];
            $sql = $this->model->modifyUser('user', $name, $email, $password, $number, $surname, $id);
           
            if ($this->db->query($sql) === TRUE) {
                echo "modfier avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " ;
            }
        }
    }
    public function deleteUser($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        $id = $data["id"];
    
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $sql = $this->model->suppressionUser('user', $id);
        $result = $this->db->query($sql);

        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : ";
        } else {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            // Retournez les données sous forme de JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

}

