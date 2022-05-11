<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and Coneect
$database = new Database();
$db = $database->connect();

//Instantiate blog
$categories = new Category($db);

// Blog post query
$result = $categories->readCategories();

$num = $result->rowCount();

if($num > 0){
    //category array
    $category_arr = array();
    $category_arr['data'] = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_items = array(
          'id' => $id,
          'category_name' => $category_name,
        );
        //push to data
        array_push($category_arr['data'],$category_items);
    }
    //Turn to Json and output
    echo json_encode($category_arr);
} else{
    echo json_encode(
        array('message' => 'No Category Found')
    );
}