<?php
header('Content-Type: application/json');
if(!isset($_GET['productId'])){
    $response['result'] = false;
    $response['message'] = 'No id provided.';
    echo json_encode($response);
    exit();
 
}

$getData = json_decode(file_get_contents('../../storage/data/products.json'), true);
$response = [];
if (empty($getData) || !is_array($getData)) {
    $response['result'] = false;
    $response['data'] = [];
    $response['message'] = 'invalid data';
    echo json_encode($response);
    exit();
}

$productId = intval($_GET['productId']);

foreach ($getData as $key => $data) {
    if ($data['id'] == $productId) {
        deleteImage($data['image']);
        unset($getData[$key]);
        break;
    }
}

function deleteImage($url) {
    $scan = scandir('../../storage/products');
    foreach ($scan as $file){
        if($file == $url) {
            unlink('../../storage/products/'. $file);
            break;
        }
    }
}

$Data = array_values($getData);

file_put_contents('../../storage/data/products.json', json_encode($Data));

$response['result'] = true;
$response['message'] = 'Delete products successfully.';
echo json_encode($response);