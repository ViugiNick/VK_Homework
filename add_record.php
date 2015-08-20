<style type="text/css">
   TABLE {
    border-collapse: collapse; /* Убираем двойные границы между ячейками */
    border: 4px solid #000; /* Рамка вокруг таблицы */
   }
   TD, TH {
    padding: 5px; /* Поля вокруг текста */
    border: 1px solid #000; /* Рамка вокруг ячеек */
   }
</style>
<?php

if(isset($_POST['name']))
{
    $newName = htmlspecialchars($_POST["name"]);
    $newDescription = htmlspecialchars($_POST["description"]);
    $newPrice = htmlspecialchars($_POST["price"]);
    $newPic = htmlspecialchars($_POST["pic"]);

    if($newName != "")
    {
    	$link = mysql_connect('localhost', 'root', 'user') or die('Не удалось соединиться: ' . mysql_error());
    	mysql_select_db('goods') or die('Не удалось выбрать базу данных');
    	
    	$newReqest = "INSERT INTO goods (name";

    	if($newDescription != "")
    		$newReqest .= ", description";
    	if($newPrice != "")
    		$newReqest .= ", price";
    	if($newPic != "")
    		$newReqest .= ", pic";
    	
    	$newReqest .= ') VALUES ("'.$newName.'"';
    	
    	if($newDescription != "")
    		$newReqest .= ', "'.$newDescription.'"';
    	if($newPrice != "")
    		$newReqest .= ', '.$newPrice;
    	if($newPic != "")
    		$newReqest .= ', "'.$newPic.'"';
    	$newReqest .= ");";

    	echo 'Товар добавлен.<br>';
    	$ath = mysql_query($newReqest);
    	
    }
    else
    {
    	echo 'Вы не ввели название товара.';
    	echo '<form action="add_record.php" method = "post">';
    	echo '<table>';
    	echo '<tr><td>Название товара*: </td><td><input type="text" name="name" /></td></tr>';
    	echo '<tr><td>Описание товара: </td><td><input type="text" name="description" /></td></tr>';
    	echo '<tr><td>Цена:            </td><td><input type="text" name="price" /></td></tr>';
    	echo '<tr><td>Картинка:        </td><td><input type="text" name="pic" /></td></tr>';
    	echo '</table>';
    	echo '<input type="submit" value="Добавить товар"> Поле "Название" обязательно для заполнения.';
    	echo '</form>';
    }
}
?>
<a href="index.php">Вернуться к списку товаров</a>