<?php
 //Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB and Coneect
$database = new Database();
$db = $database->connect();

//Instantiate blog
$post = new Post($db);

 // Blog post query
$result = $post->readPost();

$num = $result->rowCount();

// check if any post
if ($num > 0){
    //post array
    $post_arr = array();
    $post_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name,
        );
        //push to data
        array_push($post_arr['data'], $post_item);
    }
    //Turn to Json and output
    echo json_encode($post_arr);

}else{
    echo json_encode(
        array('message' => 'No Post Found')
    );
}