<head>
  <link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php
    include 'my_memcache.php';

    function changeRecord($id)
    {
    	$ath = sqlGet("SELECT * FROM goods WHERE id = ".$id);
        
        echo '<form action="edit_record.php" method = "post">';
       	echo '<table>';
       	echo '<input type="hidden" name="id" value="'.$ath[0]['id'].'"/>';
       	echo '<tr><td>�������� ������*: </td><td><input type="text" name="name" value="'.$ath[0]['name'].'"/></td></tr>';
       	echo '<tr><td>�������� ������: </td><td><input type="text" name="description" value="'.$ath[0]['description'].'"/></td></tr>';
       	echo '<tr><td>����:            </td><td><input type="text" name="price" value="'.$ath[0]['price'].'"/></td></tr>';
       	echo '<tr><td>��������:        </td><td><input type="text" name="pic" value="'.$ath[0]['pic'].'"/></td></tr>';
       	echo '</table>';
       	echo '<input type="submit" class="my_button" value="��������� ���������">';
       	echo '</form>';
    }

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
        $oldID = htmlspecialchars($_POST["id"]);
        
        $newName = htmlspecialchars($_POST["name"]);
        $newDescription = htmlspecialchars($_POST["description"]);
        $newPrice = htmlspecialchars($_POST["price"]);
        $newPic = htmlspecialchars($_POST["pic"]);

        if($newName != "")
        {
        	$newReqest = 'UPDATE goods SET name = "'.$newName.'"';
        	
        	if($newDescription != "")
        		$newReqest .= ', description = "'.$newDescription.'"';
        	if($newPrice != "")
        		$newReqest .= ', price = '.$newPrice;
        	if($newPic != "")
        		$newReqest .= ', pic = "'.$newPic.'"';
        	
        	$newReqest.=' WHERE id = '.$oldID.';';
    	    echo '��������� ���������.<br>';
        	#echo $newReqest;

        	$ath = sqlSet($newReqest);
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