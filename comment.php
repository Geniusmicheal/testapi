<?php
    require_once('DbConnection.php');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With,Content-Type, Accept, Authorization");
    header("Content-Type: application/json");
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $message='Request Method is not valid.';
        $errorMsg = json_encode(['error' => ['status'=>'100', 'message'=>$message]]);
        echo $errorMsg; exit;
    }
    	
    $handler = fopen('php://input', 'r');
    $data= json_decode(stream_get_contents($handler), true);
   
    	
	$api = new DbConnection;
		$db= $api->connect();
// 	var_dump($data["comment"]);die;
	    if( empty($data['comment']) && (strlen($data['comment']) >= 500)){
	        $errorMsg = json_encode(['error' => ['status'=>'200', 'message'=>'Inviald comment and maximum characters must be 500' ]]);
            echo $errorMsg; exit;
	    }
	    
	    if( empty($data['film_id']) && (is_int($data['film_id']) == false )){
	        $errorMsg = json_encode(['error' => ['status'=>'200', 'message'=>'Inviald film_id and value must be integer' ]]);
            echo $errorMsg; exit;
	    }
	    
        // Function to get the client IP address
        
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
	
		$sql = "INSERT INTO comment(comment, ip_address, film_id) VALUES( '{$db->real_escape_string($data['comment'])}' , '{$db->real_escape_string($ipaddress)}', '{$db->real_escape_string($data['film_id'])}'); ";
    // 	break;
     $api->insert($sql);
	
	 $errorMsg = json_encode(['success' => ['status'=>'200', 'message'=>"comment successfully inserted"]]);
    echo $errorMsg; exit;
	
   
    
    
?>