<?php 
    if(!empty($_POST)){
        switch($_POST['method']){
            case 'addVote':
                addVote($_POST);
                break;
            case 'searchRegions':
                searchRegions();
                break;
            case 'searchCandidates':
                searchCandidates();
                break;
            case 'searchCommunes': 
                searchCommunes($_POST);
                break;
        }                    
    }

    function addVote( $vote = null){
        $response = array('status' => 'failed');
        
        if( !empty($vote['vote'])){

            include_once ('../models/vote.php');
            
            $voteModel = new Vote();
            $voteArr = array();
            parse_str($vote['vote'],$voteArr);

            if( $voteModel->saveVote($voteArr) ){
                $response = array('status' => 'success');
            }
        }

        echo json_encode($response);
    }

    function searchRegions(){
        include_once ('../models/region.php');
        
        $regions = new Region();
        $data = $regions->searchRegions();
        
        if( $data ){
            $options = '';
            while ($row = $data->fetch_assoc()) {
                $options .= '<option value='.$row['ID_REGION'].'>'.$row['NAME_REGION'].'</option>';
            }
        }

        echo $options;
    }

    function searchCommunes( $data = null){
        include_once ('../models/commune.php');
        
        $region = !empty($data['region']) ? $data['region'] : 1;
        
        $communes = new Commune();
        $data = $communes->searchCommunes($region);
        if( $data ){
            $options = '';
            while ($row = $data->fetch_assoc()) {
                $options .= '<option value='.$row['ID_COMMUNE'].'>'.$row['NAME_COMMUNE'].'</option>';
            }
        }

        echo $options;
    }

    function searchCandidates(){
        include_once ('../models/candidate.php');
        
        $candidates = new Candidate();
        $data = $candidates->searchCandidates();
        
        if( $data ){
            $options = '';
            while ($row = $data->fetch_assoc()) {
                $options .= '<option value='.$row['ID_CANDIDATE'].'>'.$row['NAME_CANDIDATE'].'</option>';
            }
        }

        echo $options;
    }
?>