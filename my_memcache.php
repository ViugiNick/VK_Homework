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
			die("������������ ������: $query <br> ".mysql_error());
		
		#echo "<b>������ ��� ��������:</b>$query<br>";
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
        	#echo "<b>��������� � ���:</b> $query<br>";
            #echo $result;
            return $result;
        }
        else
        {
        	#echo "<b>��� �� ��������:</b> $query<br>";

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