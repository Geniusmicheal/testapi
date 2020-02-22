<?php
    require_once('DbConnection.php');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With,Content-Type, Accept, Authorization");
    header("Content-Type: application/json");
    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $message='Request Method is not valid.';
        $errorMsg = json_encode(['error' => ['status'=>'100', 'message'=>$message]]);
        echo $errorMsg; exit;
    }
    	
	$api = new DbConnection;
	$db =$api->connect();
	$result = $db->query("SELECT * FROM film ORDER BY filmdate DESC");
	 $film=[];
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()){
	       $sql="SELECT * FROM comment WhERE film_id= ".$row['id']." ORDER BY date_comm DESC";
	       //echo $sql;die;
	        $row['comment']= $api->select($sql);
	        $row['totalComment'] = count($row['comment']);
	         array_push($film,$row);
	    }
	    	var_dump($film); die;
	    $errorMsg = json_encode(['success' => ['status'=>'200', 'message'=>$film]]);
        echo $errorMsg; exit;
	}else{
        $errorMsg = json_encode(['error' => ['status'=>'200', 'message'=>'No result found']]);
        echo $errorMsg; exit;
    }
	        

    // $handler = fopen('php://input', 'r');
    // $this->request = stream_get_contents($handler);
    
    
?>