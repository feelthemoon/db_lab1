<?php
// для БД
try {
	$pdoSet = new PDO('mysql:dbname=test;host=localhost', 'root', '');
	$pdoSet->query('SET NAMES utf8;');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
// начало вставки для DELETE
if (isset($_GET['delid'])) {
	$sqlTM = "DELETE FROM files WHERE id_file = " . $_GET["delid"];
	$stmt = $pdoSet->query($sqlTM);
}
// конец вставки для DELETE
// КОНЕЦ для БД

if (isset($_FILES["pictures"]["error"])) {
	foreach ($_FILES["pictures"]["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
			$name = basename($_FILES["pictures"]["name"][$key]);
			move_uploaded_file($tmp_name, "files/$name");
			
			date_default_timezone_set("Europe/Moscow");
	$sqlTM = "INSERT INTO files (id_my, description, name_origin, path, date_upload) values ('".$_GET['id']."', 'Закачка из менеджера', '$name', 'files/$name', '".date('j-m-Y  h:i:s')."')";
	$stmt = $pdoSet->query($sqlTM);
	
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="../style/main.css" />
		<title>Закачка файлов</title>
		<meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" />
        <link rel="shortcut icon" href="../image/favicon.ico" type="image/x-icon" />
	</head>
<body>
	<div class="center">

<h1>Менеджер закачек</h1>
<h2>Закачка файлов на <?php echo $_SERVER['SERVER_NAME'];  if ($_SERVER['SERVER_NAME']<>'localhost') { echo ' (Ваш IP из браузера: ' . $_SERVER['REMOTE_ADDR'] . ')'; } ?></h2>

<form action="" method="post" enctype="multipart/form-data">
<p> <h3>Любые файлы с Вашего компьютера</h3><hr />
<table>
<tr><td><b>Первый:</b> </td><td> <input type="file" name="pictures[]" /></td></tr>
<tr><td><b>Второй:</b> </td><td> <input type="file" name="pictures[]" /></td></tr>
<tr><td><b>Третий:</b> </td><td> <input type="file" name="pictures[]" /></td></tr>
</table><br />
<input type="submit" value="Отправить" />
</p><hr />
</form>

<?php
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = dirname($url);
$url = $url.'/files/';

?>
<b>Перейти в каталог с закачками:</b> <a href="files/" style="font-size:14px;font-style:italic;color: #cecece;"><?php echo $url; ?></a>

<?php
if (isset($_GET['id'])) {
	$sqlTM = "SELECT * FROM files WHERE id_my=".$_GET['id'];
	// echo $sqlTM;
	$stmt = $pdoSet->query($sqlTM);
	if (!$stmt) { echo '<h2 style=\'color:red;\'>Вам необходимо пересоздать базу данных (БД)!</h2>';} else {
	$resultMF = $stmt->fetchAll();
	if (@$resultMF[0][0] > 0) {
		echo "<h2>Ранее закаченные файлы</h2>";
		
	echo "<table>";	
	echo "<tr><td><b>Описание</b></td><td><b>Имя файла</b></td><td><b>Путь</b></td><td><b>Дата и время закачки</b></td><td style='height:20px;width:20px;'>&nbsp;</td><td style='height:20px;width:20px;'>&nbsp;</td></tr>";	
	for($iC=0; $iC<Count($resultMF); $iC++) {	
		?><tr><?php
		for($iR=2; $iR<6; $iR++) {
			?><td><?php echo $resultMF[$iC][$iR];?></td><?php
		}
		
		?><td><a href="<?php echo $resultMF[$iC][4];?>"><img src="../image/download.ico" style="height:20px;width:20px;"></a></td>
		<td style="width:20px;" title="Удалить"><a href="index.php?id=<?php echo $resultMF[$iC][1]; ?>&delid=<?php echo $resultMF[$iC][0]; ?>"><img src="../image/delete.ico" style="height:20px;width:20px;"></a></td>
		<?php
		?></tr><?php		
	}
	echo "</table>";
	
//var_dump($resultMF);
	} else {
		echo "<h2>Ранее закаченных файлов не было для выбранной строки</h2>";		
	}
	}
}
?>
 
<br />
<i style="font-size:12px;"><b>Информация:</b><br />
<b>Ваш браузер: </b><?php 
 
	/* Функция определения браузера пользователя */
	function user_browser($agent) {
		preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info);
		list(,$browser,$version) = $browser_info;
		if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) return 'Opera '.$opera[1];
		if ($browser == 'MSIE') {
			preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie);
			if ($ie) return $ie[1].' based on IE '.$version;
			return 'IE '.$version;
		}
		if ($browser == 'Firefox') {
			preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff);
			if ($ff) return $ff[1].' '.$ff[2];
		}
		if ($browser == 'Opera' && $version == '9.80') return 'Opera '.substr($agent,-5);
		if ($browser == 'Version') return 'Safari '.$version;
		if (!$browser && strpos($agent, 'Gecko')) return 'Browser based on Gecko';
		return $browser.' '.$version;
	}
 
echo user_browser($_SERVER['HTTP_USER_AGENT']); ?>
 
</i> 
	</div>

	<link rel="stylesheet" href="../scrollup/scrollup.css" /><div id="scrollup"><img src="../scrollup/7.png" class="up" title="Прокрутить вверх" /></div><script src="../scrollup/scrollup.js"></script>

</body>
</html>
