<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<head>
	<link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php
    include 'my_memcache.php';


    $link = mysql_connect('localhost', 'nfuogibo', '---') or die('�� ������� �����������: ' . mysql_error());
    mysql_select_db('nfuogibo_goods') or die('�� ������� ������� ���� ������ nfuogibo_goods');

    $memcache_host='localhost';
    $memcache_port=11211;
    $memcache = new Memcache;

    if(!$memcache->pconnect($memcache_host,$memcache_port))
    	die("Memcached �� ��������: $memcache_host:$memcache_port");

    echo '<div class = "header">';
    echo '<table class = "menu"><tr>';
    
    echo '<td class = "menu">';
    echo '<a href="index.php">��������� � ������ �������</a>';
    echo '</td>';
    
    echo '</tr></table>';
    
    echo '</div>';

    echo '<div class = "product">';

    if(isset($_POST['name']))
    {
        $newName = $_POST["name"];
        $newDescription = $_POST["description"];
        $newPrice = $_POST["price"];
        $newPic = $_POST["pic"];

        if($newName != ""  and is_numeric($newPrice))
        {
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
        	
        	$ath = sqlSet($newReqest, -1);
        	
        	exit();	
        }
        else
        {
        	if($newName == "")
        		echo '�� �� ����� �������� ������.<br>';
        	if(!is_numeric ($newPrice))
        		echo '���� ������ ���� ������.<br>';
        	
			echo '<form action="add_record.php" method = "post">';
       		echo '<table>';
       		echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" value="'.$newName.'"/></td></tr>';
       		echo '<tr><td>�������� ������: </td><td><input type="text" name="description" value="'.$newDescription.'"/></td></tr>';
       		echo '<tr><td>����:            </td><td><input type="text" name="price" value="'.$newPrice.'"/></td></tr>';
       		echo '<tr><td>��������:        </td><td><input type="text" name="pic" value="'.$newPic.'"/></td></tr>';
       		echo '<tr><td><input type="submit" value="�������� �����" class="my_button"></td></tr>';
       		
       		echo '</table>';
       		echo '</form>';
        	
        	exit();
        }
    }

    echo '<form action="add_record.php" method = "post">';
    echo '<table>';
    echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" /></td></tr>';
    echo '<tr><td>�������� ������: </td><td><input type="text" name="description" /></td></tr>';
    echo '<tr><td>����:            </td><td><input type="text" name="price" /></td></tr>';
    echo '<tr><td>��������:        </td><td><input type="text" name="pic" /></td></tr>';
    echo '<tr><td><input type="submit" value="�������� �����" class="my_button"></td></tr>';
    echo '</table>';
    echo '</form>';
    echo '</div>';

?>
</div>