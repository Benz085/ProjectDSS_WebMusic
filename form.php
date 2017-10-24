<?php
require_once 'Music.php';
$Music = new Music();
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $artist = $_POST['artist'];
    $text = $_POST['text'];
    //$month = $_POST['month'];
    //$year = $_POST['year'];
    $month = 10;
    $year = 2014;
    if($name == "" && $name == null){
        echo '<div class="alert alert-warning" role="alert"> 
                <strong>กรุณากรอก!</strong> 
               ข้อมูล ชื่อเพลง
             </div>';
    }else if($artist == "" || $artist == null){
        echo '<div class="alert alert-warning" role="alert"> 
                <strong>กรุณากรอก!</strong> 
               ข้อมูล ศิลปิน
             </div>';
    }else if($text == "" || $text == null){
        echo '<div class="alert alert-warning" role="alert"> 
                <strong>กรุณากรอก!</strong> 
               ข้อมูล เนื้อเพลง
             </div>';
    }else if($month == "" || $month == null){
         echo '<div class="alert alert-warning" role="alert"> 
                <strong>กรุณากรอก!</strong> 
               ข้อมูล เดือน
             </div>';
    }else if($year == "" || $year == null){
        echo '<div class="alert alert-warning" role="alert"> 
                <strong>กรุณากรอก!</strong> 
               ข้อมูล ปี
             </div>';
    }else{
        try {
        if ($Music->insertMusic($name,$artist,$text,$month,$year)) {
            if ($Music == null) {
               echo '<div class="alert alert-danger" role="alert"> 
                            <strong>Oh snap!</strong> 
                            No Insert SQL Fail 
                    </div>';
              }else {
                    echo '<div class="alert alert-success" role="alert"> 
                            <strong><a href="data.php"> View Data >> </a></strong> 
                            You successfully 
                          </div>';
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
   }
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
                    <h1 class="page-header">ฟอร์มเพลง</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Form Input
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <form role="form" action="" method="post">
                                        <div class="form-group">
                                            <label>ชื่อเพลง</label>
                                            <input class="form-control" name="name" placeholder="กรุณาใส่ ชื่อเพลง">
                                        </div>
                                         <div class="form-group">
                                            <label>ชื่อศิลปิน</label>
                                            <input class="form-control"  name="artist" placeholder="กรุณาใส่ ชื่อศิลปิน">
                                        </div>
                                        <div class="form-group">
                                            <label>เนื้อเพลง</label>
                                            <textarea class="form-control" rows="10" name="text"></textarea>
                                             <p class="help-block">กรุณาใส่ เนื้อเพลง.</p>
                                        </div>
                                         <!--<div class="form-group">
                                            <label>เดือน</label>
                                            <select  class="form-control" name="month" >
                                                <option>กรุณาเลือกเดือน</option>
                                                <option  value="1">มกราคม</option>
                                                <option  value="2">กุมภาพันธ์</option>
                                                <option  value="3">มีนาคม</option>
                                                <option  value="4">เมษายน</option>
                                                <option  value="5">พฤษภาคม</option>
                                                <option  value="6">มิถุนายน</option>
                                                <option  value="7">กรกฎาคม</option>
                                                <option  value="8">สิงหาคม</option>
                                                <option  value="9">กันยายน</option>
                                                <option  value="10">ตุลาคม</option>
                                                <option  value="11">พฤศจิกายน</option>
                                                <option  value="12">ธันวาคม</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>ปี</label>
                                            <input class="form-control" name="year" placeholder="กรุณาใส่ ปีของเพลง">
                                        </div>-->
                                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                        <button type="reset" class="btn btn-warning">Reset</button>
                                    </form>
                                </div>
                                
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   <?php require'script.php'; ?>
</body>
</html>
