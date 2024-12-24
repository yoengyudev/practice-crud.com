<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$getData = json_decode(file_get_contents('../../storage/data/products.json'), true);
$response = [];
$total = 0;

if (!is_array($getData) || empty($getData)) {
    $response['result'] = false;
    $response['data'] = [];
    $response['message'] = "No data found.";
    echo json_encode($response);
    exit();
}


$baseUrl = "http://practice-crud.com/storage/products/";

foreach ($getData as &$data) {
    $data['image'] = $baseUrl . $data['image'];
}

function getTotal(&$getData) {
    global $total;
    foreach ($getData as $data) {
        $total += $data['price'] * $data['stock'];
    }
    return $total;
}

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


$response['result'] = true;
$response['data'] = [
    'products' => $getData,
    'total' => number_format(getTotal($getData), 2),
];
$response['message'] = "Data get successful.";

echo json_encode($response);

