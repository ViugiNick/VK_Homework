<head>
  <link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php
    include 'my_memcache.php';


    $link = mysql_connect('localhost', 'root', 'user') or die('�� ������� �����������: ' . mysql_error());
    mysql_select_db('goods') or die('�� ������� ������� ���� ������');

    $memcache_host='localhost';
    $memcache_port=11211;
    $memcache = new Memcache;

    if(!$memcache->pconnect($memcache_host,$memcache_port))
    	die("Memcached �� ��������: $memcache_host:$memcache_port");

    echo '<div class = "header">';
    echo '<div class = "backbutton">';

    echo '<table><tr>';
    echo '<td><a href="index.php">��������� � ������ �������</a></td>';
    echo '</table></tr>';
    echo '</div>';
    echo '</div>';

    echo '<div class = "product">';

    if(isset($_POST['name']))
    {
        $newName = htmlspecialchars($_POST["name"]);
        $newDescription = htmlspecialchars($_POST["description"]);
        $newPrice = htmlspecialchars($_POST["price"]);
        $newPic = htmlspecialchars($_POST["pic"]);

        if($newName != "")
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
        	$ath = sqlSet($newReqest);
        	
        	exit();	
        }
        else
        {
        	echo '�� �� ����� �������� ������.';
        }
    }

    echo '<form action="add_record.php" method = "post">';
    echo '<table>';
    echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" /></td></tr>';
    echo '<tr><td>�������� ������: </td><td><input type="text" name="description" /></td></tr>';
    echo '<tr><td>����:            </td><td><input type="text" name="price" /></td></tr>';
    echo '<tr><td>��������:        </td><td><input type="text" name="pic" /></td></tr>';
    echo '</table>';
    echo '<input type="submit" value="�������� �����" class="my_button">';
    echo '</form>';
    echo '</div>';

?>
</div>