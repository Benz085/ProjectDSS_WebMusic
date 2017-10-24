<?php
require_once 'connect.php';
include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'thsplitlib-master/THSplitLib/segment.php');

/**
 *  คัดตัดข้อความ Music
 */
class Music
{

    function __construct()
    {
        $database = new DataBase();
        $con = $database->getDB();
        $this->db = $con;
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function runQuery($sql)
    {
        $stmt = $this->db->prepare($sql);
        return $stmt;
    }

    public function insertMusic($name, $artist, $text, $month, $year)
    {
        $stmt = $this->db->prepare("INSERT INTO `text_music`(`Artist`, `name_music`, `Music_text`, `Music_month`, `Music_year`) 
                VALUES(:artist,:name,:text,:month,:year)");
        $stmt->bindParam(':artist', $artist, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':text', $text, PDO::PARAM_STR);
        $stmt->bindParam(':month', $month, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt == null) {
            return false;
        } else {
            return true;
        }
    }

    public function processText($DATA_MUSIC)
    {
        if ($DATA_MUSIC != null) {
            # code...
            $time_start = microtime(true);
            $text_to_segment = trim($DATA_MUSIC);
            // echo $text_to_segment;
            // echo '<hr/>';
            //echo '<b>ประโยคที่ต้องการตัดคือ: </b>' . $text_to_segment . '<br/>';
            $segment = new Segment();
            //echo '<hr/>';
            $result = $segment->get_segment_array($DATA_MUSIC);
            echo implode(' | ', $result);
            function convert($size)
            {
                $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
                return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
            }

            $time_end = microtime(true);
            $time = $time_end - $time_start;
            echo '<br/><b>ประมวลผลใน: </b> ' . round($time, 4) . ' วินาที';
            echo '<br/><b>รับประทานหน่วยความจำไป:</b> ' . convert(memory_get_usage());
            echo '<br/><b>คำที่อาจจะตัดผิด:</b> ';
            foreach ($result as $row) {
                if (mb_strlen($row) > 12) {
                    echo $row . '<br/>';
                }
            }
            echo '<hr/>';
            if ($result == null) {
                return false;
            } else {
                return json_encode($result);
            }
        } else {
            # code...
            echo "NO DATA MUSIC";
        }
    }

    public function specialAlphabet($string)
    {
        setlocale(LC_ALL, 'fr_CA.utf8');
        $data = preg_replace('/[^0-9A-Za-zก-ฮ๐-๙]/', "", $string);
        $data = preg_replace(array("/\^/", "/%/", "/~/", "/#/", "/*/", "/@/", "/:/", "/\)/", "/\(/", "/{/"), "", $string);
        if ($data == null) {
            return false;
        } else {
            return json_encode($data);
        }
    }

    public function wordText($keyword)
    {
        //echo $keyword.'<br>';
        $sql = ("SELECT * FROM `words`  WHERE (word_text=:keyword) LIMIT 1");
        $res = $this->db->prepare($sql);
        $res->execute(array(':keyword' => trim($keyword)));
        $data_word = $res->fetch(PDO::FETCH_ASSOC);
        // if($data_word['word_text'] == null){
        //     echo 'NULL'.'<br>';
        // }else{
        //     echo 'NO NULL'.'<br>';
        // }
        //print_r($data_word);
        if (trim($keyword) != $data_word['word_text'] || $keyword == null) {
            $count = 1;
            $stmt = $this->db->prepare("INSERT INTO `words`(`word_text`,`count`)VALUES(:word_text,:count) ");
            $stmt->bindParam(':word_text', trim($keyword), PDO::PARAM_STR);
            $stmt->bindParam(':count', $count, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt == null) {
                return false;
            } else {
                return true;
            }
        } else if (trim($keyword) == $data_word['word_text']) {
            $total = $data_word['count'] + 1;
            $stmt = $this->db->prepare("UPDATE `words` SET `count`=:total WHERE word_id=:word_id");
            $stmt->bindParam(':word_id', $data_word['word_id'], PDO::PARAM_STR);
            $stmt->bindParam(':total', $total, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt == null) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function checkWord($id)
    {
        $count = 1;
        $stmt = $this->db->prepare("INSERT INTO `check_words`(`id`, `check_words`)VALUES(:id,:count) ");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':count', $count, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt == null) {
            return false;
        } else {
            return true;
        }
    }

    //เฉย (nonlove)
    public function nonLove($strArr)
    {
        //echo '<pre>';
        //print_r($strArr);
        $nonLove = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "รู้สึก":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "ลืม":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "เหงา":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "ไม่มีใคร":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "ปล่อย":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "ทิ้ง":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "กลัว":
                    $strArr[$i];
                    ($nonLove++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($nonLove++);
                    break;
            }
        }
        $arr = [
            'nonLove' => $nonLove,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    //ชอบ (Liking)
    public function liKing($strArr)
    {
        $liKing = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "หวง":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "รู้สึก":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "เหลือเกิน":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "ชอบ":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "คิดถึง":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "แอบ":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "รอ":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "หัวใจ":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "ใจ":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "รัก":
                    $strArr[$i];
                    ($liKing++);
                    break;
                case "ให้":
                    $strArr[$i];
                    ($liKing++);
                    break;
            }
        }
        $arr = [
            'liKing' => $liKing,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    //รักแรกพบ (Infatuated Love)
    public function inFatuatedLove($strArr)
    {
        $inFatuatedLove = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "รู้สึก":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "ชอบ":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "คิดถึง":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "เห็น":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "ขอ":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "ฝัน":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "บอก":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "หัวใจ":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "อยาก":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "ใจ":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "รัก":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
                case "ให้":
                    $strArr[$i];
                    ($inFatuatedLove++);
                    break;
            }
        }
        $arr = [
            'inFatuatedLove' => $inFatuatedLove,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    //หมดรัก (Empty Love)
    public function emptyLove($strArr)
    {
        $emptyLove = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "น่าละอาย":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "รู้สึก":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "แพ้":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "ทรมาน":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "เสียใจ":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "เจ็บ":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "น้ำตา":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "สุดท้าย":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "ทิ้ง":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "กลัว":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "ใจ":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "รัก":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
                case "ให้":
                    $strArr[$i];
                    ($emptyLove++);
                    break;
            }
        }
        $arr = [
            'emptyLove' => $emptyLove,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    //รักโรแมนติก (Romantic Love)
    public function romanticLove($strArr)
    {
        $romanticLove = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "รู้สึก":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "เหลือเกิน":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "คิดถึง":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "แฟน":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "กอด":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "ที่รัก":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "หัวใจ":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "ใจ":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "รัก":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
                case "ให้":
                    $strArr[$i];
                    ($romanticLove++);
                    break;
            }
        }
        $arr = [
            'romanticLove' => $romanticLove,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    //Fatuous Love เป็นความรักที่มีข้อผูกมัด และความรู้สึกหลงใหล แต่ปราศจากความผูกพัน
    public function fatuousLove($strArr)
    {
        $fatuousLove = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "หวง":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "รู้สึก":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "เหลือเกิน":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "คิดถึง":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "แฟน":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "กอด":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "ที่รัก":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "หัวใจ":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "ใจ":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "รัก":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;
                case "ให้":
                    $strArr[$i];
                    ($fatuousLove++);
                    break;

            }
        }
        $arr = [
            'fatuousLove' => $fatuousLove,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    // Fatuous Love เป็นความรักที่มีข้อผูกมัด และความรู้สึกหลงใหล แต่ปราศจากความผูกพัน และความใกล้ชิดผูกพัน
    public function conSumMateLove($strArr)
    {
        $conSumMateLove = 0;
        for ($i = 0; $i < count($strArr); $i++) {
            switch ($strArr[$i]) {
                case "รู้สึก":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "ดูแล":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "เหลือเกิน":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "ชอบ":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "คิดถึง":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "แฟน":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "กอด":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "ที่รัก":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "ความรัก":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "หัวใจ":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "ใจ":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "รัก":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
                case "ให้":
                    $strArr[$i];
                    ($conSumMateLove++);
                    break;
            }
        }
        $arr = [
            'conSumMateLove' => $conSumMateLove,
        ];

        if ($arr == null) {
            return false;
        } else {
            return json_encode($arr);
        }
    }

    public function insert_data($musicID,$nonLove,$liKing,$inFatuatedLove,$emptyLove,$romanticLove,$fatuousLove ,$conSumMateLove)
    {
        try{
            $count = $nonLove +
                $liKing +
                $inFatuatedLove +
                $emptyLove +
                $romanticLove +
                $fatuousLove +
                $conSumMateLove;
            $stmt = $this->db->prepare("INSERT INTO `emotion_love`(`musicID`, `count`, `nonLove`, `liKing`, `inFatuatedLove`, `emptyLove`, `romanticLove`, `fatuousLove`, `conSumMateLove`)
                                    VALUES(:musicID,:count,:nonLove,:liKing,:inFatuatedLove,:emptyLove,:romanticLove,:fatuousLove,:conSumMateLove) ");

            $stmt->bindParam(':musicID', $musicID, PDO::PARAM_STR);
            $stmt->bindParam(':count', $count, PDO::PARAM_STR);
            $stmt->bindParam(':nonLove', $nonLove, PDO::PARAM_STR);
            $stmt->bindParam(':liKing', $liKing, PDO::PARAM_STR);
            $stmt->bindParam(':inFatuatedLove', $inFatuatedLove, PDO::PARAM_STR);
            $stmt->bindParam(':emptyLove', $emptyLove, PDO::PARAM_STR);
            $stmt->bindParam(':romanticLove', $romanticLove, PDO::PARAM_STR);
            $stmt->bindParam(':fatuousLove', $fatuousLove, PDO::PARAM_STR);
            $stmt->bindParam(':conSumMateLove', $conSumMateLove, PDO::PARAM_STR);
            $stmt->execute();


            $stmt2 = $this->db->prepare("UPDATE `text_music` SET `isActive` = '1' WHERE `text_music`.`Music_id` =:musicID;");
            $stmt2->bindParam(':musicID', $musicID, PDO::PARAM_STR);
            $stmt2->execute();

            if ($stmt == null) {
                return false;
            } else {
                return true;
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }
}

?>