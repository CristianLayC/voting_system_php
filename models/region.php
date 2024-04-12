<?php class Region{
    function __construct(){
        $ip = 'localhost';
        $user = 'root';
        $password = 'root';
        $schema = 'voting_system';

        error_reporting(1);
        $db = new mysqli( $ip,  $user, $password, $schema);

	    if ($db->connect_error) {
	            die("Connection failed: " . $db->connect_error);
	    }
    }

    public function openConection() {
        $ip = 'localhost';
        $user = 'root';
        $password = 'root';
        $schema = 'voting_system';


        $db = new mysqli( $ip,  $user, $password, $schema);
        $db->set_charset("utf8");

	    if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
	    }

        return $db;
    }

    public function searchRegions(){
        $db = $this->openConection();

        $sql = "SELECT * FROM regions";
        $results = $db->query($sql) or mysqli_error($db);
        
        if( $results ){
            return $results;
        }else{
            return false;
        }
    }

} ?>
