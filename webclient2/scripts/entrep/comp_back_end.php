<?php

require_once('../pdo_db.php');
$db = new core_db;

$requestType = filter_input(INPUT_POST, 'opType');
if ($requestType == 'new') {
    try {
 
        $stmt = $db ->prepare("SELECT company_pkg('NEW', :value_) as results FROM dual");
          $value ="";
        $value = '0||'.filter_input(INPUT_POST, 'COM_REG_NO').'||'.filter_input(INPUT_POST, 'NAME').'||'.filter_input(INPUT_POST, 'COMPANY_TYPE').'||'.filter_input(INPUT_POST, 'MAILING_ADD').'||'.filter_input(INPUT_POST, 'BUSINESS_ADD').'||'.filter_input(INPUT_POST, 'BANK_NAME').'||'.filter_input(INPUT_POST, 'BANK_ACC_NO');
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
         $stmt = $db ->prepare("SELECT company_pkg('MODIFY', :value_) as results FROM dual");
        $value ="";

       $value = filter_input(INPUT_POST, 'COMPANY_ID').'||'.filter_input(INPUT_POST, 'COM_REG_NO').'||'.filter_input(INPUT_POST, 'NAME').'||'.filter_input(INPUT_POST, 'COMPANY_TYPE').'||'.filter_input(INPUT_POST, 'MAILING_ADD').'||'.filter_input(INPUT_POST, 'BUSINESS_ADD').'||'.filter_input(INPUT_POST, 'BANK_NAME').'||'.filter_input(INPUT_POST, 'BANK_ACC_NO');

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
        $stmt = $db ->prepare("SELECT company_pkg('DELETE', :value_) as results FROM dual");
         $value ="";

       $value = filter_input(INPUT_POST, 'COMPANY_ID');

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