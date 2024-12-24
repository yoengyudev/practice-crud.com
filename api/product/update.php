<?php
header('Content-Type: application/json');
if(!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['brand']) || !isset($_POST['price']) || !isset($_POST['stock'])){
    $response['result'] = false;
    $response['message'] = 'Please complete all field.';
    echo json_encode($response);
    exit();
 
}
$getData = json_decode(file_get_contents('../../storage/data/products.json'), true);
$response = [];
if (!is_array($getData)) {
    $response['result'] = false;
    $response['data'] = [];
    $response['message'] = "No data found.";
    echo json_encode($response);
    exit();
}

$productId = intval($_POST['id']);
$product_name = htmlspecialchars(strval($_POST['name']));
$brand = htmlspecialchars(strval($_POST['brand']));
$price = floatval($_POST['price']);
$stock = intval($_POST['stock']);


if (isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $imageType = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'image/svg+xml'
    ];

    if ($photo['size'] > 1048576) {
        $response['result'] = false;
        $response['data'] = [];
        $response['message'] = "Maximum size is 1MB.";
        echo json_encode($response);
        exit();
    }

    if (!in_array($photo['type'], $imageType)) {
        $response['result'] = false;
        $response['data'] = [];
        $response['message'] = "Please upload file jpeg, png, jpg, gif, webp, svg.";
        echo json_encode($response);
        exit();
    }
    
    $path = pathinfo($photo['name']);
    $extension = $path['extension'];
    $fineName = uniqid() . '.' . $path['extension'];
    copy($photo['tmp_name'], '../../storage/products/' . $fineName);
    foreach ($getData as &$data) {
        if ($data['id'] == $productId) {
            removeFile($data['image']);
            $data['name'] = $product_name;
            $data['price'] = $price;
            $data['brand'] = $brand;
            $data['stock'] = $stock;
            $data['image'] = $fineName;
            $response['result'] = true;
            $response['data'] = $data;
            $response['message'] = "Update product successfully.";
            echo json_encode($response);
            break;
        }
    }
} else {
    foreach ($getData as &$data) {
        if ($data['id'] == $productId) {
            $data['name'] = $product_name;
            $data['price'] = $price;
            $data['brand'] = $brand;
            $data['stock'] = $stock;
            $response['result'] = true;
            $response['data'] = $data;
            $response['message'] = "Update product successfully.";
            echo json_encode($response);
            break;
        }
    }
}

function removeFile($fileName)
{
    $getFile = scandir('../../storage/products');
    foreach ($getFile as $file) {
        if ($file === $fileName) {
            unlink('../../storage/products/' . $file);
            break;
        }
    }
}

file_put_contents('../../storage/data/products.json', json_encode($getData));

