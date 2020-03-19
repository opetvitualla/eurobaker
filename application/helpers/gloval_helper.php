<?php
    function ajax_response($message, $type){
        $data = array(
            'message' => $message,
            'type' => $type
        );
        echo json_encode($data);
        exit;
    }


    function get_user_id(){
        $ci = & get_instance();
        if($ci->session->has_userdata("user_id")){
            return $ci->session->userdata("user_id");
        }
        exit;
    }

    function get_post(){
        $ci = & get_instance();
        return $ci->input->post();
    }

    function swal_data($msg, $err = "success"){
        $ci = & get_instance();
        $ci->session->set_flashdata("flash_data", array( "err"=>$err, "message" => $msg));
    }
    
    function get_logged_user($typ = "array"){
        $ci = & get_instance();
        if($typ== "array"){
            return $ci->session->userdata();
        }
        else if($typ== "obj"){
            return (object) $ci->session->userdata();
        }
        else if($typ== "json"){
            return json_encode($ci->session->userdata());
        }
        exit;
    }

    function getData($tbl ="", $par = array(), $r = "array"){
        $ci = & get_instance();
        $res=  $ci->MY_Model->getRows($tbl, $par, $r);
        return $res;
    }

    function insertData($tbl ="", $data = array()){
        $ci = & get_instance();
        $res=  $ci->MY_Model->insert($tbl, $data);
        return $res;
    }

    function updateData($tbl ="", $set, $where = array()){
        $ci = & get_instance();
        $res=  $ci->MY_Model->update($tbl, $set, $where);
        return $res;
    }

    function deleteData($tbl ="", $where = array()){
        $ci = & get_instance();
        $res=  $ci->MY_Model->delete($tbl, $where);
        return $res;
    }

    function batchInsertData($tbl ="", $set = array()){
        $ci = & get_instance();
        $res=  $ci->MY_Model->batch_insert($tbl, $set);
        return $res;
    }
 
?>
