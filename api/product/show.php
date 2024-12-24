<?php
header('Content-Type: application/json');
if(!isset($_GET['productId'])){
    $response['result'] = false;
    $response['message'] = 'No id provided.';
    echo json_encode($response);
    exit();
}
$getData = json_decode(file_get_contents('../../storage/data/products.json'), true);
$productId = intval($_GET['productId']);
$response = [];

if (!is_array($getData)) {
    $response['result'] = false;
    $response['data'] = [];
    $response['message'] = "No data found.";
    echo json_encode($response);
    exit();
}


$baseUrl = "http://practice-crud.com/storage/products/";


foreach ($getData as &$data) {
    if ($data['id'] == $productId) {
        $response['result'] = true;
        $data['image'] = $baseUrl . $data['image'];
        $response['data'] = $data;
        $response['message'] = "Product found.";
        echo json_encode($response);
        exit();
    }
}
