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
echo 'value="id">����������� �� Id</option>';

echo '<option '; 
if($sortingOrder == 'price')
	echo 'selected ';

echo 'value="price">����������� �� ����</option>';

echo '</select>';
echo '<input type="submit" value="�����������">';
echo '</form>';

echo '<form action="add_record.php" method = "post">';
echo '<table>';
echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" /></td></tr>';
echo '<tr><td>�������� ������: </td><td><input type="text" name="description" /></td></tr>';
echo '<tr><td>����:            </td><td><input type="text" name="price" /></td></tr>';
echo '<tr><td>��������:        </td><td><input type="text" name="pic" /></td></tr>';
echo '</table>';
echo '<input type="submit" value="�������� �����"> ���� "��������" ����������� ��� ����������.';
echo '</form>';

$link = mysql_connect('localhost', 'root', 'user') or die('�� ������� �����������: ' . mysql_error());
mysql_select_db('goods') or die('�� ������� ������� ���� ������');

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
  echo '<form name="deleting" action="index.php" method="post"><input type="submit" value="������� ����������" /><table>';
  echo "<tr>";
  echo "<td></td> <td width = 10> Id </td> <td width = 200> �������� </td> <td width = 200> �������� </td> <td width = 100> ���� </td> <td width = 200> �������� </td> </tr>";
  
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