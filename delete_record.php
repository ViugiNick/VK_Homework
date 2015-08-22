<head>
  <link href="style.css" rel="stylesheet">
</head>

<div class="productList">
<?php

$link = mysql_connect('localhost', 'root', 'user') or die('Не удалось соединиться: ' . mysql_error());
mysql_select_db('goods') or die('Не удалось выбрать базу данных');

echo '<div class = "header">';
echo '<table><tr>';
echo '<td><a href="index.php">Вернуться к списку товаров</a></td>';
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
      $ath = mysql_query("DELETE FROM goods WHERE id = ".$aDoor[$i].";");
      echo 'Товар с id '.$aDoor[$i].' уcпешно удален.<br>';
    }
  }
}
echo '</div>';
?>
</div>