<?php




function db_insert($table, $values){
	global $pdo_connection;

	$return = array();

	$pdo = new PDO($pdo_connection['mysql'], $pdo_connection['user'], $pdo_connection['pwd']);
			
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	$cols = "";
	$vals = "";
	foreach($values as $key => $value){
		$cols .= $key . ", ";
		$vals .= ":$key, ";
	}

	$cols 	= substr($cols, 0, -2);
	$vals = substr($vals, 0, -2);

	$sql	= "INSERT INTO $table \n($cols) \nVALUES\n($vals);\n\n";		
	
	$statement = $pdo->prepare($sql);

	foreach($values as $key => &$value){
		$key_ = ':' . $key;
		$statement->bindParam($key_, $value);
	}

	try{
		$db_result = $statement->execute();
	}catch (Exception $e){
		$return['pdo_error'] = $e;
	}
	
	if(isset($db_result) && $db_result == true){
		$return['result'] = "ok";
		$return['last_id'] = $pdo->lastInsertId();
	}else{
		$return['result'] = "nok";
		$return['error_info'] = $pdo->errorInfo();
		
	}

	return $return;	
}

function db_update($table, $values, $where_){
	global $pdo_connection;

	$return = array();

	$pdo = new PDO($pdo_connection['mysql'], $pdo_connection['user'], $pdo_connection['pwd']);
			
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	$vals = "";
	foreach($values as $key => $value){
		$vals .= $key . " = :".$key.", ";
	}

	$vals = substr($vals, 0, -2);

	$where_clause = "";
	foreach($where_ as $where){
		$col = db_parse($where['col']);
		$val = ":".db_parse($where['col']);
		$typ = $where['typ'];
		$where_clause .= "$col $typ $val AND ";
	}

	if(strlen($where_clause) > 0){
		$where_clause = substr($where_clause, 0,-4); //remove trailing AND
		$where = "WHERE $where_clause";
	}else{
		$where = "";
	}


	$sql	= "UPDATE $table SET $vals $where";	
	
	$statement = $pdo->prepare($sql);

	foreach($where_ as &$where){
		$value = $where['val'];
		$key = $where['col'];
		$key_ = ':' . $key;
		$statement->bindParam($key_, $value);
	}


	foreach($values as $key => &$value){
		$key_ = ':' . $key;
		$statement->bindParam($key_, $value);
	}

	try{
		$db_result = $statement->execute();
	}catch (Exception $e){
		$return['pdo_error'] = $e;
	}
	
	if(isset($db_result) && $db_result == true){
		$return['result'] = "ok";
		
	}else{
		$return['result'] = "nok";
		$return['error_info'] = $pdo->errorInfo();
		
	}
	return $return;	
}


function db_delete($table, $where_){
	global $pdo_connection;

	$return = array();

	$pdo = new PDO($pdo_connection['mysql'], $pdo_connection['user'], $pdo_connection['pwd']);
			
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	$where_clause = "";
	foreach($where_ as $where){
		$col = db_parse($where['col']);
		$val = ":".db_parse($where['col']);
		$typ = $where['typ'];
		$where_clause .= "$col $typ $val AND ";
	}

	if(strlen($where_clause) > 0){
		$where_clause = substr($where_clause, 0,-4); //remove trailing AND
		$where = "WHERE $where_clause";
	}else{
		$where = "";
	}




	$sql	= "DELETE FROM $table $where";		
	
	$statement = $pdo->prepare($sql);

	foreach($where_ as &$where){
		$value = $where['val'];
		$key = $where['col'];
		$key_ = ':' . $key;
		$statement->bindParam($key_, $value);
	}

	$return['sql'] = $sql;

	try{
		$db_result = $statement->execute();
	}catch (Exception $e){
		$return['pdo_error'] = $e;
	}
	
	if(isset($db_result) && $db_result == true){
		$return['result'] = "ok";
		
	}else{
		$return['result'] = "nok";
		$return['error_info'] = $pdo->errorInfo();
		
	}

	return $return;	
}


function db_select($table, $where_=array(), $order_ = array(), $limit = null, $parse=true){
	global $pdo_connection;
	$return = array();

	$pdo = new PDO($pdo_connection['mysql'], $pdo_connection['user'], $pdo_connection['pwd']);

	//generatere WHERE
	$where_clause = "";
	foreach($where_ as $where){

		if($where['val'] == "NULL"){
			$col = db_parse($where['col']);
			$where_clause .= "$col IS NULL AND ";
		}else{
			$col = db_parse($where['col']);
			$val = ":".db_parse($where['col']);
			$typ = $where['typ'];
			$where_clause .= "$col $typ $val AND ";
		}
	}

	if(strlen($where_clause) > 0){
		$where_clause = substr($where_clause, 0,-4); //remove trailing AND
		$where = "WHERE  $where_clause ";
	}else{
		$where = "";
	}

	//generate ORDER

	$order_clause = "";

	foreach($order_ as $order){
		$col = db_parse($order['col']);
		$dir = db_parse($order['dir']);

		$order_clause .= "$col $dir, ";
	}

	if(strlen($order_clause) > 0){
		$order_clause = substr($order_clause, 0,-2); //remove trailing comma
		$order = "ORDER BY $order_clause";
	}else{
		$order = "";
	}


	//set LIMIT

	if($limit != null){
		$limit = "LIMIT $limit";
	}else{
		$limit = "";
	}

	//generate SQL

	$sql = "SELECT * FROM $table $where $order $limit"; 
	
	$statement = $pdo->prepare($sql);


	foreach($where_ as &$where){
		$value = $where['val'];
		$key = db_parse($where['col']);
		$key_ = ':' . $key;
		$statement->bindParam($key_, $value);
	}

	$selected = $statement->execute();

	while($row = $statement->fetch(PDO::FETCH_ASSOC)){

		if($parse){
			foreach ($row as $key => $value){
				$row[$key] = db_parse($value);
			}
		}
			
		array_push($return, $row);
	}

	return $return;

}




function db_select_injectable($table, $where_=array(), $order_ = array(), $limit = null, $parse=true){
	global $pdo_connection;
	$return = array();

	$pdo = new PDO($pdo_connection['mysql'], $pdo_connection['user'], $pdo_connection['pwd']);

	//generatere WHERE
	$where_clause = "";
	foreach($where_ as $where){

		if($where['val'] == "NULL"){
			$col = db_parse($where['col']);
			$where_clause .= "$col IS NULL AND ";
		}else{
			$col = db_parse($where['col']);
			$val = db_parse($where['val']);
			$typ = $where['typ'];
			$where_clause .= "$col $typ $val AND ";
		}
	}

	if(strlen($where_clause) > 0){
		$where_clause = substr($where_clause, 0,-4); //remove trailing AND
		$where = "WHERE  $where_clause ";
	}else{
		$where = "";
	}

	//generate ORDER

	$order_clause = "";

	foreach($order_ as $order){
		$col = db_parse($order['col']);
		$dir = db_parse($order['dir']);

		$order_clause .= "$col $dir, ";
	}

	if(strlen($order_clause) > 0){
		$order_clause = substr($order_clause, 0,-2); //remove trailing comma
		$order = "ORDER BY $order_clause";
	}else{
		$order = "";
	}


	//set LIMIT

	if($limit != null){
		$limit = "LIMIT $limit";
	}else{
		$limit = "";
	}

	//generate SQL

	$sql = "SELECT * FROM $table $where $order $limit"; 
	echo $sql;
	$statement = $pdo->prepare($sql);




	$selected = $statement->execute();

	while($row = $statement->fetch(PDO::FETCH_ASSOC)){

		if($parse){
			foreach ($row as $key => $value){
				$row[$key] = db_parse($value);
			}
		}
			
		array_push($return, $row);
	}

	return $return;

}




	/*
	====================================================================================
	====================================================================================
	============================ SPECIAL DATABASE FUNCTIONS ============================
	====================================================================================
	====================================================================================
 */

	function db_get_user($user_id){
		$where = array();
		$wh['col'] = "tr_user_id";
		$wh['typ'] = "=";
		$wh['val'] = $user_id;
		array_push($where, $wh);

		$db_result = db_select("tr_user", $where);

		if(count($db_result) > 0){
			$db_result = $db_result[0];
		}else{
			$db_result = array();
			$db_result['tr_user_name'] = "no user found";
		}

		$db_result['user_full'] = $db_result['tr_user_name'];
		$db_result['user_external'] = $db_result['tr_user_name'];
		$db_result['user_shortname'] = $db_result['tr_user_name'];

		
		return $db_result;
	
	}

	
	function db_get_status($status_id){
		$where = array();
		$wh['col'] = "scrap_vehicle_status_id";
		$wh['typ'] = "=";
		$wh['val'] = $status_id;
		array_push($where, $wh);

		$db_result = db_select("scrap_vehicle_status", $where)[0];
	
		
		return $db_result;
	
	}


/*
	====================================================================================
	====================================================================================
	============================    FORMATTING FUNCTIONS    ============================
	====================================================================================
	====================================================================================
 */
	

	function de_umlaut($input){
		$input	= str_replace("ä", "&auml;", $input);
		$input	= str_replace("ö", "&ouml;", $input);
		$input	= str_replace("ü", "&uuml;", $input);

		$input	= str_replace("Ä", "&Äuml;", $input);
		$input	= str_replace("Ö", "&Öuml;", $input);
		$input	= str_replace("Ü", "&Üuml;", $input);
		
		$input	= str_replace("ß", "&szlig;", $input);

		return ($input);
	}

	
	function nl2p($string, $line_breaks = true, $xml = true) {

		$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

		// It is conceivable that people might still want single line-breaks
		// without breaking into a new paragraph.
		if ($line_breaks == true)
			return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
		else 
			return '<p>'.preg_replace(
			array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
			array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),

			trim($string)).'</p>'; 
	}
	
	function nl2pp($string)
	{
		$paragraphs = '';

		foreach (explode("\n", $string) as $line) {
			if (trim($line)) {
				$paragraphs .= '<p>' . $line . '</p>';
			}
		}

		return $paragraphs;
	}

	
	function format_german_phone($number){
		$countrycode="";
		if(substr($number,0,1) != "+"){
			$countrycode = "+49";
		}

		

	}
	
	
	function format_thousands($number){
		
		$number = number_format($number, 0, ",", ".");
		return $number;
	}
	
	//prevent xss
	function db_parse($input){
		if($input == null){
			$output = null;
		}else{
			$output = htmlspecialchars($input);
		}
		return $output;
	}

	function format_filenumber($number){
		return sprintf('%06d', $number);
	}
	
	
	
	
?>