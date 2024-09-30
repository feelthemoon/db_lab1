<!DOCTYPE html>
<html>
	<head>
		<title>Редактирование таблицы на PHP, JavaScript</title>
		<meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" />
        <link rel="shortcut icon" href="image/favicon2.ico" type="image/x-icon" />
		<link rel="stylesheet" href="style/main.css" />
	</head>
	<body>
		<div class="center">

		<h1><a href=".">Редактирование таблицы на PHP и JS (JavaScript)</a></h1>
		<button class="btMenu"><a href="."><img src="image/home.ico" alt="Главная" title="Перейти на главную страницу" class="btMenuImg" /></a></button>
		<button class="btMenu"><a href="print.php" target="_blank"><img src="image/print.ico" alt="Печать" title="Напечатать страницу" class="btMenuImg" /></a></button>

		<!-- НАЧАЛО формы для добавления -->
		<button class="btMenu" id="addView" onclick="alerted();"><img src="image/add.ico" alt="Добавить" title="Добавить 1 строку" class="btMenuImg" /></button>
		<script type="text/javascript">
		function alerted(){
			var addForm = document.getElementById('addForm'); // найти элемент
			if (addForm.style.display=='none') {
				addForm.style.display = 'block';} else {
				addForm.style.display = 'none';
			}
		}
		</script>
		<!-- КОНЕЦ формы для добавления -->

		<!-- НАЧАЛО форма добавления ВСПЛЫВАЮЩИЕ СТРОКИ -->
		<form action="index.php" id="addForm" method="get" style="display:none;">
			<br /><hr /><br />
			<table>
			<tr>
				<?php
				include "data/init.php";	
				$sql = "SHOW COLUMNS FROM borrowers;";
				$stmt = $pdoSet->query($sql);
				$resultMFcols = $stmt->fetchAll();

				for($iR=1; $iR < Count($resultMFcols); ++$iR) {
					echo '<td><input type="edit" name="'.$resultMFcols[$iR]["Field"].'" value="'.$resultMFcols[$iR]["Field"].'" /></td>';
				}
				
				?>
				<td><input type="submit" name="bt1" value="Добавить" class="bt" /></td>
				
			</tr>
			</table>
			<p style="font-size:12px;"><i>(в базу <b>Bank</b>, таблицу <b>borrowers</b> в MySQL)</i></p>
			<hr />
		</form>
		<!-- КОНЕЦ форма добавления ВСПЛЫВАЮЩИЕ СТРОКИ -->

		<br /><br />
		<table class='tView1'>
			<tr class="hedTabl">
				<?php
					for ($iR=0; $iR < Count($resultMFcols); ++$iR) {
						?><td>
						<a href="./index.php?order=<?php echo $resultMFcols[$iR]["Field"];?>" title="Сортировать по убыванию"><?php echo $resultMFcols[$iR]["Field"];?></a>
						<?php
							if ($iR > 0 ) {
								?>
						<a href="./index.php?delrow=<?php echo $resultMFcols[$iR]["Field"];?>" title="Удалить столбец"><img src="image/delrow.png"></a>
						<a href="./index.php?addrow=<?php echo $resultMFcols[$iR]["Field"];?>" title="Добавить справа"><img src="image/addrow.png"></a>
								<?php
							}
						?>
						</td>
						<?php
					}
				?>
				<td class="act">&nbsp;</td><td class="act">&nbsp;</td><td class="act">&nbsp;</td><td class="act">&nbsp;</td>
				<td class="act">&nbsp;</td>			</tr>
			<?php
			@ $iCountLine = Count($resultMF[0]);

			for ($iC = 0; $iC < Count($resultMF); $iC++) {
				?><tr><?php
				
				for ($iR = 0; $iR < $iCountLine; $iR++) {
		// добавить 1 строку кода для UPDATE
					?><td><a href="#" class="js-open-modal" data-modal="1" id="id<?php echo $iR .'_'. $resultMF[$iC][0];?>" title="Редактировать 1 строку"><?php echo $resultMF[$iC][$iR];?></a></td><?php
				}
		// добавить 1 строку кода для UPDATE
				?>
				
				<td class='actRt' title="Отредактировать"><a href="#" class="js-open-modal" data-modal="1" id="id<?php echo $iR .'_'. $resultMF[$iC][0];?>"><img src="image/edit.ico"></a></td>
				<td class='actRt' title="Добавить файлы"><a href="practUpload/index.php?id=<?php echo $resultMF[$iC][0]; ?>"><img src="image/files.ico"></a></td>
				<td class='actRt' title="Удалить"><a href="index.php?delid=<?php echo $resultMF[$iC][0]; ?>"><img src="image/delete.ico"></a></td><?php
				?></tr><?php
			} ?>
		</table>

		<!-- НАЧАЛО модального окна -->
		<link rel="stylesheet" href="style/modal.css" />
		<div class="modal" data-modal="1">
		   <!--   Svg иконка для закрытия окна  -->
		   <svg class="modal__cross js-modal-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>
		   <p class="modal__title"><b>Отредактировать строку</b><br /></p>
		   
			<form action="index.php" method="get">   
			   <input type="hidden" name="textId" id="textId" value="none 1 is error" />
			   <div>
			   <?php
				for($iR = 1; $iR < $iCountLine; $iR++)
					echo '<div>'.$resultMFcols[$iR]["Field"].' :</div>';
			   ?>
			   </div>
			   <div>
			   <?php
				for($iR = 1; $iR < $iCountLine; $iR++)
					echo '<input type="edit" name="textEd'.$iR.'" id="textEd'.$iR.'" value="none 1 is error" />';
			   ?>			   
			   </div>
			   <br /><a href="practUpload/index.php?id=error" id="aId" target="_blank" class="bt">Добавить файлы</a>
				<input type="submit" name="bt2" value="Отредактировать" class="bt" />
			</form>
		   
		</div>
			<!-- Подложка под модальным окном -->
		<div class="overlay js-overlay-modal"></div>
			<!-- Дополнительный скрипт --> 
		<script src="script/modal.js"></script>
		<!-- КОНЕЦ модального окна -->

		<div class='hint'>(под управлением: XAMPP Version 7.4.27)</div>
	 
		</div>
		
		<link rel="stylesheet" href="scrollup/scrollup.css" /><div id="scrollup"><img src="scrollup/7.png" class="up" title="Прокрутить вверх" /></div><script src="scrollup/scrollup.js"></script>

	</body>
</html>