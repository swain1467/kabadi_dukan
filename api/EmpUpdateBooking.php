<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'GetCity':{
            $output = EmpUpdateBooking::GetCity();
            break;
        }
        case 'GetBookingId':{
            $take_off_date = isset($_POST['take_off_date']) ? $_POST['take_off_date'] : '';
            $take_off_date = date("Y-m-d", strtotime($take_off_date));
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $output = EmpUpdateBooking::GetBookingId($take_off_date, $city);
            break;
        }
        case 'GetItem':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $output = EmpUpdateBooking::GetItem($city);
            break;
        }
        case 'GetItemsList':{
            $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
            $output = EmpUpdateBooking::GetItemsList($booking_id);
            break;
        }
        case 'SaveUserItems':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $item = isset($_POST['item']) ? $_POST['item'] : '';
            $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : '';
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
            $price_given = isset($_POST['price_given']) ? $_POST['price_given'] : '';
            $output = EmpUpdateBooking::SaveUserItems($id, $item, $booking_id, $quantity, $price_given);
            break;
        }
        case 'DeleteItems':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $output = EmpUpdateBooking::DeleteItems($id);
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
class EmpUpdateBooking {
    public static function GetCity() {
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'id' => $_SESSION['id'],
            'status' => 1
        ];
        $selectQuery = "SELECT A.city AS city_id, B.city_name
        FROM admin_pec_map A
        INNER JOIN admin_city_master B ON A.city = B.id
        WHERE A.user = :id AND B.status = :status";

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
    public static function GetBookingId($take_off_date, $city){
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'take_off_date' => $take_off_date,
            'city' => $city,
            'status' => 1
        ];
        $selectQuery = "SELECT code AS booking_id, CONCAT(name,'( ',code,' )') AS booking
        FROM user_booking_take_off
        WHERE take_off_date = :take_off_date AND city = :city AND status = :status";

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
    public static function GetItem($city){
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'city' => $city,
            'status' => 1
        ];
        $selectQuery = "SELECT A.item AS item_id, CONCAT(B.item_name,'( ',A.pricing,')') AS item_detail
        FROM admin_city_to_item_map A
        INNER JOIN admin_item_master B ON A.item = B.id
        WHERE A.city =:city AND A.status = :status";

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
    public static function GetItemsList($booking_id){
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'booking_id' => $booking_id,
            'status' => 1
        ];
        $selectQuery = "SELECT A.id, A.item, B.item_name AS item_detail, A.quantity, A.price_given, 
        CAST(A.created_on AS DATE) AS created
        FROM user_item_details A
        INNER JOIN admin_item_master B ON A.item = B.id AND A.status = B.status
        WHERE A.booking_id =:booking_id AND A.status = :status";

        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        if($result['status']){
            foreach($all_rows as $row){  
                $change_status = 0;
                if(date("Y-m-d") == $row['created']){
                    $change_status = 1;
                }
				$row['change_status'] = $change_status;
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
            }
          } else {
            $output['status'] = 'Failure';
          }
       return $output;
    }
    public static function SaveUserItems($id, $item, $booking_id, $quantity, $price_given) {
        $output = array('status' => '', 'message' => '');
        if(!$booking_id){
            throw new Exception('Booking id is required');
        }
        if(!$item){
            throw new Exception('Item is required');
        }
        if(!$quantity){
            throw new Exception('Quantity person is required');
        }
        if(!$price_given){
            throw new Exception('Price is required');
        } 
        if (filter_var($price_given, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid price');
        }
        if($id == ''){
            $data = [
                'booking_id' => $booking_id,
                'item' => $item,
                'quantity' => $quantity,
                'price_given' => $price_given,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id']
            ];
            $inserQuery = "INSERT INTO user_item_details(booking_id, item, quantity, price_given, created_on, created_by, updated_on, updated_by)
            VALUES (:booking_id, :item, :quantity, :price_given, :created_on, :created_by, :updated_on, :updated_by)";
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
                'booking_id' => $booking_id,
                'item' => $item,
                'quantity' => $quantity,
                'price_given' => $price_given,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'id' => $id
            ];
            $updateQuery = "UPDATE user_item_details 
                            SET booking_id = :booking_id, item = :item, 
                            quantity = :quantity, price_given = :price_given, 
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
    public static function DeleteItems($id) {
        $output = array('status' => '', 'message' => '');
            $data = [
                'status' => 0,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'id' => $id
            ];
            $updateQuery = "UPDATE user_item_details 
                            SET status = :status,
                            updated_on = :updated_on, updated_by = :updated_by
                            WHERE id = :id";
            $result = DBCore::executeQuery($updateQuery,$data);
            $res = DBCore::rowAffected($result);
        
            if($res == 1){
                $output['status'] = 'Success';
                $output['message'] = 'Item deleted successfully';
            } else{
                $output['status'] = 'Failure';
                $output['message'] = 'Oops! something Went wrong. Please try again';
            }
       return $output;
    }
}
?>