<?php
require_once "./config/Connection.php";
require_once "./mainmodule/Get.php";
require_once "./mainmodule/Auth.php";
require_once "./mainmodule/Global.php";

$db = new Connection();
$pdo = $db->connect();
$global = new GlobalMethods($pdo);
$get = new Get($pdo);
$auth = new Auth($pdo);

if (isset($_REQUEST['request'])) {
  $req = explode('/', rtrim($_REQUEST['request'], '/'));
} else {
  $req = array("errorcatcher");
}

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    $data = json_decode(file_get_contents("php://input"));
    switch ($req[0]) {

      case 'tests':
        if (count($req) > 1) {
          echo json_encode($get->get_common('tbl_tests', 'id=' . $req[1]));
        } else {
          echo json_encode($get->get_common('tbl_tests'));
        }
        break;

      case 'add_course':
        echo json_encode($global->insert('tbl_tests', $data));
        break;

      case 'update_course':
        echo json_encode($global->update('tbl_tests', $data));
        break;

      case 'delete_course':
        echo json_encode($global->delete('tbl_tests', 'id = ' . $req[1]));
        break;

      case 'register':
        echo json_encode($auth->register($data));
        break;

      case 'login':
        echo json_encode($auth->login($data));
        break;

      case 'forgot':
        echo json_encode($global->insert('tbl_forgot', $data));
        break;

      case 'user':
        if (count($req) > 1) {
          echo json_encode($get->get_common('tbl_users', 'id = ' . $req[1]));
        } else {
          echo json_encode($get->get_common('tbl_users'));
        }
        break;

      case 'user_exists':
        if (count($req) > 1) {
          echo json_encode($get->get_common('tbl_users', "email = '$data->email' "));
        } else {
          echo json_encode($get->get_common('tbl_users', "email = '$data->email' "));
        }
        break;

      case 'get_id':
        echo json_encode($get->get_last('tbl_users'));
        break;

      case 'update_user':
        echo json_encode($auth->update_user('tbl_users', $data));
        break;

      case 'delete_user':
        echo json_encode($global->delete('tbl_users', 'id = ' . $req[1]));
        break;

      default:
        echo "request not found";
        break;
    }
    break;

  case 'GET':
    $data = json_decode(file_get_contents("php://input"));
    switch ($req[0]) {

      case 'users':
        echo json_encode($get->get_common('tbl_users'));
        break;

      case 'completed':
        echo json_encode($get->get_common('tbl_completed'));
        break;

      default:
        echo "request not found";
        break;
    }
    break;
}
