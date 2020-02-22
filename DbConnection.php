<?php 
    /**
    * Database Connection
    */
    class DbConnection {
        private $server = 'localhost';
        private $dbname = 'id12663419_jwtapi';	
        private $user = 'id12663419_root';
        private $pass = '123456789';

        public function connect() {
            try {
                $conn = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
                return $conn;
            } catch (\Exception $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }
        
        public function insert($sql){
            $db = $this->connect();
            if ($db->multi_query($sql) === TRUE) {
                echo "New records created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
                // echo "Error: <br>" . mysqli_error($db);
            }
        }
        
        
        public function select($sql){
            $db = $this->connect();
            $result = $db->query($sql);
            $rec=[];
            // if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    array_push($rec,$row);
                }
                return $rec;
            // }else{
            //     $errorMsg = json_encode(['error' => ['status'=>'200', 'message'=>'No result found']]);
            //     echo $errorMsg; exit;
            // }
        }
    }

?>