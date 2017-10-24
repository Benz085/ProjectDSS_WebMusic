<?php
require_once 'Music.php';
$Music = new Music();
$stmt = $Music->runQuery("SELECT * FROM `mouth`");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $Music->runQuery("SELECT COUNT(Music_id) FROM `text_music`");
$stmt1->execute();
$data1 = $stmt1->fetch(PDO::FETCH_ASSOC);
//echo '<pre>';
//print_r($data1);
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
                <div class="col-lg-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> เพลงทีออกในแต่ละเดือน : เพลงทั้งหมด - <?= $data1['COUNT(Music_id)'] ?> เพลง
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <?php 
                                    foreach ($data as $key ){
                                        echo ' <a href="data.php?id='.$key['id'].'" class="list-group-item">
                                    <i class="fa fa-list-alt"></i>&nbsp;&nbsp; '.$key['mouth'].'
                                    <span class="pull-right text-muted small"><em>จำนวนเพลง</em>
                                    </span>
                                    </a>';
                                    }    
                                 ?>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->    
                </div>
                <div class="col-lg-8">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-music"></i> เพลงทั้งหมด
                        </div>
                        <!-- /.panel-heading -->
                        <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ชื่อศิลปิน</th>
                                    <th>ชื่อเพลง</th>
                                    <th>เดือน / ปี</th>
                                    <th>สถานะ</th>
                                    <th>คำ</th>
                                </tr>
                                </thead>
                            <?php 
                                if(isset($_GET['id'])){
                                    $id = $_GET['id'];
                                    echo "ID : ".$id;
                                    $stmt = $Music->runQuery("SELECT * FROM text_music
                                                                INNER JOIN mouth
                                                                ON text_music.Music_month=mouth.id
                                                                WHERE mouth.id=:id ORDER BY Music_id DESC");
                                    $stmt->execute(array(':id' => $id));
                                    echo'<hr>';
                                    if($stmt->rowCount()){
                                        $data_music = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($data_music as $value) {
                                        ?>
                                            <tbody>
                                            <tr>
                                                <td><?php echo $value['Music_id'] ?></td>
                                                <td><?php echo $value['Artist'] ?></td>
                                                <td><?php echo $value['name_music'] ?></td>
                                                <td><?php echo $value['mouth'] ?> / <?php echo $value['Music_year'] ?></td>
                                                <td><?php
                                                if ($value['isActive'] == 0 ){
                                                    echo '<a href="cut.php?ID_cut='.$value['Music_id'].'" class="btn btn-warning btn-xs">ยังไม่คำนวณ</a>';
                                                }else if ($value['isActive'] == 1) {
                                                    echo '<a href="cut.php?ID_cut='.$value['Music_id'].'" class="btn btn-success btn-xs">คำนวณ</a>';
                                                }
                                            ?>
                                            </td>
                                            </tr>
                                            </tbody>
                                            <?php
                                        }
                                    } 
                                }else {
                                    echo '<div class="alert alert-warning" role="alert"><strong>NO ID !</strong> and No music</div>';
                                }
                             ?>    
                        </table>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->    
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   <?php require'script.php'; ?>
</body>

</html>
