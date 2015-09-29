<?php

require_once('../pdo_db.php');
$db = new core_db;

$requestType = filter_input(INPUT_POST, 'opType');
if ($requestType == 'new') {
    try {
 
        $stmt = $db ->prepare("SELECT employee_pkg('NEW', :value_) as results FROM dual");
          $value ="";
        $value = filter_input(INPUT_POST, 'EMP_ID').'||'.filter_input(INPUT_POST, 'COMPANY_ID').'||'.filter_input(INPUT_POST, 'ETF').'||'.filter_input(INPUT_POST, 'EPF').
                '||'.filter_input(INPUT_POST, 'TITLE').'||'.filter_input(INPUT_POST, 'FULL_NAME').'||'.filter_input(INPUT_POST, 'USED_NAME').'||'.filter_input(INPUT_POST, 'GENDER').
                 '||'.filter_input(INPUT_POST, 'BIRTH_DATE').'||'.filter_input(INPUT_POST, 'CIVIL_STATUS').'||'.filter_input(INPUT_POST, 'NIC_PASSPORT_NO').
                '||'.filter_input(INPUT_POST, 'ADDRESS').'||'.filter_input(INPUT_POST, 'TELEPHONE').'||'.filter_input(INPUT_POST, 'MOBILE').
                '||'.filter_input(INPUT_POST, 'EMAIL').'||'.filter_input(INPUT_POST, 'SERVICE_TYPE').'||'.filter_input(INPUT_POST, 'APPOINTMENT_DATE').
                 '||'.filter_input(INPUT_POST, 'CONFIRMATION_DATE').'||'.filter_input(INPUT_POST, 'RESIGNATION_DATE').'||'.filter_input(INPUT_POST, 'STATUS');
echo $value;
        $stmt->execute(array(':value_' => $value));

         $data = $stmt->fetchAll();
        foreach ($data as $row) {
            $results = $row['results'];
        }
        echo $results; 
    } catch (PDOException $ex) {
        echo "Error";
        echo $ex->getMessage();
    }
}
     
if ($requestType == 'edit') {
    try {
         $stmt = $db ->prepare("SELECT employee_pkg('MODIFY', :value_) as results FROM dual");
        $value ="";

       $value = filter_input(INPUT_POST, 'EMP_ID').'||'.filter_input(INPUT_POST, 'COMPANY_ID').'||'.filter_input(INPUT_POST, 'ETF').'||'.filter_input(INPUT_POST, 'EPF').
                '||'.filter_input(INPUT_POST, 'TITLE').'||'.filter_input(INPUT_POST, 'FULL_NAME').'||'.filter_input(INPUT_POST, 'USED_NAME').'||'.filter_input(INPUT_POST, 'GENDER').
                 '||'.filter_input(INPUT_POST, 'BIRTH_DATE').'||'.filter_input(INPUT_POST, 'CIVIL_STATUS').'||'.filter_input(INPUT_POST, 'NIC_PASSPORT_NO').
                '||'.filter_input(INPUT_POST, 'ADDRESS').'||'.filter_input(INPUT_POST, 'TELEPHONE').'||'.filter_input(INPUT_POST, 'MOBILE').
                '||'.filter_input(INPUT_POST, 'EMAIL').'||'.filter_input(INPUT_POST, 'SERVICE_TYPE').'||'.filter_input(INPUT_POST, 'APPOINTMENT_DATE').
                 '||'.filter_input(INPUT_POST, 'CONFIRMATION_DATE').'||'.filter_input(INPUT_POST, 'RESIGNATION_DATE').'||'.filter_input(INPUT_POST, 'STATUS');
        $stmt->execute(array(':value_' => $value));

         $data = $stmt->fetchAll();
        foreach ($data as $row) {
        $results = $row['results'];
        
        }
        

    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}

if ($requestType == 'delete') {
    try {
        $stmt = $db ->prepare("SELECT employee_pkg('DELETE', :value_) as results FROM dual");
         $value ="";

       $value = filter_input(INPUT_POST, 'EMP_ID');

        $stmt->execute(array(':value_' => $value));

         $data = $stmt->fetchAll();
        foreach ($data as $row) {
        $results = $row['results'];
        }
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
?>