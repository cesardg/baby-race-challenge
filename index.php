<?php

// in deze opdracht maak ik gebruik van sessions de aangevinkte reacties tijdelijk op te slaan
session_start();
//session_destroy();

/*
ini_set('display_errors', true);
error_reporting(E_ALL);
*/

$routes = array(
  'home' => array(
    'controller' => 'Pages',
    'action' => 'index'
  ),
  'add' => array(
    'controller' => 'Pages',
    'action' => 'add'
  ),

  'detail' => array(
    'controller' => 'Pages',
    'action' => 'detail'
  ),

  'shop' => array(
    'controller' => 'Pages',
    'action' => 'shop'
  ),

  'cart' => array(
    'controller' => 'Orders',
    'action' => 'cart'
  ),

  'tipsQuestions' => array(
    'controller' => 'Pages',
    'action' => 'tipsQuestions'
  ),

  'galerij' => array(
    'controller' => 'Pages',
    'action' => 'galerij'
  ),

  'login' => array(
    'controller' => 'Users',
    'action' => 'login'
  ),
  'logout' => array(
    'controller' => 'Users',
    'action' => 'logout'
  ),
  'acount' => array(
    'controller' => 'Users',
    'action' => 'acount'
  ),
  'register' => array(
    'controller' => 'Users',
    'action' => 'register'
  )
);

if (empty($_GET['page'])) {
  $_GET['page'] = 'home';
}
if (empty($routes[$_GET['page']])) {
  header('Location: index.php');
  exit();
}

$route = $routes[$_GET['page']];
$controllerName = $route['controller'] . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();
