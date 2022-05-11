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

// Get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get Post
$post->readSinglePost();

//Create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' =>$post->body,
    'author' =>$post->category_id,
    'category_name' => $post->category_name
);

//make Json
print_r(json_encode($post_arr) );