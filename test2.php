<?php 
$arr = [
    '1' => 'เขา', 
    '2' => 'เขา', 
    '3' => 'ฉัน', 
    '4' => 'เธอ',
];

$arrDB = [
    'text' => 'เขา', 
];
echo'<pre>';
print_r($arr);
//print_r($arrDB);
for ($i=0; $i <= count($arr) ; $i++) { 
    echo'<pre>';
    print_r($arr[$i]).'<br>';
//    if($arr[$i] == $arrDB['text']  ){
//        echo $arrDB['text'];
//    }else{
//      echo'ไม่ซ้ำ'.'<br>';
//    }
}

