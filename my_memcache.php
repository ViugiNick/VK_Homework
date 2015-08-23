<?php
	function cacheGet($key)
	{
    	global $memcache;
		
		return $memcache->get($key);
	}

	function cacheSet($key,$data,$delay)
	{
    	global $memcache;
		
		return $memcache->set($key, $data, false, $delay);
	}

	function sqlQuery($query)
	{
    	$resource=mysql_query($query) or die(mysql_error());
       
        if(!$resource)
			die("Неправильный запрос: $query <br> ".mysql_error());
		
		#echo "<b>Запрос был выполнен:</b>$query<br>";
        return $resource;      
	}

	function sqlSet($query, $id)
	{
		global $memcache;
		$memcache->delete("SELECT * FROM goods ORDER BY id ASC;");
		$memcache->delete("SELECT * FROM goods ORDER BY price ASC;");

		if($id != -1)
		{
			$memcache->delete("SELECT * FROM goods WHERE id = ".$id.";");
		}

		return sqlQuery($query);
	}

	function sqlGet($query)
	{
        $result = cacheGet($query);

        if($result !== false)
        {
        	#echo "<b>Попадание в кеш:</b> $query<br>";
            #echo $result;
            return $result;
        }
        else
        {
        	#echo "<b>Кеш не сработал:</b> $query<br>";

            $resource = sqlQuery($query);
        	#$result = array();       
        
        	while ($row = mysql_fetch_assoc($resource))
        	{
                $result[]=$row;
            }      
        	
        	cacheSet($query, $result, 3600);
            #echo $resource;
            return $result;
    	}
	}
?>