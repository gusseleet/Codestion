<?php
// PDO connect *********
function connect() {
    return new PDO('mysql:host=blu-ray.student.bth.se;dbname=guel12', 'guel12', 'Bw6vs7(J', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM phpmvc_kmom04_tags WHERE _name LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
    // put in bold the written text
    $tag = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['_name']);
    // add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['_name']).'\')">'.$tag.'</li>';
}
?>

