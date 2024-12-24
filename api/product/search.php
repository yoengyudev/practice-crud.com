<?php
header('Content-Type: application/json');
if(!isset($_GET['search'])){
    $response['result'] = false;
    $response['message'] = 'No keyword provided.';
    echo json_encode($response);
    exit();
}
$getData = json_decode(file_get_contents('../../storage/data/products.json'), true);
$response = [];

if (!is_array($getData)) {
    $response['result'] = false;
    $response['data'] = [];
    $response['message'] = "No data.";
    echo json_encode($response);
    exit();
}

$search = htmlspecialchars($_GET['search']);
$baseUrl = "http://practice-crud.com/storage/products/";

function checkStock(&$getData){
    foreach ($getData as &$data) {
        if ($data['stock'] < 1) {
            $data['status'] = 'Out of Stock';
        }elseif($data['stock'] <= 10) {
            $data['status'] = 'Low Stock';
        }elseif($data['stock'] > 10) {
            $data['status'] = 'In Stock';
        }
    }
}
checkStock($getData);

foreach ($getData as $data) {
    if (strtolower($data['name']) == strtolower($search)) {
        $response['result'] = true;
        $data['image'] = $baseUrl . $data['image'];
        $response['data'] = [
            'products' => [$data],
            'total' => number_format($data['price'] * $data['stock'])
        ];
        $response['message'] = "Product found.";
        break;
    } else {
        $response['result'] = false;
        $response['data'] = [];
        $response['message'] = "Product not found.";
    }
}

echo json_encode($response);
