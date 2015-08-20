<style type="text/css">
   TABLE {
    border-collapse: collapse;
    border: 4px solid #000;
   }
   TD, TH {
    padding: 5px;
    border: 1px solid #000;
   }
</style>
<?php

$sortingOrder = 'id';

if(isset($_POST['order']))
{
	if($_POST['order'] == 'id')
  		$sortingOrder = 'id';
  	else
  		$sortingOrder = 'price';	
}

echo '<form action="index.php" method="post">';
echo '<select name="order">';

echo '<option ';
if($sortingOrder == 'id')
	echo 'selected ';
echo 'value="id">Сортировать по Id</option>';

echo '<option '; 
if($sortingOrder == 'price')
	echo 'selected ';

echo 'value="price">Сортировать по Цене</option>';

echo '</select>';
echo '<input type="submit" value="Сортировать">';
echo '</form>';

echo '<form action="add_record.php" method = "post">';
echo '<table>';
echo '<tr><td>Название товара*: </td><td><input type="text" name="name" /></td></tr>';
echo '<tr><td>Описание товара: </td><td><input type="text" name="description" /></td></tr>';
echo '<tr><td>Цена:            </td><td><input type="text" name="price" /></td></tr>';
echo '<tr><td>Картинка:        </td><td><input type="text" name="pic" /></td></tr>';
echo '</table>';
echo '<input type="submit" value="Добавить товар"> Поле "Название" обязательно для заполнения.';
echo '</form>';

$link = mysql_connect('localhost', 'root', 'user') or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('goods') or die('Не удалось выбрать базу данных');

if(isset($_POST['delete']))
{
  $aDoor = $_POST['delete'];
  {
    $N = count($aDoor);
    
    for($i = 0; $i < $N; $i++)
    {
      $ath = mysql_query("DELETE FROM goods WHERE id = ".$aDoor[$i].";");
    }
  }
}

if($sortingOrder == 'id')
	$ath = mysql_query("SELECT * FROM goods ORDER BY id ASC;");
else
	$ath = mysql_query("SELECT * FROM goods ORDER BY price ASC;");

if($ath)
{
  echo '<form name="deleting" action="index.php" method="post"><input type="submit" value="Удалить выделенные" /><table>';
  echo "<tr>";
  echo "<td></td> <td width = 10> Id </td> <td width = 200> Название </td> <td width = 200> Описание </td> <td width = 100> Цена </td> <td width = 200> Картинка </td> </tr>";
  
  while($product = mysql_fetch_array($ath))
  {
    echo "<tr>";
    
	echo '<td><input type="checkbox" name="delete[]" value="'.$product['id'].'" /></td>';
    echo "<td>".$product['id']."&nbsp;</td>";
    echo "<td>".$product['name']."&nbsp;</td>";
    echo "<td>".$product['description']."&nbsp;</td>";
    echo "<td>".$product['price']."&nbsp;</td>";
    echo '<td><img src="'.$product['pic'].'" width="100" height="100"></td>';
    
 
    echo "</tr>";
  }
  echo '</table></form>';

}

?>