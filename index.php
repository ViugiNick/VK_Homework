<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
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

    $link = mysql_connect('localhost', 'nfuogibo', 'T6iT0i0a1j') or die('�� ������� �����������: ' . mysql_error());
    mysql_select_db('nfuogibo_goods') or die('�� ������� ������� ���� ������ nfuogibo_goods');

    $memcache_host='localhost';
    $memcache_port=11211;
    $memcache = new Memcache;

    if(!$memcache->connect($memcache_host,$memcache_port))
    	die("Memcached �� ��������: $memcache_host:$memcache_port");

    if($sortingOrder == 'id')
    	$ath = sqlGet("SELECT * FROM goods ORDER BY id ASC;");
    	#$ath = mysql_query("SELECT * FROM goods ORDER BY id ASC;");
    else
    	#$ath = mysql_query("SELECT * FROM goods ORDER BY price ASC;");
    	$ath = sqlGet("SELECT * FROM goods ORDER BY price ASC;");

    echo '<div class = "header">';
    
    echo '<div></div>';

    echo '<table class="menu"><tr>';
    
    echo '<td class="menu">';
   	echo '<a href="add_record.php">�������� �����</a>';
   	echo '</td>';

   	echo '<td class="menu">';
   	echo '<form action="index.php" method="post">';
  	echo '<select name="order" onchange="this.form.submit();">';
   	echo '<option ';
   	if($sortingOrder == 'id')
   		echo 'selected ';
   	echo 'value="id">����������� �� Id</option>';

   	echo '<option '; 
   	if($sortingOrder == 'price')
   		echo 'selected ';

   	echo 'value="price">����������� �� ����</option>';

   	echo '</select>';
   	echo '</form>';
   	echo '</td>';

   	echo '<td class="menu">';
   	echo '<input hidden=true type="submit" name="submit" value="������� ����������" class="my_button" form="deleting">';
   
   	echo '<form name="deleting" id="deleting" action="delete_record.php" method="post">';
   	echo '</td>';
   	echo '</tr></table>';
   	echo '</div>';
    
        echo "<table class = 'contents'><tr>";
    echo "<td width = 20></td> <td width = 50> Id </td> <td width = 610> ����� </td> <td width = 100> ���� </td></tr>";
    echo '</table>';
    
    if($ath)
    {
      	
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