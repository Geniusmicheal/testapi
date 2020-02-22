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
	$sort=$order='';
	$page = 1;
	// set the number of items to display per page
    $items_per_page = 4;
	
	if(isset($_GET['height'])){
	    if(!empty($_GET['height']) && (is_int(filter_input(INPUT_GET, 'height', FILTER_VALIDATE_INT) == false ))){
            $errorMsg = json_encode(['error' => ['status'=>'200', 'message'=>'Inviald height and value must be integer' ]]);
            echo $errorMsg; exit;
	    }
    }
    
    // determine page number from $_GET
	if(isset($_GET['sort']))$sort=$_GET['sort'];
	if(isset($_GET['order']))$order=$_GET['order'];
	if(isset($_GET['page']) && $_GET['page'] > 1)$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

	// build query
    $offset = ($page - 1) * $items_per_page;
    $film=[];
    $db =$api->connect();
	
    $sql="SELECT * FROM actors ".((isset($_GET['height']))? " WHERE height= ".filter_input(INPUT_GET, 'height', FILTER_VALIDATE_INT) : "" ). ((isset($_GET['sort']))?" ORDER BY ".$sort." ".$order : ""). " LIMIT ". $offset . "," . $items_per_page;
   
    $result = $db->query($sql);
    $count =mysqli_fetch_row($db->query("SELECT COUNT(height) FROM actors;"));
    // var_dump(mysqli_fetch_row($count));die;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $height = ($row['height']/34) .'ft '.($row['height']/24.42).'inches '.$row['height'].'cm';
            $row['height'] =  $height;
            array_push($film,$row);
        }
        $errorMsg = json_encode(['success' => ['status'=>'200', 'message'=>['totalCharacter'=> $count[0] , 'character'=>$film]]]);
        echo $errorMsg; exit;
    }else{
	  $errorMsg = json_encode(['error' => ['status'=>'200', 'message'=>'No result found']]);
        echo $errorMsg; exit;
	}
    
    // DESC
    
		
?>