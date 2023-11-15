<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");
$action = $_REQUEST['action'];

try{
    switch($action){
        case 'GetItem':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $take_date_start = isset($_POST['take_date_start']) ? $_POST['take_date_start'] : '';
            $take_date_end = isset($_POST['take_date_end']) ? $_POST['take_date_end'] : '';
            $output = ManageExportDate::GetItem($city, $take_date_start, $take_date_end);
            break;
        }
        case 'GetItemUserQP':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $item = isset($_POST['item']) ? $_POST['item'] : '';
            $take_date_start = isset($_POST['take_date_start']) ? $_POST['take_date_start'] : '';
            $take_date_end = isset($_POST['take_date_end']) ? $_POST['take_date_end'] : '';
            $output = ManageExportDate::GetItemUserQP($city, $item, $take_date_start, $take_date_end);
            break;
        }
        case 'GetEIList':{
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $output = ManageExportDate::GetEIList($city);
            break;
        }
        case 'SaveExportItems':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $take_off_date_from = isset($_POST['take_off_date_from']) ? $_POST['take_off_date_from'] : '';
            $take_off_date_to = isset($_POST['take_off_date_to']) ? $_POST['take_off_date_to'] : '';
            $item = isset($_POST['item']) ? $_POST['item'] : '';
            $price_given = isset($_POST['price_given']) ? $_POST['price_given'] : '';
            $price_sold = isset($_POST['price_sold']) ? $_POST['price_sold'] : '';
            $quantity_collect = isset($_POST['quantity_collect']) ? $_POST['quantity_collect'] : '';
            $quantity_export = isset($_POST['quantity_export']) ? $_POST['quantity_export'] : '';
            $export_date = isset($_POST['export_date']) ? $_POST['export_date'] : '';
            $output = ManageExportDate::SaveExportItems($id, $city, $take_off_date_from, $take_off_date_to,
                        $item, $price_given, $price_sold, $quantity_collect, $quantity_export, $export_date);
            break;
        }
        case 'DeleteExportItems':{
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            $output = ManageExportDate::DeleteExportItems($id);
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
class ManageExportDate {
    public static function GetItem($city, $from_date, $to_date){
        $output = array('status' => '', 'aaData[]' => array());
        if($city == ''){
            throw new Exception('Select a city');
        }
        if($from_date!=''){
            $from_date = date("Y-m-d", strtotime($from_date));
        }else{
            throw new Exception('Take Off From Date Is Required');
        }

        if($to_date!=''){
            $to_date = date("Y-m-d", strtotime($to_date));
        }else{
            throw new Exception('Take Off To Date Is Required');
        }

        $data = [
            'status' => 1,
            'city' => $city,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];

        $selectQuery = "SELECT B.item, CONCAT(C.item_name,'( ',CAST(SUM(B.quantity) AS DECIMAL(5, 2)),' Kg/Piece)') AS item_detail
        FROM user_booking_take_off A
        INNER JOIN user_item_details B ON A.code = B.booking_id
        LEFT JOIN admin_item_master C ON B.item = C.id
        WHERE A.status = :status AND A.city = :city AND A.take_off_date BETWEEN :from_date AND :to_date
        GROUP BY B.item ORDER BY C.item_name";
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
    public static function GetItemUserQP($city, $item, $from_date, $to_date){
        $output = array('status' => '', 'aaData[]' => array());

        if($from_date!=''){
            $from_date = date("Y-m-d", strtotime($from_date));
        }else{
            throw new Exception('Take Off From Date Is Required');
        }

        if($to_date!=''){
            $to_date = date("Y-m-d", strtotime($to_date));
        }else{
            throw new Exception('Take Off To Date Is Required');
        }

        $data = [
            'status' => 1,
            'city' => $city,
            'item' => $item,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ];

        $selectQuery = "SELECT CAST(SUM(B.quantity) AS DECIMAL(5, 2)) AS quantity, SUM(B.price_given) AS price
        FROM user_booking_take_off A
        INNER JOIN user_item_details B ON A.code = B.booking_id
        LEFT JOIN admin_item_master C ON B.item = C.id
        WHERE A.status = :status AND A.city = :city AND B.item = :item AND A.take_off_date BETWEEN :from_date AND :to_date
        GROUP BY B.item ORDER BY C.item_name";
        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
    
        if($result['status']){
            if(COUNT($all_rows)>0){
                foreach($all_rows as $row){
                    $output['aaData'][] = $row;
                    $output['status'] = 'Success';
                }
            }else {
                $output['status'] = 'Failure';
            }
          } 
       return $output;
    }
    public static function GetEIList($city){
        $output = array('status' => '', 'aaData[]' => array());
        $data = [
            'city' => $city,
            'status' => 1
        ];
        $selectQuery = "SELECT A.id, B.item_name,
        CAST(A.quantity_collect AS DECIMAL(5, 2)) AS quantity_collect, A.price_given, 
        CAST(A.quantity_export AS DECIMAL(5, 2)) AS quantity_export, A.price_sold, 
        DATE_FORMAT(A.export_date,'%d-%M-%Y') AS export_date,
        DATE_FORMAT(A.take_off_date_from,'%d-%M-%Y') AS take_off_date_from,
        DATE_FORMAT(A.take_off_date_to,'%d-%M-%Y') AS take_off_date_to,
        CAST(A.created_on AS DATE) AS created
        FROM user_item_export_details A
        INNER JOIN admin_item_master B ON A.item = B.id AND A.status = B.status
        WHERE A.city = :city AND A.status = :status";

        $result = DBCore::executeQuery($selectQuery,$data);
        $all_rows = DBCore::getAllRows($result);
        $slno = 1; 
        if($result['status']){
            foreach($all_rows as $row){  
                $change_status = 0;
                $row['sl_no'] = $slno;
                if(date("Y-m-d") == $row['created']){
                    $change_status = 1;
                }
				$row['change_status'] = $change_status;
                $output['aaData'][] = $row;
                $output['status'] = 'Success';
                $slno++;
            }
          } else {
            $output['status'] = 'Failure';
          }
       return $output;
    }
    public static function SaveExportItems($id, $city, $take_off_date_from, $take_off_date_to,
    $item, $price_given, $price_sold, $quantity_collect, $quantity_export, $export_date) {
        $output = array('status' => '', 'message' => '');
        if(!$price_given){
            throw new Exception('Price is required');
        }
        if (filter_var($price_given, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid price');
        }

        if(!$price_sold){
            throw new Exception('Price is required');
        }
        if (filter_var($price_sold, FILTER_VALIDATE_INT) === false) {
            throw new Exception('Invalid price');
        }

        if(!$quantity_collect){
            throw new Exception('Quantity collect is required');
        }

        if(!$quantity_export){
            throw new Exception('Quantity export is required');
        }

        if($export_date!=''){
            $export_date = date("Y-m-d", strtotime($export_date));
        }else{
            throw new Exception('Export date is required');
        }

        if($id == ''){
            if(!$city){
                throw new Exception('City is required');
            }
    
            if($take_off_date_from!=''){
                $take_off_date_from = date("Y-m-d", strtotime($take_off_date_from));
            }else{
                throw new Exception('Take Off from date is required');
            }
            
            if($take_off_date_to!=''){
                $take_off_date_to = date("Y-m-d", strtotime($take_off_date_to));
            }else{
                throw new Exception('Take Off to date is required');
            }
    
            if(!$item){
                throw new Exception('Item is required');
            }

            $data = [
                'city' => $city,
                'item' => $item,
                'quantity_collect' => $quantity_collect,
                'price_given' => $price_given,
                'quantity_export' => $quantity_export,
                'price_sold' => $price_sold,
                'export_date' => $export_date,
                'take_off_date_from' => $take_off_date_from,
                'take_off_date_to' => $take_off_date_to,
                'created_on' => date("Y-m-d H:i:s"),
                'created_by' => $_SESSION['id'],
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id']
            ];
            $inserQuery = "INSERT INTO user_item_export_details(city, item, quantity_collect, price_given, quantity_export, 
            price_sold, export_date, take_off_date_from, take_off_date_to, created_on, created_by, updated_on, updated_by)
            VALUES (:city, :item, :quantity_collect, :price_given, :quantity_export, 
            :price_sold, :export_date, :take_off_date_from, :take_off_date_to, :created_on, :created_by, :updated_on, :updated_by)";
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
                'quantity_collect' => $quantity_collect,
                'price_given' => $price_given,
                'quantity_export' => $quantity_export,
                'price_sold' => $price_sold,
                'export_date' => $export_date,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'id' => $id
            ];
            $updateQuery = "UPDATE user_item_export_details 
                            SET quantity_collect = :quantity_collect, price_given = :price_given, 
                            quantity_export = :quantity_export, price_sold = :price_sold,
                            export_date = :export_date, updated_on = :updated_on, updated_by = :updated_by
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
    public static function DeleteExportItems($id) {
        $output = array('status' => '', 'message' => '');
            $data = [
                'status' => 0,
                'updated_on' => date("Y-m-d H:i:s"),
                'updated_by' => $_SESSION['id'],
                'id' => $id
            ];
            $updateQuery = "UPDATE user_item_export_details 
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