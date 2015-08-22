<head>
  <link href="style.css" rel="stylesheet">
</head>

<div class="productList">

<script type="text/javascript"> 
    checkobj = 0;
 
    function checkAvail(obj){ 
        if(obj.checked) checkobj++; 
            else checkobj--; 
        if (checkobj<=0) document.deleting.elements['submit'].hidden = true; 
            else document.deleting.elements['submit'].hidden = false; 
    } 
</script>

<?php
include 'my_memcache.php';

$sortingOrder = 'id';

if(isset($_POST['order']))
{
	if($_POST['order'] == 'id')
  		$sortingOrder = 'id';
  	else
  		$sortingOrder = 'price';	
}

$link = mysql_connect('localhost', 'root', 'user') or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('goods') or die('Не удалось выбрать базу данных');

$memcache_host='localhost';
$memcache_port=11211;
$memcache = new Memcache;

if(!$memcache->pconnect($memcache_host,$memcache_port))
	die("Memcached не доступен: $memcache_host:$memcache_port");

if($sortingOrder == 'id')
	$ath = sqlGet("SELECT * FROM goods ORDER BY id ASC;");
	#$ath = mysql_query("SELECT * FROM goods ORDER BY id ASC;");
else
	#$ath = mysql_query("SELECT * FROM goods ORDER BY price ASC;");
	$ath = sqlGet("SELECT * FROM goods ORDER BY price ASC;");

if($ath)
{
  echo '<div class = "header"><table><tr>';
  echo '<td><a href="add_record.php">Добавить товар.</a></td>';
  
  
  echo '<td><form action="index.php" method="post">';
  echo '<select name="order" onchange="this.form.submit();">';
  echo '<option ';
  if($sortingOrder == 'id')
  	echo 'selected ';
  echo 'value="id">Сортировать по Id</option>';

  echo '<option '; 
  if($sortingOrder == 'price')
  	echo 'selected ';

  echo 'value="price">Сортировать по Цене</option>';

  echo '</select>';
  echo '</form></td>';
  echo '<td><input hidden=true type="submit" name="submit" value="Удалить выделенное" class="my_button" form="deleting"></td>';
  
  echo '<form name="deleting" id="deleting" action="delete_record.php" method="post">';

  echo '</tr></table></div>';
  

  echo "<table class = 'contents'><tr>";
  echo "<td width = 20></td> <td width = 50> Id </td> <td width = 610> Товар </td> <td width = 100> Цена </td></tr>";
  echo '</table>';

  $i = 0;
  while($i < count($ath))
  {
    echo "<table class = 'product'><tr>";

    echo '<td width = 20><input type="checkbox" onclick="checkAvail(this)" name="delete[]" value="'.$ath[$i]['id'].'" /></td>';
    echo "<td width = 50>".$ath[$i]['id']."&nbsp;</td>";
    echo '<td width = 110><img src="'.$ath[$i]['pic'].'" width="100" height="100"></td>';
    echo "<td width = 500><div class = 'name'>".$ath[$i]['name']."&nbsp;</div><div class = 'description'>".$ath[$i]['description']."</div></td>";
    echo "<td width = 100>".$ath[$i]['price']."&nbsp;</td>";
    echo '<td><a class = "description" href="edit_record.php?value='.$ath[$i]['id'].'">Edit</a></td>';
    
    echo "</tr>";
    echo "</table>";
  	$i++;
  }
  echo '</form>';
}

?>
</div>