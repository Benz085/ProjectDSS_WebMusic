<?php
//คำสั่ง connect db เขียนเพิ่มเองนะ

$strExcelFileName="Music.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

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


?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
    <table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">
        <tr>
            <td width="120" height="30" align="center" valign="middle" ><strong>MUSIC_ID</strong></td>
            <td width="100" align="center" valign="middle" ><strong>month</strong></td>
            <td width="100" align="center" valign="middle" ><strong>year</strong></td>
            <td width="100" align="center" valign="middle" ><strong>count</strong></td>
            <td width="100" align="center" valign="middle" ><strong>nonLove</strong></td>
            <td width="100" align="center" valign="middle" ><strong>liKing</strong></td>
            <td width="100" align="center" valign="middle" ><strong>inFatuatedLove</strong></td>
            <td width="100" align="center" valign="middle" ><strong>emptyLove</strong></td>
            <td width="100" align="center" valign="middle" ><strong>romanticLove</strong></td>
            <td width="100" align="center" valign="middle" ><strong>fatuousLove</strong></td>
            <td width="100" align="center" valign="middle" ><strong>conSumMateLove</strong></td>
        </tr>
        <?php
        foreach ($data as $res){
            ?>
            <tr>
                <td align="center" valign="middle">MusicID:<?= $res['Music_id'] ?></td>
                <td align="center" valign="middle"><?= $res['mouth'] ?></td>
                <td align="center" valign="middle"><?= $res['Music_year'] ?></td>
                <td align="center" valign="middle"><?= $res['count'] ?></td>
                <td align="center" valign="middle"><?= $res['nonLove'] ?></td>
                <td align="center" valign="middle"><?= $res['liKing'] ?></td>
                <td align="center" valign="middle"><?= $res['inFatuatedLove'] ?></td>
                <td align="center" valign="middle"><?= $res['emptyLove'] ?></td>
                <td align="center" valign="middle"><?= $res['romanticLove'] ?></td>
                <td align="center" valign="middle"><?= $res['fatuousLove'] ?></td>
                <td align="center" valign="middle"><?= $res['conSumMateLove'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<script>
    window.onbeforeunload = function(){return false;};
    setTimeout(function(){window.close();}, 10000);
</script>
</body>
</html>