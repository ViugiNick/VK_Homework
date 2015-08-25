<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<head>
	<link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php
    include 'my_memcache.php';

    function changeRecord($id)
    {
    	$ath = sqlGet("SELECT * FROM goods WHERE id = ".$id.";", $id);
        
        echo '<form action="edit_record.php" method = "post">';
       	echo '<table>';
       	echo '<input type="hidden" name="id" value="'.$ath[0]['id'].'"/>';
       	echo '<tr><td>Название товара*: </td><td><input type="text" name="name" value="'.$ath[0]['name'].'"/></td></tr>';
       	echo '<tr><td>Описание товара: </td><td><input type="text" name="description" value="'.$ath[0]['description'].'"/></td></tr>';
       	echo '<tr><td>Цена:            </td><td><input type="text" name="price" value="'.$ath[0]['price'].'"/></td></tr>';
       	echo '<tr><td>Картинка:        </td><td><input type="text" name="pic" value="'.$ath[0]['pic'].'"/></td></tr>';
       	echo '<tr><td><input type="submit" class="my_button" value="Сохранить изменения"></td></tr>';
       	echo '</table>';
       	
       	echo '</form>';
    }

    $link = mysql_connect('localhost', 'nfuogibo', '---') or die('Не удалось соединиться: ' . mysql_error());
    mysql_select_db('nfuogibo_goods') or die('Не удалось выбрать базу данных nfuogibo_goods');

    $memcache_host='localhost';
    $memcache_port=11211;
    $memcache = new Memcache;

    if(!$memcache->pconnect($memcache_host,$memcache_port))
    	die("Memcached не доступен: $memcache_host:$memcache_port");

    echo '<div class = "header">';
    echo '<table class = "menu"><tr>';
    
    echo '<td class = "menu">';
    echo '<a href="index.php">Вернуться к списку товаров</a>';
    echo '</td>';
    
    echo '</tr></table>';
    
    echo '</div>';

    echo '<div class = "product">';

    if(isset($_POST['name']))
    {
        $oldID = $_POST["id"];
        
        $newName = $_POST["name"];
        $newDescription = $_POST["description"];
        $newPrice = $_POST["price"];
        $newPic = $_POST["pic"];

        if($newName != "" and is_numeric($newPrice))
        {
        	$newReqest = 'UPDATE goods SET name = "'.$newName.'"';
        	
        	$newReqest .= ', description = "'.$newDescription.'"';
        	
        	if($newPrice != "")
        		$newReqest .= ', price = '.$newPrice;
        	
        	$newReqest .= ', pic = "'.$newPic.'"';
        	
        	$newReqest.=' WHERE id = '.$oldID.';';
    	    echo 'Изменения сохранены.<br>';
        	#echo $newReqest;

        	$ath = sqlSet($newReqest, $oldID);
        	exit();	
        }
        else
        {
        	if($newName == "")
        		echo 'Вы не ввели название товара.<br>';
        	if(!is_numeric ($newPrice))
        		echo 'Цена должна быть числом.<br>';
        		        	
        	echo '<form action="edit_record.php" method = "post">';
       		echo '<table>';
       		echo '<input type="hidden" name="id" value="'.$oldID.'"/>';
       		echo '<tr><td>Название товара*: </td><td><input type="text" name="name" value="'.$newName.'"/></td></tr>';
       		echo '<tr><td>Описание товара: </td><td><input type="text" name="description" value="'.$newDescription.'"/></td></tr>';
       		echo '<tr><td>Цена:            </td><td><input type="text" name="price" value="'.$newPrice.'"/></td></tr>';
       		echo '<tr><td>Картинка:        </td><td><input type="text" name="pic" value="'.$newPic.'"/></td></tr>';
       		echo '<tr><td><input type="submit" class="my_button" value="Сохранить изменения"></td></tr>';
       		echo '</table>';
       		echo '</form>';
        	exit();
        }
    }

    if(isset($_GET['value']))
    {
    	changeRecord($_GET['value']);
    }

?>
</div>