<?php

//引用資料庫連線
require_once('../../db.inc.php');

//先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `PImg` FROM `product` WHERE `PId` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);

//加入繫結陣列
$arrGetImgParam = [
    $_GET['deleteId']
];

//執行 SQL 語法
$stmtGetImg->execute($arrGetImgParam);

//若有找到 studentImg 的資料
if($stmtGetImg->rowCount() > 0) {
    //取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

    //若是 studentImg 裡面不為空值，代表過去有上傳過
    if($arrImg[0]['PImg'] !== NULL){
        //刪除實體檔案
        @unlink("./files/".$arrImg[0]['PImg']);
    }     
}

//SQL 語法
$sql = "DELETE FROM `product` WHERE `PId` = ? ";

$arrParam = [
    $_GET['deleteId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    echo "<script>alert('刪除成功');</script>";
    header("Refresh: 0; url=./Instrument_index.php");
    // echo "刪除成功";
} else {
    header("Refresh: 3; url=./Instrument_index.php");
    echo "刪除失敗";
}