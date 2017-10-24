<?php
require_once 'Music.php';
$Music = new Music();
$stmt = $Music->runQuery("SELECT * 
FROM  text_music
INNER JOIN mouth
ON text_music.Music_month = mouth.id
INNER JOIN emotion_love
ON text_music.Music_id=emotion_love.musicID
GROUP BY Music_id");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


//echo '<pre>';
//print_r($data);
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
                <h1 class="page-header">ข้อมูลเพลง</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> สรุป : เพลงทั้งหมด
                        <a href="excel.php" class="btn btn-success">EXCEL</a>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>MUSIC_ID</th>
                                <th>month</th>
                                <th>year</th>
                                <th>count</th>
                                <th>nonLove</th>
                                <th>liKing</th>
                                <th>inFatuatedLove</th>
                                <th>emptyLove</th>
                                <th>romanticLove</th>
                                <th>fatuousLove</th>
                                <th>conSumMateLove</th>
                            </tr>
                            </thead>
                            <?php
                            foreach ($data as $res){
                                ?>
                                <tbody>
                                <tr>
                                    <th>MusicID:<?= $res['Music_id'] ?></th>
                                    <td><?= $res['mouth'] ?></td>
                                    <td><?= $res['Music_year'] ?></td>
                                    <td><?= $res['count'] ?></td>
                                    <td><?= $res['nonLove'] ?></td>
                                    <td><?= $res['liKing'] ?></td>
                                    <td><?= $res['inFatuatedLove'] ?></td>
                                    <td><?= $res['emptyLove'] ?></td>
                                    <td><?= $res['romanticLove'] ?></td>
                                    <td><?= $res['fatuousLove'] ?></td>
                                    <td><?= $res['conSumMateLove'] ?></td>
                                </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>

</div>
<!-- /#wrapper -->

<?php require 'script.php'; ?>
</body>

</html>
