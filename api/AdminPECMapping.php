<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'GetPerson':{
            $output = AdminPECMapping::GetPerson();
            break;
        }
        case 'GetPECList':{
            $length = isset($_GET['length']) ? $_GET['length'] : '';
            $start = isset($_GET['start']) ? $_GET['start'] : '';
            $search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
            $output = AdminPECMapping::GetPECList($length, $start, $search);
            break;
        }
        case 'SavePEC':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $user = isset($_POST['user']) ? $_POST['user'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $output = AdminPECMapping::SavePEC($id, $user, $city);
            break;
        }
        case 'DeletePEC':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $output = AdminPECMapping::DeletePEC($id);
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
class AdminPECMapping {
    public static function GetPerson() {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'status' => 1
        ];

        $selectQuery = "SELECT id AS contact_person_id, CONCAT(name,'( ',user_type,' )') AS contact_person_name  
                        FROM user_master WHERE user_type IN ('MANAGER', 'EMPLOYEE') AND status =:status
                        ORDER BY name";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        if($result['status']){
            foreach($all_rows as $row){  
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
            }
          } else {
            $output['status'] = 'Failure';
          }
       return $output;
    }
    public static function GetPECList($length, $start, $search) {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [];
        $selectQuery = "SELECT * FROM admin_pec_map";
        $result = DBCore::executeQuery($selectQuery,$data);
        $total_reccord = DBCore::getAllRows($result);
        $output['iTotalDisplayRecords'] = COUNT($total_reccord);

        $selectQuery = "SELECT A.id, A.user, A.city, CONCAT(B.name,'( ',B.user_type,' )') AS person,
                        B.contact_no, B.mail_address, C.city_name
                        FROM admin_pec_map A
                        INNER JOIN user_master B ON A.user = B.id AND B.status = 1
                        INNER JOIN admin_city_master C ON A.city = C.id AND C.status = 1
                        WHERE B.name LIKE '%$search%' OR B.contact_no LIKE '%$search%'
                        OR B.mail_address LIKE '%$search%' OR C.city_name LIKE '%$search%'
                        OR B.user_type LIKE '%$search%'
                        ORDER BY B.user_type, name LIMIT $length OFFSET $start";
                
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
    public static function SavePEC($id, $user, $city) {
        $output = array('status' => '', 'message' => '');
        if(!$user){
            throw new Exception('Emp Or Partner is required');
        }
        if(!$city){
            throw new Exception('City is required');
        }
        if($id == ''){
            $data = [
                'user' => $user,
                'city' => $city,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id']
            ];
            $inserQuery = "INSERT INTO admin_pec_map(user, city, created_on, created_by, updated_on, updated_by)
            VALUES (:user, :city, :created_on, :created_by, :updated_on, :updated_by)";
            $result = DBCore::executeQuery($inserQuery,$data);
            if($result['status']){
                $output['status'] = 'Success';
                $output['message'] = 'Data added successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }else{
            $data = [
                'user' => $user,
                'city' => $city,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'id' => $id,
            ];
            $updateQuery = "UPDATE admin_pec_map 
                            SET user = :user, city = :city, 
                            updated_on = :updated_on, updated_by = :updated_by
                            WHERE id = :id";
            $result = DBCore::executeQuery($updateQuery,$data);
            $res = DBCore::rowAffected($result);
        
            if($res == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Data updated successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }
       return $output;
    }

    public static function DeletePEC($id) {
        $output = array('status' => '', 'message' => '');
    
        $data = [
            'id' => $id
        ];
        $deleteQuery = "DELETE FROM admin_pec_map WHERE id = :id";
        $result = DBCore::executeQuery($deleteQuery,$data);
        if($result['status']){
            $output['status'] = 'Success';
            $output['message'] = 'Data deleted successfully';
        } else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! something Went wrong. Please try again';
        }
       return $output;
    }
}
?>
