<?php
require_once 'Music.php';
$Music = new Music();



$stmt = $Music->runQuery("SELECT * FROM `mouth`");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(isset($_GET['ID_cut'])){
    $id = $_GET['ID_cut'];
    
    $stmt = $Music->runQuery("SELECT Music_text FROM text_music
                              WHERE text_music.Music_id=:id");
    $stmt->execute(array(':id' => $id));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt1 = $Music->runQuery("SELECT * FROM `text_music` WHERE Music_id=:id");
    $stmt1->execute(array(':id' => $id));
    $data1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    //echo '<pre>';
    //print_r($data);
    $DATA_MUSIC = implode(" ",$data);
}else{
    echo 'NO ID';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Project Music</title>
    <?php include 'head.php'; ?>
</head>

<body>

    <div id="wrapper">

       
        <?php include 'menu.php'; ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ข้อมูลเพลง : <?php  echo "ID : ".$id; ?> </h1>  
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                          <i class="fa fa-bell fa-fw"></i> เนื้อเพลง : : <?= $data1['name_music']; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                              <?= $DATA_MUSIC; ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->    
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> เพลงทีออกในแต่ละเดือน
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <?php 
                                $CUT_DATA = $Music->processText($DATA_MUSIC);
                                //echo $CUT_DATA ;
                                echo "<hr>";
                                $MUSIC_STRING = json_decode($CUT_DATA);
                                // echo "<pre>";
                                // print_r($MUSIC_STRING);
                                echo count($MUSIC_STRING);
                            ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->    
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i>คำในเพลง
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <?php 
                            $stmt = $Music->runQuery("SELECT id FROM `check_words` WHERE id=:id");
                            $stmt->execute(array(':id' => $id));
                            $data = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo'<pre>';
                            print_r($data);
                            echo '<hr>';
                            if($data['id'] == $id){
                               echo '<div class="alert alert-success" role="alert">มี DATA แล้ว </div>';    
                            }else{
                                $Music->checkWord($id);
                                for ($i=0; $i < count($MUSIC_STRING) ; $i++) { 
                                    $Music->wordText($MUSIC_STRING[$i]);
                                    //$MUSIC_STRING[$i].'<br>';
                                }
                                if ($Music == null) {
                                echo '<div class="alert alert-danger" role="alert"> 
                                <strong>Oh snap!</strong> No Insert SQL Fail </div>';
                                }else {
                                echo '<div class="alert alert-success" role="alert"> 
                                <strong>Oh snap!</strong> Sucessfull <a href="http://localhost/ProjectDSS_WebMusic/data.php" class="btn btn-info" role="button">กลับ</a></a></div>';
                                }
                            }
                                
                               
                            ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->    
                </div>
            </div>

    </div>
    <!-- /#wrapper -->

   <?php require'script.php'; ?>
</body>

</html>
