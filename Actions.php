<?php 
session_start();
require_once('DBConnection.php');

Class Actions extends DBConnection{
    function __construct(){
        parent::__construct();
    }
    function __destruct(){
        parent::__destruct();
    }
    function login(){
        extract($_POST);
        $sql = "SELECT * FROM user_list where username = '{$username}' and `password` = '".md5($password)."' ";
        @$qry = $this->query($sql)->fetchArray();
        if(!$qry){
            $resp['status'] = "failed";
            $resp['msg'] = "Invalid username or password.";
        }else{
            $resp['status'] = "success";
            $resp['msg'] = "Login successfully.";
            foreach($qry as $k => $v){
                if(!is_numeric($k))
                $_SESSION[$k] = $v;
            }
        }
        return json_encode($resp);
    }
    function logout(){
        session_destroy();
        header("location:./login.php");
    }
    function c_login(){
        extract($_POST);
        $sql = "SELECT * FROM cashier_list where cashier_id = '{$cashier_id}'";
        @$qry = $this->query($sql)->fetchArray();
        if($qry){
            if($qry['log_status'] == 0){
                $resp['status'] = "success";
                $resp['msg'] = "Login successfully.";
                $this->query("UPDATE `cashier_list` set log_status = 1 where cashier_id  = {$cashier_id}");
                foreach($qry as $k => $v){
                    if(!is_numeric($k))
                    $_SESSION[$k] = $v;
                }
            }else{
                $resp['failed'] = "failed";
                $resp['msg'] = "Cashier is In-Use.";
            }
        }else{
            $resp['status'] = "success";
            $resp['msg'] = "An Error occured. Error: ".$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function c_logout(){
        session_destroy();
                $this->query("UPDATE `cashier_list` set log_status = 0 where cashier_id  = {$_SESSION['cashier_id']}");
        header("location:./cashier");
    }
    function save_user(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
        if(!in_array($k,array('id'))){
            if(!empty($id)){
                if(!empty($data)) $data .= ",";
                $data .= " `{$k}` = '{$v}' ";
                }else{
                    $cols[] = $k;
                    $values[] = "'{$v}'";
                }
            }
        }
        if(empty($id)){
            $cols[] = 'password';
            $values[] = "'".md5($username)."'";
        }
        if(isset($cols) && isset($values)){
            $data = "(".implode(',',$cols).") VALUES (".implode(',',$values).")";
        }
        

       
        @$check= $this->query("SELECT count(user_id) as `count` FROM user_list where `username` = '{$username}' ".($id > 0 ? " and user_id != '{$id}' " : ""))->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Username already exists.";
        }else{
            if(empty($id)){
                $sql = "INSERT INTO `user_list` {$data}";
            }else{
                $sql = "UPDATE `user_list` set {$data} where user_id = '{$id}'";
            }
            @$save = $this->query($sql);
            if($save){
                $resp['status'] = 'success';
                if(empty($id))
                $resp['msg'] = 'New User successfully saved.';
                else
                $resp['msg'] = 'User Details successfully updated.';
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'Saving User Details Failed. Error: '.$this->lastErrorMsg();
                $resp['sql'] =$sql;
            }
        }
        return json_encode($resp);
    }
    function delete_user(){
        extract($_POST);

        @$delete = $this->query("DELETE FROM `user_list` where rowid = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'User successfully deleted.';
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function update_credentials(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id','old_password')) && !empty($v)){
                if(!empty($data)) $data .= ",";
                if($k == 'password') $v = md5($v);
                $data .= " `{$k}` = '{$v}' ";
            }
        }
        if(!empty($password) && md5($old_password) != $_SESSION['password']){
            $resp['status'] = 'failed';
            $resp['msg'] = "Old password is incorrect.";
        }else{
            $sql = "UPDATE `user_list` set {$data} where user_id = '{$_SESSION['user_id']}'";
            @$save = $this->query($sql);
            if($save){
                $resp['status'] = 'success';
                $_SESSION['flashdata']['type'] = 'success';
                $_SESSION['flashdata']['msg'] = 'Credential successfully updated.';
                foreach($_POST as $k => $v){
                    if(!in_array($k,array('id','old_password')) && !empty($v)){
                        if(!empty($data)) $data .= ",";
                        if($k == 'password') $v = md5($v);
                        $_SESSION[$k] = $v;
                    }
                }
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'Updating Credentials Failed. Error: '.$this->lastErrorMsg();
                $resp['sql'] =$sql;
            }
        }
        return json_encode($resp);
    }
    function save_cashier(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id'))){
                $v = addslashes(trim($v));
            if(empty($id)){
                $cols[] = "`{$k}`";
                $vals[] = "'{$v}'";
            }else{
                if(!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
            }
        }
        if(isset($cols) && isset($vals)){
            $cols_join = implode(",",$cols);
            $vals_join = implode(",",$vals);
        }
        if(empty($id)){
            $sql = "INSERT INTO `cashier_list` ({$cols_join}) VALUES ($vals_join)";
        }else{
            $sql = "UPDATE `cashier_list` set {$data} where cashier_id = '{$id}'";
        }
        @$check= $this->query("SELECT COUNT(cashier_id) as count from `cashier_list` where `name` = '{$name}' ".($id > 0 ? " and cashier_id != '{$id}'" : ""))->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] ='failed';
            $resp['msg'] = 'Cashier already exists.';
        }else{
            @$save = $this->query($sql);
            if($save){
                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "Cashier successfully saved.";
                else
                    $resp['msg'] = "Cashier successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New Cashier Failed.";
                else
                    $resp['msg'] = "Updating Cashier Failed.";
                $resp['error']=$this->lastErrorMsg();
            }
        }
        return json_encode($resp);
    }
    function delete_cashier(){
        extract($_POST);
        $get = $this->query("SELECT * FROM `cashier_list` where cashier_id = '{$id}'");
        @$res = $get->fetchArray();
        $is_logged = false;
        if($res){
            $is_logged = $res['log_status'] == 1 ? true : false;
            if($is_logged){
                $resp['status']='failed';
                $resp['msg']='Cashier is in use.';
            }else{
                @$delete = $this->query("DELETE FROM `cashier_list` where cashier_id = '{$id}'");
                if($delete){
                    $resp['status']='success';
                    $_SESSION['flashdata']['type'] = 'success';
                    $_SESSION['flashdata']['msg'] = 'Cashier successfully deleted.';
                }else{
                    $resp['status']='failed';
                    $resp['error']=$this->lastErrorMsg();
                }
            }
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        
        return json_encode($resp);
    }

    function save_queue(){
        $code = sprintf("%'.04d",1);
        while(true){
            $chk = $this->query("SELECT count(queue_id) `count` FROM `queue_list` where queue = '".$code."' and date(date_created) = '".date('Y-m-d')."' ")->fetchArray()['count'];
            if($chk > 0){
                $code = sprintf("%'.04d",abs($code) + 1);
            }else{
                break;
            }
        }


        $_POST['queue'] = $code;
        extract($_POST);
        $sql = "INSERT INTO `queue_list` (`queue`,`customer_name`,`no_tram` ) VALUES('{$queue}','{$customer_name}','{$no_tram}' )";
        $save = $this->query($sql);
        if($save){
            $resp['status'] = 'success';
            $resp['id'] = $this->query("SELECT last_insert_rowid()")->fetchArray()[0];
        }else{
            $resp['status'] = 'failed';
            $resp['msg'] = "An error occured. Error: ".$this->lastErrorMsg();
        }
        return json_encode($resp);
    }

    function get_queue(){
        extract($_POST);
        $qry = $this->query("SELECT * FROM `queue_list` where queue_id = '{$qid}' ");
        @$res = $qry->fetchArray();
            $resp['status']='success';
        if($res){
            $resp['queue']=$res['queue'];
            $resp['name']=$res['customer_name'];
        }else{
            $resp['queue']="";
            $resp['name']="";
        }
        return json_encode($resp);
    }

    function next_queue(){
        extract($_POST);
        $get = $this->query("SELECT queue_id,`queue`,customer_name, no_tram FROM `queue_list` where status = 0 and date(date_created) = '".date("Y-m-d")."' order by queue_id asc  limit 1");

        // $get = $this->query("SELECT queue_id,`queue`,customer_name FROM `queue_list` where status = 0 and date(date_created) = '".date("Y-m-d")."' order by queue_id asc  limit 1");
        @$res = $get->fetchArray();
        $resp['status']='success';
        if($res){
            $this->query("UPDATE `queue_list` set status = 1 where queue_id = '{$res['queue_id']}'");
            $resp['data']=$res;
        }else{
            $resp['data']=$res;
        }
        return json_encode($resp);
    }

    function update_video(){
        extract($_FILES);
        $mime = mime_content_type($vid['tmp_name']);
        if(strstr($mime,'video/') > -1){
            $move = move_uploaded_file($vid['tmp_name'],"./video/".(time())."_{$vid['name']}");
            if($move){
                $resp['status'] = 'success';
                $_SESSION['flashdata']['type']='success';
                $_SESSION['flashdata']['msg']='Video was successfully updated.';
                if(is_file('./video/'.$_POST['video']))
                unlink('./video/'.$_POST['video']);
            }else{
                $resp['status'] = 'false';
                $resp['msg'] = 'Unable to upload the video.';
            }
        }else{
            $resp['status'] = 'false';
            $resp['msg'] = 'Invalid video type.';
        }
        return json_encode($resp);
    }
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$action = new Actions();
switch($a){
    case 'login':
        echo $action->login();
    break;
    case 'c_login':
        echo $action->c_login();
    break;
    case 'logout':
        echo $action->logout();
    break;
    case 'c_logout':
        echo $action->c_logout();
    break;
    case 'save_user':
        echo $action->save_user();
    break;
    case 'delete_user':
        echo $action->delete_user();
    break;
    case 'update_credentials':
        echo $action->update_credentials();
    break;
    case 'save_cashier':
        echo $action->save_cashier();
    break;
    case 'delete_cashier':
        echo $action->delete_cashier();
    break;
    case 'save_queue':
        echo $action->save_queue();
    break;
    case 'get_queue':
        echo $action->get_queue();
    break;
    case 'next_queue':
        echo $action->next_queue();
    break;
    case 'update_video':
        echo $action->update_video();
    break;
    default:
    // default action here
    break;
}