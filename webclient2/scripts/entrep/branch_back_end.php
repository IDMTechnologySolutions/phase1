<?php

require_once('../pdo_db.php');
$db = new core_db;

$requestType = filter_input(INPUT_POST, 'opType');
if ($requestType == 'new') {
    try {
 
        $stmt = $db ->prepare("SELECT branch_pkg('NEW', :value_) as results FROM dual");
          $value ="";
        $value = filter_input(INPUT_POST, 'BRANCH_ID').'||'.filter_input(INPUT_POST, 'NAME').'||'.filter_input(INPUT_POST, 'ADDRESS').'||'.filter_input(INPUT_POST, 'CONTACT').'||'.filter_input(INPUT_POST, 'START_DATE').'||'.filter_input(INPUT_POST, 'BANK_ACC_NO').'||'.filter_input(INPUT_POST, 'STATUS');
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
         $stmt = $db ->prepare("SELECT branch_pkg('MODIFY', :value_) as results FROM dual");
        $value ="";

       $value = filter_input(INPUT_POST, 'BRANCH_ID').'||'.filter_input(INPUT_POST, 'NAME').'||'.filter_input(INPUT_POST, 'ADDRESS').'||'.filter_input(INPUT_POST, 'CONTACT').'||'.filter_input(INPUT_POST, 'START_DATE').'||'.filter_input(INPUT_POST, 'BANK_ACC_NO').'||'.filter_input(INPUT_POST, 'STATUS');

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
        $stmt = $db ->prepare("SELECT branch_pkg('DELETE', :value_) as results FROM dual");
         $value ="";

       $value = filter_input(INPUT_POST, 'BRANCH_ID');

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