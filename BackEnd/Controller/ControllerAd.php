<?php

class AdController{
    private $model;
    private $db;
    public function __construct($model, $db){
        $this->model = $model;
        $this->db = $db;
    }


    public function postAd($data) {

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
            $title = $data['title'];
            $description = $data['description'];
            $id = $data['id']; 
            $salaire = $data['salaire'];
            $mission = $data['mission'];
            $localisation = $data['localisation'];
            $emploitype = $data['emploitype'];
            $competences= $data['competences'];
            $namecomp = $data['namecomp'];
            $sql = $this->model->createAd('advertisements', $title, $description, $id, $salaire, $mission, $localisation, $emploitype, $competences, $namecomp);
            if ($this->db->query($sql) === TRUE) {
                echo "Enregistrement ajouté avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $this->db->query($sql)->error;
            }
    
        }
    }
    public function GetAd(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        $sql = $this->model->GetAd('advertisements');
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
    public function GetAdById($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $id = $data;
        $sql = $this->model->getAdById('advertisements',$id);
        $result = $this->db->query($sql);
    
        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " ;
        } else {
            
            while ($row = $result->fetch_assoc()) {
                $data = $row;
            }
            // Retournez les données sous forme de JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
    public function GetAdByName($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $char = $data;
        $sql = $this->model->GetAd('advertisements');
        $result = $this->db->query($sql);
        $datadb = array();
        while ($row = $result->fetch_assoc()) {
            $datadb[] = $row;
        }
        $resultVal = array();
        foreach ($datadb as $val) {
            $textlower = str_replace(' ', '', strtolower($val["title"]));
            $texttocoomp = str_replace(' ', '', strtolower($char));
            $verifval = strpos($textlower,$texttocoomp);
            if( $verifval !== FALSE ) {
                $resultVal[] = $val;
            }
        };
        echo json_encode($resultVal);
    }
    public function GetAdByComp($data){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $char = $data;
        $sql = $this->model->GetAd('advertisements');
        $result = $this->db->query($sql);
        $datadb = array();
        while ($row = $result->fetch_assoc()) {
            $datadb[] = $row;
        }
        $resultVal = array();
        foreach ($datadb as $val) {
            $textlower = str_replace(' ', '', strtolower($val["namecomp"]));
            $texttocoomp = str_replace(' ', '', strtolower($char));
            $verifval = strpos($textlower,$texttocoomp);
            if( $verifval !== FALSE ) {
                $resultVal[] = $val;
            }
        };
        echo json_encode($resultVal);
    }
    public function PutAd($data) {
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
            $title = $data['title'];
            $description = $data['description'];
            $id = $data['id']; 
            $salaire = $data['salaire'];
            $mission = $data['mission'];
            $localisation = $data['localisation'];
            $emploitype = $data['emploitype'];
            $competences= $data['competences'];
            $namecomp = $data['namecomp'];
            $sql = $this->model->modifyAd('advertisements',$title, $description, $id, $salaire, $mission, $localisation, $emploitype, $competences, $namecomp);
           
            if ($this->db->query($sql) === TRUE) {
                echo "modfier avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $this->db->query($sql)->error;
            }
    
        }
    }
    public function deleteAd($data) {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        $id = $data;
        
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $sql = $this->model->deleteAd('advertisements', $id);
        $result = $this->db->query($sql);
    
        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->query($sql)->error;
        } else {
            
            header('Content-Type: application/json');
            echo json_encode(["message" => "delete"]);
        }
    }
}
