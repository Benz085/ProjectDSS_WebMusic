<?php
require_once 'Music.php';
$Music = new Music();


$stmt = $Music->runQuery("SELECT * FROM `mouth`");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_GET['ID_cut'])) {
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
    $DATA_MUSIC = implode(" ", $data);
} else {
    echo 'NO ID';
}
?>
<script language="JavaScript">

    function ActionData()
    {
        frmMain.action='data.php?id=1'
        frmMain.target='iframe_target';
        frmMain.submit();
    }


</script>
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
                <h1 class="page-header">ข้อมูลเพลง : <?php echo "ID : " . $id; ?> </h1>
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
<!--            <div class="col-lg-12">-->
<!--                <div class="panel panel-warning">-->
<!--                    <div class="panel-heading">-->
<!--                        <i class="fa fa-bell fa-fw"></i>คำในเพลง-->
<!--                    </div>-->
<!--                    <!-- /.panel-heading -->-->
<!--                    <div class="panel-body">-->
<!--                        --><?php
//                        $stmt = $Music->runQuery("SELECT id FROM `check_words` WHERE id=:id");
//                        $stmt->execute(array(':id' => $id));
//                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
//                        echo '<pre>';
//                        print_r($data);
//                        echo '<hr>';
//                        if ($data['id'] == $id) {
//                            echo '<div class="alert alert-success" role="alert">มี DATA แล้ว </div>';
//                        } else {
//                            $Music->checkWord($id);
//                            for ($i = 0; $i < count($MUSIC_STRING); $i++) {
//                                $Music->wordText($MUSIC_STRING[$i]);
//                                //$MUSIC_STRING[$i].'<br>';
//                            }
//                            if ($Music == null) {
//                                echo '<div class="alert alert-danger" role="alert">
//                                <strong>Oh snap!</strong> No Insert SQL Fail </div>';
//                            } else {
//                                echo '<div class="alert alert-success" role="alert">
//                                <strong>Oh snap!</strong> Sucessfull <a href="http://localhost/ProjectDSS_WebMusic/data.php" class="btn btn-info" role="button">กลับ</a></a></div>';
//                            }
//                        }
//
//
//                        ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="col-sm-6">
                <div class="list-group">
                    <a href="#" class="list-group-item active">ข้อมูลด้านความรู้สึก</a>
                    <?php
                    if ($nonLove = $Music->nonLove($MUSIC_STRING)) {
                        if ($nonLove == null) {
                            echo 'fail data';
                        } else {
                            $res_nonLove = json_decode($nonLove);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="nonLove"><span class="badge">' . $res_nonLove->nonLove . '</span>เฉย</a>';
                        }
                    }
                    if ($liKing = $Music->liKing($MUSIC_STRING)) {
                        if ($liKing == null) {
                            echo 'fail data';
                        } else {
                            $res_liKing = json_decode($liKing);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="liKing"><span class="badge">' . $res_liKing->liKing . '</span>ชอบ</a>';
                        }
                    }
                    if ($inFatuatedLove = $Music->inFatuatedLove($MUSIC_STRING)) {
                        if ($inFatuatedLove == null) {
                            echo 'fail data';
                        } else {
                            $res_inFatuatedLove = json_decode($inFatuatedLove);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="inFatuatedLove"><span class="badge">' . $res_inFatuatedLove->inFatuatedLove . '</span>รักแรกพบ</a>';
                        }
                    }
                    if ($emptyLove = $Music->emptyLove($MUSIC_STRING)) {
                        if ($emptyLove == null) {
                            echo 'fail data';
                        } else {
                            $res_emptyLove = json_decode($emptyLove);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="emptyLove"><span class="badge">' . $res_emptyLove->emptyLove . '</span>หมดรัก</a>';
                        }
                    }
                    if ($romanticLove = $Music->romanticLove($MUSIC_STRING)) {
                        if ($romanticLove == null) {
                            echo 'fail data';
                        } else {
                            $res_romanticLove = json_decode($romanticLove);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="romanticLove"><span class="badge">' . $res_romanticLove->romanticLove . '</span>รักโรแมนติก</a>';
                        }
                    }
                    if ($fatuousLove = $Music->fatuousLove($MUSIC_STRING)) {
                        if ($romanticLove == null) {
                            echo 'fail data';
                        } else {
                            $res_fatuousLove = json_decode($fatuousLove);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="fatuousLove"><span class="badge">' . $res_fatuousLove->fatuousLove . '</span>ความรักอันโง่เขลา</a>';
                        }
                    }
                    if ($conSumMateLove = $Music->conSumMateLove($MUSIC_STRING)) {
                        if ($conSumMateLove == null) {
                            echo 'fail data';
                        } else {
                            $res_conSumMateLove = json_decode($conSumMateLove);
//                                        echo '<pre>';
//                                            print_r($sum2);
                            echo '<a  class="list-group-item" name="conSumMateLove"><span class="badge">' . $res_conSumMateLove->conSumMateLove . '</span>ความรักที่สมบูรณ์</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-info" style="margin-top: 15px">
                    <div class="panel-heading ">
                        <h3 class="panel-title">ข้อมูล</h3>
                    </div>
                    <div class="panel-body">
                        <form action='' method='post'>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ข้อมูลเพลง</label>
                                <input type="text" class="form-control" name="musicID"
                                       value=" <?= $data1['name_music']; ?>"
                                       disabled>ID :<?= $id; ?>
                                <input type="hidden" class="form-control" name="musicID" value="<?= $id; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ข้อมูล จากวิเคราะห์</label>
                                <input type="text" class="form-control" name="nonLove"value=" <?= $res_nonLove->nonLove; ?>" disabled>
                                <input type="hidden" class="form-control" name="nonLove" value="<?= $res_nonLove->nonLove; ?>">

                                <input type="text" class="form-control" name="liKing"value=" <?= $res_liKing->liKing; ?>" disabled>
                                <input type="hidden" class="form-control" name="liKing" value="<?= $res_liKing->liKing; ?>">

                                <input type="text" class="form-control" name="inFatuatedLove" value=" <?= $res_inFatuatedLove->inFatuatedLove; ?>" disabled>
                                <input type="hidden" class="form-control" name="inFatuatedLove" value="<?= $res_inFatuatedLove->inFatuatedLove; ?>">

                                <input type="text" class="form-control" name="emptyLove" value=" <?= $res_emptyLove->emptyLove; ?>" disabled>
                                <input type="hidden" class="form-control" name="emptyLove" value="<?= $res_emptyLove->emptyLove; ?>">

                                <input type="text" class="form-control" name="romanticLove" value=" <?= $res_romanticLove->romanticLove ; ?>" disabled>
                                <input type="hidden" class="form-control" name="romanticLove" value="<?= $res_romanticLove->romanticLove ; ?>">

                                <input type="text" class="form-control" name="fatuousLove" value=" <?= $res_fatuousLove->fatuousLove; ?>" disabled>
                                <input type="hidden" class="form-control" name="fatuousLove" value="<?= $res_fatuousLove->fatuousLove; ?>">

                                <input type="text" class="form-control" name="conSumMateLove" value=" <?= $res_conSumMateLove->conSumMateLove; ?>" disabled>
                                <input type="hidden" class="form-control" name="conSumMateLove" value="<?= $res_conSumMateLove->conSumMateLove; ?>">
                            </div>
                            <div class="form-group">
                                <button name="btn-signup" type="submit" class="form-control btn btn-success">เพิ่มข้อมูล
                                </button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['btn-signup'])) {
                              //echo '<pre>';
                              //print_r($_POST);
                             $musicID = $_POST['musicID'];
                             $nonLove = $_POST['nonLove'];
                             $liKing = $_POST['liKing'];
                             $inFatuatedLove = $_POST['inFatuatedLove'];
                             $emptyLove = $_POST['emptyLove'];
                             $romanticLove = $_POST['romanticLove'];
                             $fatuousLove = $_POST['fatuousLove'];
                             $conSumMateLove = $_POST['conSumMateLove'];


                            if ($Music->insert_data($musicID,$nonLove,$liKing,$inFatuatedLove,$emptyLove,$romanticLove,$fatuousLove ,$conSumMateLove)) {
                                if ($Music == null) {
                                    echo 'fail data';
                                } else {
                                    //echo 'sucessfull data';
                                    //header('Location: data.php');
                                    echo '<a name="btn-signup" type="submit" href="data.php?id=12" class="form-control btn btn-info">กลับ</a>';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /#wrapper -->

    <?php require 'script.php'; ?>
</body>

</html>
