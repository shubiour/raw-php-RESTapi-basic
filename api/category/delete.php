<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and Coneect
$database = new Database();
$db = $database->connect();

//Instantiate blog
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID
$category->id = $data->id;


//delete Post
if($category->deleteCategory()){
    echo json_encode(
        array('message' => 'Post Delete')
    );
}else{
    echo json_encode(
        array('message' => 'Post Not Deleted')
    );
}