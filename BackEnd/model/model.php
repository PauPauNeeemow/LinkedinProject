<?php


class UserModel{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function getUser($Tabname){
        $sql = "SELECT * FROM $Tabname";
        return $sql;
    }
    public function getUserById($Tabname, $id){
        $sql = "SELECT * FROM $Tabname WHERE id = $id";
        return $sql;
    }
    public function getUserByEmail($Tabname, $name){
        $sql = "SELECT * FROM $Tabname WHERE name = '$name'";
        return $sql;
    }
    public function createUser($Tabname, $name,$surname, $email, $password, $number){
        $sql = "INSERT INTO $Tabname (name, email, password ,surname, number) VALUES ('$name', '$email', '$surname','$password', '$number')";
        return $sql;
    }
    public function modifyUser($Tabname, $name, $email, $password, $number, $surname, $id){
        $sql = "UPDATE $Tabname SET name = '$name', email = '$email', password = '$password', number = '$number', surname = '$surname'  WHERE id = '$id'";
        return $sql;
    }
    public function deleteUser($Tabname, $id){
        $sql = "DELETE FROM $Tabname WHERE id = $id";
        return $sql;
    }
}

class ModelAd{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function GetAd($Tabname){
        $sql = "SELECT * FROM $Tabname";
        return $sql;
    }
    public function getAdById($Tabname, $id){
        $sql = "SELECT * FROM $Tabname WHERE id = '$id'";
        return $sql;
    }
    public function createAd($Tabname, $title, $description ,$id, $salaire, $mission, $localisation, $emploitype, $competences, $namecomp){
        $sql = "INSERT INTO $Tabname ( title, description,id, salaire, mission, localisation, emploitype, competences, namecomp) VALUES ('$title', '$description','$id', '$salaire', '$mission', '$localisation', '$emploitype', '$competences', '$namecomp')";
        return $sql;
    }
    public function modifyAd($Tabname, $title, $description, $id, $salaire, $mission, $localisation, $emploitype, $competences, $namecomp){
        $sql = "UPDATE $Tabname SET title = '$title', description = '$description', salaire = '$salaire', mission = '$mission', localisation = '$localisation', emploitype = '$emploitype', competences = '$competences', namecomp = '$namecomp' WHERE id = '$id'";
        return $sql;
    }
    public function deleteAd($Tabname, $id){
        $sql = "DELETE FROM $Tabname WHERE id = '$id'";
        return $sql;
    }
}

class AuthModel{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function User_Auth($email,$password){
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        return $sql;
    }
    public function User_Auth_admin($id, $email,$password){
        $sql = "SELECT * FROM userAdmin WHERE id = '$id' AND email = '$email' AND password = '$password'";
        return $sql;
    }
    public function User_Auth_log_verif($id, $token){
        return $sql = "SELECT * FROM login_logs WHERE idUser = '$id'";
    }
    public function User_Auth_log_Update($id,$token){
        return $sql = "UPDATE login_logs SET  token = $token, WHERE idUser = $id";
    }
    public function User_Auth_log_creat($id, $token){
        return $sql = "INSERT INTO login_logs (idUser , token) VALUES ('$id','$token')";
    }
}
class ModelComp{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function getComp($Tabname){
        $sql = "SELECT * FROM $Tabname";
        return $sql;
    }
    public function creatComp($Tabname, $name, $adresse, $description){
        $sql = "INSERT INTO $Tabname (name ,adresse, description) VALUES ('$name','$adresse', '$description')";
        return $sql;
    }
    public function modifyComp($Tabname, $name, $adresse, $description){
        $sql = "UPDATE $Tabname SET name = $name, adresse = $adresse, description = $description WHERE name = $name";
        return $sql;
    }
    public function deleteComp($Tabname, $name){
        $sql = "DELETE FROM $Tabname WHERE id = $name";
        return $sql;
    }
}


class ModelApply{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function GetApply($Tabname){
        $sql = "SELECT * FROM $Tabname";
        return $sql;
    }
    public function getApplyById($Tabname, $id){
        $sql = "SELECT * FROM $Tabname WHERE idUser = $id";
        return $sql;
    }
    public function getApplyByIdUser($Tabname, $id){
        $sql = "SELECT * FROM $Tabname WHERE idAd = $id";
        return $sql;
    }
    public function createApply($Tabname, $email, $idUser, $idAd, $idComp, $name, $message, $emailSend){
        $sql = "INSERT INTO $Tabname (email , idUser, idAd, idComp, name, message, emailSend) VALUES ('$email','$idUser', '$idAd', '$idComp', '$name','$message','$emailSend')";
        return $sql;
    }
    public function modifyApply($Tabname, $email, $idUser){
        $sql = "UPDATE $Tabname SET email = $email WHERE idUser = $idUser";
        return $sql;
    }
}






