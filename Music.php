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

    public function insertMusic($name,$artist,$text,$month,$year)
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
             function convert($size) {
                $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
                return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
            }
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            echo '<br/><b>ประมวลผลใน: </b> '.round($time,4).' วินาที';
            echo '<br/><b>รับประทานหน่วยความจำไป:</b> ' . convert(memory_get_usage());
            echo '<br/><b>คำที่อาจจะตัดผิด:</b> ';
            foreach($result as $row)
            {
                if (mb_strlen($row) > 12)
                {
                    echo $row.'<br/>';
                }
            }
             echo '<hr/>';
            if ($result == null)
            {
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
        $data = preg_replace(array("/\^/", "/%/", "/~/", "/#/", "/*/","/@/", "/:/", "/\)/", "/\(/", "/{/"), "", $string);
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
        if(trim($keyword) != $data_word['word_text'] || $keyword == null ){
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
        }else if(trim($keyword) == $data_word['word_text'] ){
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
        $count =1 ;
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
}

?>