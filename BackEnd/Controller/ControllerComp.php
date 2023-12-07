<?php


class ControllerComp{
    private $model;
    private $db;
    public function __construct($model, $db){
        $this->model = $model;
        $this->db = $db;
    }
    public function GetComp(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $sql = $this->model->getComp('compagnies');
        $result = $this->db->query($sql);
    
        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->query($sql)->error;
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

    public function postComp($data) {
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
            $name = $data['name'];
            $description = $data['description'];
            $adresse = $data['adresse'];
            
            $sql = $this->model->creatComp('compagnies', $name, $adresse, $description);
            if ($this->db->query($sql) === TRUE) {
                echo "Enregistrement ajouté avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $this->db->query($sql)->error;
            }
        }
    }
    public function PutComp($data) {
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
            $name = $data['name'];
            $description = $data['description'];
            $adresse = $data['adresse'];
            $sql = $this->model->modifyComp('compagnies', $name, $adresse, $description);
           
            if ($this->db->query($sql) === TRUE) {
                echo "modfier avec succès";
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement : " . $this->db->query($sql)->error;
            }
        }
    }
    public function deleteComp($data) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Les méthodes HTTP autorisées
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Les en-têtes autorisés

    
        $name = $data["name"];
        
        // Utilisez une requête SELECT pour obtenir les données de la base de données
        $sql = $this->model->deleteComp('compagnies',$name);
        $result = $this->db->query($sql);
    
        if ($result === FALSE) {
            echo "Erreur lors de l'exécution de la requête : " . $this->db->query($sql)->error;
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

