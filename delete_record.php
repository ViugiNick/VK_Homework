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
echo '<table><tr>';
echo '<td><a href="index.php">��������� � ������ �������</a></td>';
echo '</table></tr>';
echo '</div>';
echo '<div class = "product">';

if(isset($_POST['delete']))
{
  $aDoor = $_POST['delete'];
  {
    $N = count($aDoor);
    
    for($i = 0; $i < $N; $i++)
    {
      $ath = sqlSet("DELETE FROM goods WHERE id = ".$aDoor[$i].";");
      echo '����� � id '.$aDoor[$i].' �c����� ������.<br>';
    }
  }
}
echo '</div>';
?>
</div>