<style type="text/css">
   TABLE {
    border-collapse: collapse; /* ������� ������� ������� ����� �������� */
    border: 4px solid #000; /* ����� ������ ������� */
   }
   TD, TH {
    padding: 5px; /* ���� ������ ������ */
    border: 1px solid #000; /* ����� ������ ����� */
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
    	$link = mysql_connect('localhost', 'root', 'user') or die('�� ������� �����������: ' . mysql_error());
    	mysql_select_db('goods') or die('�� ������� ������� ���� ������');
    	
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

    	echo '����� ��������.<br>';
    	$ath = mysql_query($newReqest);
    	
    }
    else
    {
    	echo '�� �� ����� �������� ������.';
    	echo '<form action="add_record.php" method = "post">';
    	echo '<table>';
    	echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" /></td></tr>';
    	echo '<tr><td>�������� ������: </td><td><input type="text" name="description" /></td></tr>';
    	echo '<tr><td>����:            </td><td><input type="text" name="price" /></td></tr>';
    	echo '<tr><td>��������:        </td><td><input type="text" name="pic" /></td></tr>';
    	echo '</table>';
    	echo '<input type="submit" value="�������� �����"> ���� "��������" ����������� ��� ����������.';
    	echo '</form>';
    }
}
?>
<a href="index.php">��������� � ������ �������</a>