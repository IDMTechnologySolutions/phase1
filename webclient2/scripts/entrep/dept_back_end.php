<?php

require_once('../pdo_db.php');
$db = new core_db;

$requestType = filter_input(INPUT_POST, 'opType');
if ($requestType == 'new') {
    try {
 
        $stmt = $db ->prepare("SELECT department_pkg('NEW', :value_) as results FROM dual");
          $value ="";
        $value = filter_input(INPUT_POST, 'DEP_CODE').'||'.filter_input(INPUT_POST, 'DEP_DESC').'||'.filter_input(INPUT_POST, 'DEP_PINCH');

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
         $stmt = $db ->prepare("SELECT department_pkg('MODIFY', :value_) as results FROM dual");
        $value ="";
        $value = filter_input(INPUT_POST, 'DEP_CODE').'||'.filter_input(INPUT_POST, 'DEP_DESC').'||'.filter_input(INPUT_POST, 'DEP_PINCH');
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
        $stmt = $db ->prepare("SELECT department_pkg('DELETE', :value_) as results FROM dual");
         $value ="";

       $value = filter_input(INPUT_POST, 'DEP_CODE');

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