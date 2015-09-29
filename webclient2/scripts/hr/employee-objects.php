<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'employee_tab';

// Table's primary key
$primaryKey = 'emp_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier - in this case object
// parameter names
$columns = array(
    array(
        'db' => 'emp_id',
        'dt' => 'DT_RowId',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_' . $d;
        }
    ),
    array('db' => 'company_id', 'dt' => 0),
    array('db' => 'emp_id', 'dt' => 1),
    array('db' => 'etf', 'dt' => 2),
    array('db' => 'epf', 'dt' => 3),
    array('db' => 'title', 'dt' => 4),
    array('db' => 'full_name', 'dt' => 5),
    array('db' => 'used_name', 'dt' => 6),
    array('db' => 'gender', 'dt' => 7),
    array('db' => 'birth_date', 'dt' => 8),
    array('db' => 'civil_status', 'dt' => 9),
    array('db' => 'nic_passport_no', 'dt' => 10),
    array('db' => 'address', 'dt' => 11),
    array('db' => 'telephone', 'dt' => 12),
    array('db' => 'mobile', 'dt' => 13),
    array('db' => 'email', 'dt' => 14),
    array('db' => 'service_type', 'dt' => 15),
    array('db' => 'appointment_date', 'dt' => 16),
    array('db' => 'confirmation_date', 'dt' => 17),
    array('db' => 'resignation_date', 'dt' => 18),
    array('db' => 'status', 'dt' => 19),
    array('db' => 'image', 'dt' => 20)
);
// gets the $sql_details array in pdo_db.php
require( '../pdo_db.php' );    


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( '../ssp.class.php' );

echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);

