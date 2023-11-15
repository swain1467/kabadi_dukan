<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
session_start();
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'GetItemPricingList':{
            $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
            $output = UserHome::GetItemPricingList($city_id);
            break;
        }
        case 'GetCity':{
            $output = UserHome::GetCity();
            break;
        }
        case 'GetAreaList':{
            $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
            $output = UserHome::GetAreaList($city_id);
            break;
        }
        case 'BookingTakeOff':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $area = isset($_POST['area']) ? $_POST['area'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : '';
            $detailed_address = isset($_POST['detailed_address']) ? $_POST['detailed_address'] : '';
            $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
            $code = $city.date("dmyHis");
            $output = UserHome::BookingTakeOff($city, $area, $name, $contact_no, $detailed_address, $captcha, $code);
            break;
        }
        case 'GetBookingHistory':{
            $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
            $output = UserHome::GetBookingHistory($booking_id);
            break;
        }
        case 'DeleteBookingHistory':{
            $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
            $output = UserHome::DeleteBookingHistory($booking_id);
            break;
        }
        case 'UpdateBookingHistory':{
            $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
            $scrap_price = isset($_POST['scrap_price']) ? $_POST['scrap_price'] : '';
            $output = UserHome::UpdateBookingHistory($booking_id, $scrap_price);
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
class UserHome {
    public static function GetItemPricingList($city_id) {
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
    public static function BookingTakeOff($city, $area, $name, $contact_no, $detailed_address, $captcha, $code) {
        $output = array('status' => '', 'message' => '');
        if(!$city){
            throw new Exception('City/Town is required');
        }
        if(!$area){
            throw new Exception('Area is required');
        } 
        if(!$name){
            throw new Exception('Name is required');
        }
        if(!$contact_no){
            throw new Exception('Contact number is required');
        }
        if(!$detailed_address){
            throw new Exception('Address is required');
        }
        if (filter_var($contact_no, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid format for contact number');
        } 
        if (strlen($contact_no) !== 10) {
            throw new Exception('Invalid format for contact number');
        }
        if($_SESSION['CAPTCHA_CODE'] !== $captcha){
            throw new Exception('Invalid captcha');
        }
        $data = [
            'code' => $code,
            'city' => $city,
            'area' => $area,
            'name' => $name,
            'contact_no' => $contact_no,
            'detailed_address' => $detailed_address,
            'booking_date' => date("Y-m-d"),
            'updated_on' => date("Y-m-d H:i:s")
        ];
       //Insert user data
       $inserQuery = "INSERT INTO user_booking_take_off(code, city, area, name, contact_no, detailed_address, booking_date, updated_on)
       VALUES (:code, :city, :area, :name, :contact_no, :detailed_address, :booking_date, :updated_on)";
       $result = DBCore::executeQuery($inserQuery,$data);

       if($result['status']){
            $output['status'] = 'Success';
            $output['message'] = 'Thank You! Please Note Your Booking Id: '.$code;
       } else{
           $output['status'] = 'Failure';
           $output['message'] = 'Oops! something Went wrong. Please try again';
       }
       return $output;
    }
    public static function GetBookingHistory($booking_id) {
        $output = array('status' => '', 'aaData[]' => array());
        if(!$booking_id){
            throw new Exception('Booking id is required');
        }
        $data = [
            'booking_id' => $booking_id,
            'status' => 1
        ];
        $selectQuery = "SELECT A.id, A.name, A.city, A.area, B.city_name, C.area_name,
                        A.contact_no, A.detailed_address, A.scrap_price, 
                        DATE_FORMAT(A.booking_date,'%d-%M-%Y') AS booking_on,
                        DATE_FORMAT(A.take_off_date,'%d-%M-%Y') AS take_off_on
                        FROM user_booking_take_off A
                        LEFT JOIN admin_city_master B ON A.city = B.id
                        LEFT JOIN admin_area_master C ON A.area = C.id
                        WHERE A.code = :booking_id AND A.status = :status 
                        ORDER BY A.name";
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
    public static function DeleteBookingHistory($booking_id) {
        $output = array('status' => '', 'message' => '');
        
        $data = [
            'status' => 0,
            'updated_on' => date("Y-m-d H:i:s"),
            'booking_id' => $booking_id
        ];
        $updateQuery = "UPDATE user_booking_take_off 
                        SET status = :status, updated_on = :updated_on
                        WHERE code = :booking_id";
        $result = DBCore::executeQuery($updateQuery,$data);
        $res = DBCore::rowAffected($result);
    
        if($res == 1){
            $output['status'] = 'Success';
            $output['message'] = 'Data deleted successfully';
        } else{
            $output['status'] = 'Failure';
            $output['message'] = 'Oops! something Went wrong. Please try again';
        }
       return $output;
    }
    public static function UpdateBookingHistory($booking_id, $scrap_price) {
        $output = array('status' => '', 'message' => '');
        if(!$scrap_price){
            throw new Exception('Scrap Value is required');
        }
        if (filter_var($scrap_price, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid Scrap Value');
        }
        $data = [
            'scrap_price' => $scrap_price,
            'updated_on' => date("Y-m-d H:i:s"),
            'booking_id' => $booking_id
        ];
        $updateQuery = "UPDATE user_booking_take_off 
                        SET scrap_price = :scrap_price, 
                        updated_on = :updated_on
                        WHERE code = :booking_id";
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
}
?>