<?php


include "config.php";
include "utils.php";


$dbConn =  connect($db);



/*
  listar todos los posts o solo uno
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

   
        if (isset($_GET['id']) && !isset($_GET['function'])){

              $sql = $dbConn->prepare("SELECT * FROM user where id=:id");
              $sql->bindValue(':id', $_GET['id']);
              $sql->execute();
              header("HTTP/1.1 200 OK");
              echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
              exit();

        }else{
            
             switch ($_GET['function']) {
                
               case 'all':
                    $existsShops = false;
                    $resp = getAllShop( $dbConn );
                    if( is_object($resp) ){
                        $existsUser = true;
                        $data = array(
                        'status' => 'success',
                        'exists' => $existsShops,
                        'shops' => $resp
                        );
                    }else{
                        $data = array(
                            'status' => 'success',
                            'exists' => $existsShops,
                            'shops' => $resp
                        );
                    }

                    header("Content-type: application/json; charset=utf-8");
                    echo json_encode($data);

                    exit();
                break;

                case 'getByPage':
                    $page = (isset($_GET['page'])) ? $_GET['page'] : null;
                    $existsShops = false;
                    $resp = getShopByPage( $page, $dbConn );
                    
                    if( is_object($resp) ){
                        $existsUser = true;
                        $data = array(
                        'status' => 'success',
                        'exists' => $existsShops,
                        'shops' => $resp
                        );
                    }else{
                        $data = array(
                            'status' => 'success',
                            'exists' => $existsShops,
                            'shops' => $resp
                        );
                    }

                    header("Content-type: application/json; charset=utf-8");
                    echo json_encode($data);

                    exit();
                break;
               

            }

    }

}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>
