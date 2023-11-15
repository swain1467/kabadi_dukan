<?php
require_once("../config.php");
require_once(ASSET . "db_core.php");
require_once(ASSET . "check_request.php");
$action = $_REQUEST['action'];
try{
    switch($action){
        case 'GetCityWiseReport':{
            $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
            $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
            $output = AdminReport::GetCityWiseReport($from_date, $to_date);
            break;
        }
        case 'GetAreaWiseReport':{
            $city = isset($_GET['city']) ? $_GET['city'] : '';
            $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
            $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
            $output = AdminReport::GetAreaWiseReport($city, $from_date, $to_date);
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
class AdminReport {
    public static function GetCityWiseReport($from_date, $to_date) {
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
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
        $selectQuery = "SELECT B.city_name, SUM(A.scrap_price) AS total_collection,
                        COUNT(A.code) as total_orders, B.commission AS commission_percent,
                        FLOOR(SUM(A.scrap_price*B.commission)/100) AS commission,
                        CONCAT(C.name,'( ',C.contact_no,' )') AS contact_person_det
                        FROM user_booking_take_off A
                        LEFT JOIN admin_city_master B ON A.city = B.id AND B.status = 1
                        LEFT JOIN user_master C ON B.contact_person = C.id AND C.status = 1 AND C.user_type !='USER'
                        WHERE A.status = :status AND A.take_off_date BETWEEN :from_date AND :to_date
                        GROUP BY city ORDER BY B.city_name;";

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
    public static function GetAreaWiseReport($city, $from_date, $to_date) {
        $output = array('status' => '', 'aaData[]' => array());
        
        $filter = '';
        if($city!=''){
            $filter.=" AND A.city = ".$city;
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
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
        $selectQuery = "SELECT C.area_name, B.city_name, SUM(A.scrap_price) AS total_collection,
                        COUNT(A.code) as total_orders, B.commission AS commission_percent,
                        ROUND(SUM(A.scrap_price*B.commission)/100, 2) AS commission
                        FROM user_booking_take_off A
                        LEFT JOIN admin_city_master B ON A.city = B.id AND B.status = 1
                        LEFT JOIN admin_area_master C ON A.area = C.id AND C.status = 1
                        WHERE A.status = :status ".$filter." AND A.take_off_date BETWEEN :from_date AND :to_date
                        GROUP BY area ORDER BY B.city_name, C.area_name;";

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
//2nd Tab----------------------------
}
?>
