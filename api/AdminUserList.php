<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'GetUsersList':{
            $length = isset($_GET['length']) ? $_GET['length'] : '';
            $start = isset($_GET['start']) ? $_GET['start'] : '';
            $search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
            $output = AdminUsersList::GetUsersList($length, $start, $search);
            break;
        }
        case 'UpdateUserDetails':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
            $user_status = isset($_POST['user_status']) ? $_POST['user_status'] : '';
            $output = AdminUsersList::UpdateUserDetails($id, $name, $contact_no, $email, $user_type, $user_status);
            break;
        }
    }
}catch(Exception $e){
    $output = array(	
        'status' => 'Error',
        'message' => $e->getMessage(),
    );
}finally{
    echo json_encode($output);
}
//Model Start From Here
class AdminUsersList {
    public static function GetUsersList($length, $start, $search) {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
        ];
        $selectQuery = "SELECT * FROM user_master";
        $result = DBCore::executeQuery($selectQuery,$data);
        $total_reccord = DBCore::getAllRows($result);
        $output['iTotalDisplayRecords'] = COUNT($total_reccord);

        $selectQuery = "SELECT id, name, mail_address, user_type, status, contact_no  
                        FROM user_master 
                        WHERE name LIKE '%$search%' OR contact_no LIKE '%$search%'
                        OR mail_address LIKE '%$search%'
                        OR user_type LIKE '%$search%' OR status LIKE '%$search%'
                        ORDER BY user_type, name LIMIT $length OFFSET $start";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        $output['iTotalRecords'] = COUNT($all_rows);
        if($result['status']){
            $slno = $start + 1; 
            foreach($all_rows as $row){  
				$row['sl_no'] = $slno;
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
                $slno++;	
            }
          } else {
            $output['status'] = 'Failure';
          }
       return $output;
    }
    public static function UpdateUserDetails($id, $name, $contact_no, $email, $user_type, $user_status) {
        $output = array('status' => '', 'message' => '');
        if(!$name){
            throw new Exception('Name is required');
        }
        if(!$contact_no){
            throw new Exception('Contact number is required');
        } 
        if (filter_var($contact_no, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid contact number');
        }
        if(!$email){
            throw new Exception('Email address is required');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new Exception('Invalid email format');
        }
        if(!$user_type){
            throw new Exception('User type is required');
        }
        $data = [
            'name' => $name,
            'contact_no' => $contact_no,
            'mail_address' => $email,
            'user_type' => $user_type,
            'user_status' => $user_status,
            'updated' => date("Y-m-d H:i:s"),
            'id' => $id
        ];
        $updateQuery = "UPDATE user_master 
                        SET name = :name, contact_no = :contact_no,
                        mail_address = :mail_address, user_type = :user_type, 
                        status = :user_status, updated = :updated 
                        WHERE id = :id";
        $result = DBCore::executeQuery($updateQuery,$data);
        $res = DBCore::rowAffected($result);
    
        if($res == 1){
            $output['status'] = 'Success';
            $output['message'] = 'User details updated successfully';
        } else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! something Went wrong. Please try again';
        }
       return $output;
    }
}
?>
