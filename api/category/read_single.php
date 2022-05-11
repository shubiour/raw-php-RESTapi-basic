<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog
$categories = new Category($db);

// Get ID
$categories->id = isset($_GET['id']) ? $_GET['id'] : die();
//Get category
$categories->readSingleCategories();

//Create array
$post_arr = array(
    'id' => $categories->id,
    'category_name' => $categories->category_name
);

//make Json
print_r(json_encode($post_arr) );