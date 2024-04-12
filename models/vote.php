<?php class Vote{
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

    public function saveVote($vote = null){
        $db = $this->openConection();

        $whoRRSS = isset($vote['whoRRSS']) ? 1 : 'null';
        $whoIE = isset($vote['whoIE']) ? 1 : 'null';
        $whoFriend = isset($vote['whoFriend']) ? 1 : 'null';
        $whoTV = isset($vote['whoTV']) ? 1 : 'null';
        
        $sql = "INSERT INTO votes (NAME_VOTE, ALIAS_VOTE, RUT_VOTE, EMAIL_VOTE, WHORRSS_VOTE, WHOIE_VOTE, WHOFRIEND_VOTE, WHOTV_VOTE, ID_CANDIDATE, ID_COMMUNE) VALUES ('".$vote['name']."', '".$vote['alias']."', '".$vote['rut']."', '".$vote['email']."', ".$whoRRSS.", ".$whoIE.", ".$whoFriend.", ".$whoTV.", ".$vote['candidate'].",".$vote['commune'].")";
        
        $results = $db->query($sql) or mysqli_error($db);
        
        if( $results ){
            return true;
        }else{
            return false;
        }
    }

} ?>
