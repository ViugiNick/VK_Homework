<head>
  <link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php

function changeRecord($id)
{
	$link = mysql_connect('localhost', 'root', 'user') or die('�� ������� �����������: ' . mysql_error());
    mysql_select_db('goods') or die('�� ������� ������� ���� ������');
    	
    $ath = mysql_query("SELECT * FROM goods WHERE id = ".$id) or die(mysql_error());
    
    if($ath)
    {
        while($product = mysql_fetch_array($ath))
        {
    		echo '<form action="edit_record.php" method = "post">';
    		echo '<table>';
    		echo '<input type="hidden" name="id" value="'.$product['id'].'"/>';
    		echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" value="'.$product['name'].'"/></td></tr>';
    		echo '<tr><td>�������� ������: </td><td><input type="text" name="description" value="'.$product['description'].'"/></td></tr>';
    		echo '<tr><td>����:            </td><td><input type="text" name="price" value="'.$product['price'].'"/></td></tr>';
    		echo '<tr><td>��������:        </td><td><input type="text" name="pic" value="'.$product['pic'].'"/></td></tr>';
    		echo '</table>';
    		echo '<input type="submit" class="my_button" value="��������� ���������">';
    		echo '</form>';
    	
        }
	}
}

$link = mysql_connect('localhost', 'root', 'user') or die('�� ������� �����������: ' . mysql_error());
mysql_select_db('goods') or die('�� ������� ������� ���� ������');

echo '<div class = "header">';
echo '<table><tr>';
echo '<td><a href="index.php">��������� � ������ �������</a></td>';
echo '</table></tr>';
echo '</div>';
echo '<div class = "product">';

if(isset($_POST['name']))
{
    $oldID = htmlspecialchars($_POST["id"]);
    
    $newName = htmlspecialchars($_POST["name"]);
    $newDescription = htmlspecialchars($_POST["description"]);
    $newPrice = htmlspecialchars($_POST["price"]);
    $newPic = htmlspecialchars($_POST["pic"]);

    if($newName != "")
    {
    	$link = mysql_connect('localhost', 'root', 'user') or die('�� ������� �����������: ' . mysql_error());
    	mysql_select_db('goods') or die('�� ������� ������� ���� ������');
    	
    	$newReqest = 'UPDATE goods SET name = "'.$newName.'", description = "'.$newDescription.'", price = '.$newPrice.', pic = "'.$newPic.'" WHERE id = '.$oldID.';';
	    echo '��������� ���������.<br>';
    	
    	$ath = mysql_query($newReqest);
    	exit();	
    }
    else
    {
    	echo '�� �� ����� �������� ������.';
    	changeRecord($oldID);
    	exit();
    }
}

if(isset($_GET['value']))
{
	changeRecord($_GET['value']);
}

?>
</div>