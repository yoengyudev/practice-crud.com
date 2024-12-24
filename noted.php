<?php

// I can update assoicative array by using its index

$data = [
    ['id' => 1, 'name' => 'Yoeng Yu', 'sex' => 'male', 'position' => 'Web Developer'],
    ['id' => 2, 'name' => 'Yu Yoeng', 'sex' => 'male', 'position' => 'Mobile App Developer'],
    ['id' => 3, 'name' => 'Muny Nhan', 'sex' => 'male', 'position' => 'Electronic Engineer'],
    ['id' => 4, 'name' => 'Nh Muny', 'sex' => 'male', 'position' => 'Electronic Software'],
];

$header = ['ID', 'Name', 'Sex', 'Position'];


foreach ($header as $head) {
    echo $head . " ";
}

echo "<br>";
echo "Before Update";

foreach ($data as $item) {
    echo $item['id'] . " ";
    echo $item['name'] . " ";
    echo $item['sex'] . " ";
    echo $item['position'] . " ";
    echo "<br>";
}

echo "<br>";

// update the position via its index
foreach ($data as $index => $val) {
    if ($val['id'] == 3) {
        $data[$index]['position'] = 'Senior Electronic Engineer';
    }
};

foreach ($data as $index => $item) {
    if($item['id'] == 2) {
        array_splice($data, $index, 1);
    }
}

foreach ($data as $item) {
    echo $item['id'] . " ";
    echo $item['name'] . " ";
    echo $item['sex'] . " ";
    echo $item['position'] . " ";
    echo "<br>";
}


$photo = null;
if(isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
}

$filename = '';

if($photo) {
    $paht = pathinfo($photo['name']);
    $filename = uniqid() . '.' . $path['extension'];
    copy($photo['tmp_name'], '/storage/products/' . $filename);
}

if($filename) {
    $photoPath = '/storage/products/' . $filename;
    if(file_exists($photoPath)) {
            unlink($photoPath);
    }
}


// you can check if user does not give the photo so you can add it as null value in field photo
$photo ? $filePath : null;

// I have to remember that if the data does not exist it will return false. How it possible for false
// example the data = null, empty string, undefined
