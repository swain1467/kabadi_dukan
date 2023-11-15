<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'GetBookingList':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $area = isset($_POST['area']) ? $_POST['area'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : '';
            $take_off_date = isset($_POST['take_off_date']) ? $_POST['take_off_date'] : '';
            $output = AdminTransition::GetBookingList($city, $area, $status, $booking_date, $take_off_date);
            break;
        }
        case 'UpdateBookingDetails':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $code = isset($_POST['code']) ? $_POST['code'] : '';
            $area = isset($_POST['area']) ? $_POST['area'] : '';
            $scrap_price = isset($_POST['scrap_price']) ? $_POST['scrap_price'] : '';
            $take_off_date = isset($_POST['take_off_date']) ? $_POST['take_off_date'] : '';
            $contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $active_status = isset($_POST['active_status']) ? $_POST['active_status'] : '';
            $output = AdminTransition::UpdateBookingDetails($id, $code, $area, $scrap_price, $take_off_date, $contact_no, $address, $active_status);
            break;
        }
        case 'MassUpdate':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $area = isset($_POST['area']) ? $_POST['area'] : '';
            $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : '';
            $take_off_date = isset($_POST['take_off_date']) ? $_POST['take_off_date'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $output = AdminTransition::MassUpdate($city, $area, $booking_date, $take_off_date, $status);
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
class AdminTransition {
    public static function GetBookingList($city, $area, $status, $booking_date, $take_off_date) {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'city' => $city
        ];
        $filter = '';
        if($area!=''){
            $filter.=" AND A.area = ".$area;
        }
        if($status!=''){
            $filter.=" AND A.status = ".$status;
        }
        if($booking_date!=''){
            $booking_date = date("Y-m-d", strtotime($booking_date));
            $filter.=" AND A.booking_date = '$booking_date'";
        }
        if($take_off_date!=''){
            $take_off_date = date("Y-m-d", strtotime($take_off_date));
            $filter.=" AND A.take_off_date = '$take_off_date'";
        }
        
        $selectQuery = "SELECT A.id, A.code, A.name, A.area AS area, B.area_name, 
                        A.contact_no, A.scrap_price, A.detailed_address, '' AS signature, A.status,
                        DATE_FORMAT(A.booking_date,'%d-%M-%Y') AS booking_on,
                        DATE_FORMAT(A.take_off_date,'%d-%M-%Y') AS take_off_on
                        FROM user_booking_take_off A
                        LEFT JOIN admin_area_master B ON A.area = B.id AND B.status = 1
                        WHERE A.city = :city".$filter." ORDER BY A.created_on DESC";

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
    public static function UpdateBookingDetails($id, $code, $area, $scrap_price, $take_off_date, $contact_no, $address, $active_status) {
        $output = array('status' => '', 'message' => '');
        if(!$take_off_date){
            throw new Exception('Take Off On is required');
        }
        if(!$area){
            throw new Exception('Area is required');
        }
        if(!$contact_no){
            throw new Exception('Contact number is required');
        }
        if(!$address){
            throw new Exception('Address is required');
        }
        if($scrap_price){
            if (filter_var($scrap_price, FILTER_VALIDATE_INT) === false) {
                throw new Exception('Invalid price amount');
            }
        } else {
            $scrap_price = NULL;
        }
        
        if (filter_var($contact_no, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid format for contact number');
        } 
        $take_off_date = date("Y-m-d", strtotime($take_off_date));

        $data = [
            'scrap_price' => $scrap_price,
            'area' => $area,
            'contact_no' => $contact_no,
            'take_off_date' => $take_off_date,
            'address' => $address,
            'status' => $active_status,
            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by' => $_SESSION['id'],
            'id' => $id
        ];
        $updateQuery = "UPDATE user_booking_take_off 
                        SET scrap_price = :scrap_price, area = :area,
                        contact_no = :contact_no, take_off_date = :take_off_date,
                        detailed_address = :address, status = :status, 
                        updated_on = :updated_on,  updated_by = :updated_by 
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
       return $output;
    }
    public static function MassUpdate($city, $area, $booking_date, $take_off_date, $status) {
        $output = array('status' => '', 'message' => '');
        if(!$city){
            throw new Exception('city is required');
        }
        if(!$area){
            throw new Exception('Area is required');
        } 
        if(!$booking_date){
            throw new Exception('Booking date is required');
        }
        if(!$status){
            throw new Exception('Status is required');
        } 
        $booking_date = date("Y-m-d", strtotime($booking_date));
        $take_off_date = date("Y-m-d", strtotime($take_off_date));

        $data = [
            'take_off_date' => $take_off_date,
            'updated_on' => date("Y-m-d H:i:s"),
            'updated_by' => $_SESSION['id'],
            'status' => $status,
            'city' => $city,
            'area' => $area,
            'booking_date' => $booking_date,
        ];
        $updateQuery = "UPDATE user_booking_take_off 
                        SET take_off_date = :take_off_date,
                        updated_on = :updated_on, updated_by = :updated_by 
                        WHERE status = :status AND city = :city
                        AND area = :area AND booking_date = :booking_date";
        $result = DBCore::executeQuery($updateQuery,$data);
        $res = DBCore::rowAffected($result);
    
        if($res > 0){
            $output['status'] = 'Success';
            $output['message'] = 'Data updated successfully';
        } else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! something Went wrong. Please try again';
        }
       return $output;
    }
//2nd Tab----------------------------
}
?>
