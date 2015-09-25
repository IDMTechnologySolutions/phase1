<?php

require_once('pdo_db.php');
$db = new core_db;

$requestType = filter_input(INPUT_POST, 'opType');
if ($requestType == 'new') {
    try {
 
        $stmt = $db ->prepare("SELECT company_backend('NEW', 0, :com_reg_, :name_ ) as results FROM dual");

        $stmt->execute(array(':com_reg_' => filter_input(INPUT_POST, 'com_reg_no'),
            ':name_' => filter_input(INPUT_POST, 'name')));

         $data = $stmt->fetchAll();
        foreach ($data as $row) {
        $results = $row['results'];
        }
    } catch (PDOException $ex) {
        echo "Error";
        echo $ex->getMessage();
    }
}
if ($requestType == 'edit') {
    try {
        $stmt = $db ->prepare("SELECT company_backend('MODIFY', :company_id_, :com_reg_, :name_ ) FROM dual");
        

       $stmt->execute(array(':company_id_' => filter_input(INPUT_POST, 'company_id'),
           ':com_reg_' => filter_input(INPUT_POST, 'com_reg_no'),
            ':name_' => filter_input(INPUT_POST, 'name')));

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
        $stmt = $db ->prepare("SELECT company_backend('DELETE', :company_id, ' ', ' ' ) FROM dual");
        $stmt->execute(array(':company_id_' => filter_input(INPUT_POST, 'company_id')));

         $data = $stmt->fetchAll();
        foreach ($data as $row) {
        $results = $row['results'];
        }
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
}
?>