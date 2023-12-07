<?php

require 'Controller/ControllerUser.php';
require 'Controller/ControllerAd.php';
require 'Controller/Auth.php';
require 'Controller/ControllerComp.php';
require 'Controller/ControllerApply.php';
require 'vendor/autoload.php'; 

$dotenv = Dotenv\Dotenv::createImmutable("../"); 
$dotenv->load();
$uri = $_SERVER['REQUEST_URI'];
$servername = $_ENV["DB_HOST"];
$username = $_ENV["DB_USER"];
$dbpassword = $_ENV["DB_PASSWORD"];
$dbname = $_ENV["DB_NAME"];
$db = new mysqli($servername, $username, $dbpassword, $dbname);
$userController = new UserController(new UserModel($db), $db);
$adController = new AdController(new ModelAd($db),$db);
$compController = new ControllerComp(new ModelComp($db),$db);
$authController = new AuthContoller(new AuthModel( $db),$db);
$applyController = new ApplyController(new ModelApply( $db),$db);
$patterne = '~^/api/advertissements/(\d+)$~';
$patterne2 = '~^/api/user/(\d+)$~';
$patterne3 = '~^/api/advertissements/(\w+)$~';
$patterne4 = '~^/api/advertissements/comp/(\w+)$~';
$patterne5 = '~^/api/information/(\d+)$~';

$uriParts = parse_url($uri);
if (isset($uriParts['path'])){
    $urlPath = $uriParts['path'];

}
else{
    $urlPath = '';
}
switch($urlPath){
    case (preg_match($patterne, $urlPath, $matches)) === 1:
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $data = $matches[1];
                $adController->GetAdById($data);
                break;
            case 'DELETE':
                $data = $matches[1]; 
                $adController->deleteAd($data);
                break;
            case 'OPTIONS':
                header("Access-Control-Allow-Origin: http://localhost:3000");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
                header("Access-Control-Allow-Headers: Content-Type, Authorization");
                http_response_code(200); // Réponse 200 OK
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
        }
        break;
    case '/api/mail':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $applyController-> postMail($data);
        }
    case '/api/user':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $userController->creatUser($data);
                break;
            case 'GET':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $userController->getUser();
                break;
            case 'PUT':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $userController->modifyUser($data);
                break;
            case 'DELETE':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $userController->deleteUser($data);
                break;
            case 'OPTIONS':
                header("Access-Control-Allow-Origin: http://localhost:3000");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
                header("Access-Control-Allow-Headers: Content-Type, Authorization");
                http_response_code(200); // Réponse 200 OK
                break;
                
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
            }
            break;
    case (preg_match($patterne2, $urlPath, $matches)) === 1:
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $data = $matches[1];
                $userController->getUserById($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
        }
        break;
    case (preg_match($patterne5, $urlPath, $matches)) === 1:
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $data = $matches[1];
                $applyController->getApplyById($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
        }
        break;
    case (preg_match($patterne3, $urlPath, $matches)) === 1:
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $data = $matches[1];
                $adController->GetAdByName($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
        }
        break;
    case (preg_match($patterne4, $urlPath, $matches)) === 1:
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $data = $matches[1];
                $adController->GetAdByComp($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
        }
        break;
    case '/api/advertissements':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $adController->postAd($data);
                break;
            case 'GET':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $adController->GetAd();
                
                break;
            case 'PUT':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $adController->PutAd($data);
                break;
            case 'DELETE':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $adController->deleteAd($data);
                break;
            case 'OPTIONS':
                header("Access-Control-Allow-Origin: http://localhost:3000");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
                header("Access-Control-Allow-Headers: Content-Type, Authorization");
                http_response_code(200); // Réponse 200 OK
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
            }
            break;
   
    case '/api/login':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $authController->Auth($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
            }
            break;
    case '/api/login/verif':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $authController->AuthVerif($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
            }
            break;
    case '/api/compagnies':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $compController->postComp($data);
                break;
            case 'GET':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $compController->GetComp();
                break;
            case 'PUT':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $compController->PutComp($data);
                break;
            case 'DELETE':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $compController->deleteComp($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
            }
            break;
    case '/api/information':
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $applyController->postApply($data);
                break;
            case 'GET':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $applyController->GetApply();
                
                break;
            case 'PUT':
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $applyController->PutApply($data);
                break;
            default:
                // Méthode non autorisée
                http_response_code(405);
                break;
            }
            break;
    default:
        // Les données JSON sont invalides
        http_response_code(500); // Bad Request
        echo json_encode(['message' => $urlPath]);
        exit;


}
// Gérer les routes en fonction de la méthode HTTP
