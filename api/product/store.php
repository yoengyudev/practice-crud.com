<?php
header('Content-Type: application/json');
if(!isset($_POST['name']) || !isset($_POST['brand']) || !isset($_POST['price']) || !isset($_POST['stock']) || !isset($_FILES['image'])){
    $response['result'] = false;
    $response['message'] = 'Please complete all field.';
    echo json_encode($response);
    exit();
}

$getData = [];
$response = [];
$id = 1;

if (file_exists('../../storage/data/products.json')) {
    $getData = json_decode(file_get_contents('../../storage/data/products.json'), true);
    if(!empty($getData) && is_array($getData)) {
        $ids = array_column($getData, 'id');
        $id = max($ids) + 1;
    }else {
        $getData = [];
    }
}

$product_name = htmlspecialchars(strval($_POST['name']));
$brand = htmlspecialchars(strval($_POST['brand']));
$price = floatval($_POST['price']);
$stock = intval($_POST['stock']);
$photo = $_FILES['image'];

if (!is_dir('../../storage')) {
    mkdir('../../storage');
}

if(!is_dir('../../storage/products')){
    mkdir('../../storage/products');
}

if(!is_dir('../../storage/data')){
    mkdir('../../storage/data');
}

$imageType = [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif',
    'image/svg+xml'
];

// print_r($photo);

if($photo['size'] > 1048576) {
    $response['result'] = false;
    $response['message'] = "Maximum size is 1MB.";
    echo json_encode($response);
    exit();
}

if(!in_array($photo['type'], $imageType)) {
    $response['result'] = false;
    $response['message'] = "Please upload file jpeg, png, jpg, gif, webp, svg.";
    echo json_encode($response);
    exit();
} 

$path = pathinfo($photo['name']);
$extension = $path['extension'];
$fileName = uniqid() . '.' . $path['extension'];
copy($photo['tmp_name'], '../../storage/products/' . $fileName);


array_push($getData, [
    'id' => $id,
    'name' => $product_name,
    'brand' => $brand,
    'price' => $price,
    'stock' => $stock,
    'image' => $fileName,
]);

file_put_contents('../../storage/data/products.json', json_encode($getData));
$response['result'] = true;
$response['message'] = "Added product successfully.";

echo json_encode($response);
