<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<head>
	<link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php
    include 'my_memcache.php';

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

    if(isset($_POST['delete']))
    {
      	$aDoor = $_POST['delete'];
      	{
        	$N = count($aDoor);
        
        	for($i = 0; $i < $N; $i++)
        	{
          		$ath = sqlSet("DELETE FROM goods WHERE id = ".$aDoor[$i].";", $aDoor[$i]);
          		echo 'Товар с id '.$aDoor[$i].' уcпешно удален.<br>';
        	}
      	}
    }
    echo '</div>';
?>
</div>