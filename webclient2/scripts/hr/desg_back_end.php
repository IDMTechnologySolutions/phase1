<?php

require_once('../pdo_db.php');
$db = new core_db;

$requestType = filter_input(INPUT_POST, 'opType');
if ($requestType == 'new') {
    try {
 
        $stmt = $db ->prepare("SELECT designation_pkg('NEW', :value_) as results FROM dual");
          $value ="";
        $value = filter_input(INPUT_POST, 'DESG_CODE').'||'.filter_input(INPUT_POST, 'DESG_DESC');

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
         $stmt = $db ->prepare("SELECT designation_pkg('MODIFY', :value_) as results FROM dual");
        $value ="";
        $value = filter_input(INPUT_POST, 'DESG_CODE').'||'.filter_input(INPUT_POST, 'DESG_DESC').'||';
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
        $stmt = $db ->prepare("SELECT designation_pkg('DELETE', :value_) as results FROM dual");
         $value ="";

       $value = filter_input(INPUT_POST, 'DESG_CODE');

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