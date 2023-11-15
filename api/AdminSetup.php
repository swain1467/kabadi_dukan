<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");

$action = $_REQUEST['action'];

try{
    switch($action){
    // Item Tab1 Start===============================
        case 'GetItemList':{
            $output = AdminSetup::GetItemList();
            break;
        }
        case 'SaveItem':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $item_name = isset($_POST['item_name']) ? $_POST['item_name'] : '';
            $item_status = isset($_POST['item_status']) ? $_POST['item_status'] : '';
            $output = AdminSetup::SaveItem($id, $item_name, $item_status);
            break;
        }
    // City Tab-2 Start===============================
        case 'GetCPS':{
            $output = AdminSetup::GetCPS();
            break;
        }
        case 'GetCityList':{
            $length = isset($_GET['length']) ? $_GET['length'] : '';
            $start = isset($_GET['start']) ? $_GET['start'] : '';
            $search = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
            $output = AdminSetup::GetCityList($length, $start, $search);
            break;
        }
        case 'SaveCity':{
            $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
            $city_name = isset($_POST['city_name']) ? $_POST['city_name'] : '';
            $commission = isset($_POST['commission']) ? $_POST['commission'] : '';
            $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person'] : '';
            $city_status = isset($_POST['city_status']) ? $_POST['city_status'] : '';
            $output = AdminSetup::SaveCity($city_id, $city_name, $commission, $contact_person, $city_status);
            break;
        }
    // CTIM Tab3 Start===============================
        case 'GetCity':{
            $output = AdminSetup::GetCity();
            break;
        }
        case 'GetCTIMList':{
            $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
            $output = AdminSetup::GetCTIMList($city_id);
            break;
        }
        case 'SaveCTIM':{
            $ctim_id = isset($_POST['ctim_id']) ? $_POST['ctim_id'] : '';
            $pricing = isset($_POST['pricing']) ? $_POST['pricing'] : '';
            $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $item = isset($_POST['item']) ? $_POST['item'] : '';
            $ctim_status = isset($_POST['ctim_status']) ? $_POST['ctim_status'] : '';
            $output = AdminSetup::SaveCTIM($ctim_id, $pricing, $unit, $city, $item, $ctim_status);
            break;
        }
    // Area Tab4 Start===============================
        case 'GetAreaList':{
            $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
            $output = AdminSetup::GetAreaList($city_id);
            break;
        }
        case 'SaveArea':{
            $area_id = isset($_POST['area_id']) ? $_POST['area_id'] : '';
            $area_name = isset($_POST['area_name']) ? $_POST['area_name'] : '';
            $city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
            $area_status = isset($_POST['area_status']) ? $_POST['area_status'] : '';
            $output = AdminSetup::SaveArea($area_id, $area_name, $city_id, $area_status);
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
// Model Start From Here
class AdminSetup {
// Item Tab1 Start===============================
    public static function GetItemList() {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [];
        $selectQuery = "SELECT id, item_name, status
                        FROM admin_item_master ORDER BY item_name";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
    
        if($result['status']){
            $slno = 1; 
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
    public static function SaveItem($id, $item_name, $item_status) {
        $output = array('status' => '', 'message' => '');
        if(!$item_name){
            throw new Exception('Item name required');
        }
        if($id == ''){
            $data = [
                'item_name' => $item_name,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'item_status' => $item_status,
            ];
            $inserQuery = "INSERT INTO admin_item_master(item_name, created_on, created_by, updated_on, updated_by, status)
            VALUES (:item_name, :created_on, :created_by, :updated_on, :updated_by, :item_status)";
            $result = DBCore::executeQuery($inserQuery,$data);
            if($result['status']){
                $output['status'] = 'Success';
                $output['message'] = 'Item added successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }else{
            $data = [
                'item_name' => $item_name,
                'item_status' => $item_status,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'id' => $id
            ];
            $updateQuery = "UPDATE admin_item_master 
                            SET item_name = :item_name, status = :item_status, 
                            updated_on = :updated_on, updated_by = :updated_by
                            WHERE id = :id";
            $result = DBCore::executeQuery($updateQuery,$data);
            $res = DBCore::rowAffected($result);
        
            if($res == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Item updated successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }
        return $output;
    }
// City Tab-2 Start===============================
    public static function GetCPS() {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'user_type' => "USER",
            'status' => 1
        ];

        $selectQuery = "SELECT id AS contact_person_id, CONCAT(name,'( ',contact_no,' )') AS contact_person_name  
                        FROM user_master WHERE user_type !=:user_type AND status =:status
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
    public static function GetCityList($length, $start, $search) {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
        ];
        $selectQuery = "SELECT * FROM admin_city_master";
        $result = DBCore::executeQuery($selectQuery,$data);
        $total_reccord = DBCore::getAllRows($result);
        $output['iTotalDisplayRecords'] = COUNT($total_reccord);

        $selectQuery = "SELECT A.city_name, A.id, A.contact_person AS contact_person_id, A.status,
                        CONCAT(B.name,'( ',B.contact_no,' )') AS contact_person_name, A.commission 
                        FROM admin_city_master A
                        LEFT JOIN user_master B ON A.contact_person = B.id AND B.status = 1 AND B.user_type !='USER'
                        WHERE A.city_name LIKE '%$search%' OR B.name LIKE '%$search%'
                        ORDER BY A.city_name LIMIT $length OFFSET $start";
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
    public static function SaveCity($city_id, $city_name, $commission, $contact_person, $city_status) {
        $output = array('status' => '', 'message' => '');
        if(!$city_name){
            throw new Exception('City name required');
        }
        if(!$contact_person){
            throw new Exception('Contact person is required');
        }
        if(!$commission){
            throw new Exception('Commission is required');
        } 
        if (filter_var($commission, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid commission');
        }
        if($city_id == ''){
            $data = [
                'city_name' => $city_name,
                'commission' => $commission,
                'contact_person' => $contact_person,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'city_status' => $city_status,
            ];
            $inserQuery = "INSERT INTO admin_city_master(city_name, commission, contact_person, created_on, created_by, updated_on, updated_by, status)
            VALUES (:city_name, :commission, :contact_person, :created_on, :created_by, :updated_on, :updated_by, :city_status)";
            $result = DBCore::executeQuery($inserQuery,$data);
            if($result['status']){
                $output['status'] = 'Success';
                $output['message'] = 'City added successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }else{
            $data = [
                'city_name' => $city_name,
                'commission' => $commission,
                'contact_person' => $contact_person,
                'city_status' => $city_status,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'city_id' => $city_id
            ];
            $updateQuery = "UPDATE admin_city_master 
                            SET city_name = :city_name, commission = :commission, 
                            contact_person = :contact_person, status = :city_status, 
                            updated_on = :updated_on, updated_by = :updated_by
                            WHERE id = :city_id";
            $result = DBCore::executeQuery($updateQuery,$data);
            $res = DBCore::rowAffected($result);
        
            if($res == 1){
                $output['status'] = 'Success';
                $output['message'] = 'City updated successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }
       return $output;
    }
// CTIM Tab3 Start===============================
    public static function GetCity() {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'status' => 1
        ];
        $selectQuery = "SELECT id AS city_id, city_name FROM admin_city_master
                        WHERE status = :status ORDER BY city_name";
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
    public static function GetCTIMList($city_id) {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'city_id' => $city_id
        ];
        $selectQuery = "SELECT A.id, A.pricing, A.city AS city_id, A.status, A.unit,
                        A.item AS item_id, A.status, B.city_name, C.item_name
                        FROM admin_city_to_item_map A
                        INNER JOIN admin_city_master B ON A.city = B.id AND B.status = 1
                        INNER JOIN admin_item_master C ON A.item = C.id AND C.status = 1
                        WHERE A.city = :city_id ORDER BY C.item_name";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
    
        if($result['status']){
            $slno = 1; 
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
    public static function SaveCTIM($ctim_id, $pricing, $unit, $city, $item, $ctim_status) {
        $output = array('status' => '', 'message' => '');
        if(!$pricing){
            throw new Exception('Pricing is required');
        } 
        if(!$unit){
            throw new Exception('Unit is required');
        } 
        if(!$city){
            throw new Exception('City/Town name required');
        }
        if(!$item){
            throw new Exception('Item is required');
        }
        if($ctim_id == ''){
            $data = [
                'city' => $city,
                'item' => $item,
                'pricing' => $pricing,
                'unit' => $unit,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'ctim_status' => $ctim_status,
            ];
            $inserQuery = "INSERT INTO admin_city_to_item_map(city, item, pricing, unit, created_on, created_by, updated_on, updated_by, status)
            VALUES (:city, :item, :pricing, :unit, :created_on, :created_by, :updated_on, :updated_by, :ctim_status)";
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
                'city' => $city,
                'item' => $item,
                'pricing' => $pricing,
                'unit' => $unit,
                'ctim_status' => $ctim_status,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'ctim_id' => $ctim_id
            ];
            $updateQuery = "UPDATE admin_city_to_item_map 
                            SET city = :city, item = :item,
                            pricing = :pricing, unit = :unit,
                            status = :ctim_status, updated_on = :updated_on,
                            updated_by = :updated_by
                            WHERE id = :ctim_id";
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
// Area Tab4 Start===============================
    public static function GetAreaList($city_id) {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'city_id' => $city_id
        ];
        $selectQuery = "SELECT A.id, A.area_name, A.city, A.status, B.city_name
                        FROM admin_area_master A
                        LEFT JOIN admin_city_master B ON A.city = B.id AND B.status = 1
                        WHERE A.city = :city_id ORDER BY A.area_name";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);

        if($result['status']){
            $slno = 1; 
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
    public static function SaveArea($area_id, $area_name, $city_id, $area_status) {
        $output = array('status' => '', 'message' => '');
        if(!$area_name){
            throw new Exception('City name required');
        }
        if(!$city_id){
            throw new Exception('Contact person is required');
        }
        if($area_id == ''){
            $data = [
                'area_name' => $area_name,
                'city_id' => $city_id,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'area_status' => $area_status,
            ];
            $inserQuery = "INSERT INTO admin_area_master(area_name, city, created_on, created_by, updated_on, updated_by, status)
            VALUES (:area_name, :city_id, :created_on, :created_by, :updated_on, :updated_by, :area_status)";
            $result = DBCore::executeQuery($inserQuery,$data);
            if($result['status']){
                $output['status'] = 'Success';
                $output['message'] = 'Area added successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }else{
            $data = [
                'area_name' => $area_name,
                'city_id' => $city_id,
                'area_status' => $area_status,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'area_id' => $area_id
            ];
            $updateQuery = "UPDATE admin_area_master 
                            SET area_name = :area_name, city = :city_id,
                            status = :area_status, updated_on = :updated_on,
                            updated_by = :updated_by
                            WHERE id = :area_id";
            $result = DBCore::executeQuery($updateQuery,$data);
            $res = DBCore::rowAffected($result);
        
            if($res == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Area updated successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
        }
    return $output;
    }
}
?>