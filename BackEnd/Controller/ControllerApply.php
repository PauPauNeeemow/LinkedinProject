<?php

class ApplyController {

    private $model;
    private $db;
    public function __construct($model, $db) {
        $this->model = $model;
        $this->db = $db;
    }


    public function postMail($data) {
        $email = $data["email"];
        $compemail = "dedjoris09gmail.com";
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = $email;
        $to = $compemail;
        $subject = "Mail de Candidature";
        $message = $data["message"];
        $headers = "De :" . $from;
        mail($to,$subject,$message, $headers);
        echo "L'email a été envoyé.";
    }

    public function postApply($data) {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        if ($data === null) {
            // Les données JSON sont invalides
            http_response_code(400); // Bad Request
            echo json_encode(['message' => 'Les données JSON sont invalides']);
            exit;
        }
        else {
            $email = $data['email'];
            $idUser = $data['idUser'];
            $idAd = $data['idAd'];
            $idComp = $data['idComp'];
            $name = $data['name'];
            $message = $data['message'];
            $emailSend = $data['emailSend'];
            $sql = $this->model->createApply('information', $email, $idUser, $idAd, $idComp, $name, $message, $emailSend);
            if ($this->db->query($sql) === TRUE) {
                echo "Enregistrement ajouté avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $this->db->query($sql)->error;
            }
        }

    }
    public function getApplyById($data) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $id = $data;
        $sql = $this->model->getApplyById('information',$id);
        $result = $this->db->query($sql);
    
        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " ;
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

    public function GetApply(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        $sql = $this->model->GetApply('information');
        $result = $this->db->query($sql);

        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " . $$this->db->query($sql)->error;
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

    public function GetApplyByIdUser($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $id = $data;
        $sql = $this->model->GetApplyByIdUser('information',$id);
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

    public function PutApply($data) {
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
            $email = $data['emailsend'];
            $idUser = $data['idUser'];
            $sql = $this->model->modifyApply('information', $email, $idUser);

            if ($this->db->query($sql) === TRUE) {
                echo "modfier avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $this->db->query($sql)->error;
            }
        }
    }

}


?>