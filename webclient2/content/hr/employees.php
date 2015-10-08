<!-- Content Header (Page header) -->
<script type="text/javascript">
    var opType;
    var selRow;
    $(document).ready(function () {
        controlButtons("display");

        var selected = [];
        var table = $("#employeelist").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../scripts/hr/employee-objects.php",
            "rowCallback": function (row, data) {
                if ($.inArray(data.DT_RowId, selected) !== -1) {
                    $(row).addClass('selected');
                }
            }
        });

        $('#employeelist tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $('#edit').addClass('disabled');
                $('#delete').addClass('disabled');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#edit').removeClass('disabled');
                $('#delete').removeClass('disabled');
            }
        });

        //button Operations
        $('#new').click(function () {
            opType = "new";
            resetFormData();
            controlButtons("data");
        });
        $('#edit').click(function () {
            opType = "edit";
            selRow = table.row('.selected').data();
            loadDataToForm(selRow);
            controlButtons("data");
        });
        $('#save').click(function () {
            saveData();
            controlButtons("display");
            table.ajax.reload();
        });
        $('#delete').click(function () {
            opType = "delete";
            selRow = table.row('.selected').data();
            deleteData(selRow);
            table.row('.selected').remove().draw(false);
            table.ajax.reload();
        });
        $('#cancel').click(function () {
            resetFormData();
            controlButtons("display");
            table.ajax.reload();
        });
    });

    //sends the ajax call and save data in the database
    function saveData() {
        // 1. Create XHR instance - Start
        var xhr;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        else {
            throw new Error("Ajax is not supported by this browser");
        }
        // 1. Create XHR instance - End

        // 2. Define what to do when XHR feed you the response from the server - Start
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status == 200 && xhr.status < 300) {
                    document.getElementById('serverreply').innerHTML = xhr.responseText;
                }
            }
        }
        // 2. Define what to do when XHR feed you the response from the server - Start
        //Get form data
        var EMP_ID = document.getElementById("emp_id").value;
        var COMPANY_ID = $("#company_id option:selected").value;
        var ETF = document.getElementById("etf").value;
        var EPF = document.getElementById("epf").value;
        var TITLE = document.getElementById("title").value;
        var FULL_NAME = document.getElementById("full_name").value;
        var USED_NAME = document.getElementById("used_name").value;
        var GENDER = $("#gender option:selected").value;
        var BIRTH_DATE = document.getElementById("date_of_birth").value;
        var CIVIL_STATUS = $("#material_status option:selected").value;
        var NIC_PASSPORT_NO = document.getElementById("nic").value;
        var ADDRESS = document.getElementById("address").value;
        var TELEPHONE = document.getElementById("telephone").value;
        var MOBILE = document.getElementById("mobile").value;
        var EMAIL = document.getElementById("email").value;
        var SERVICE_TYPE = $("#service_type option:selected").value;
        var APPOINTMENT_DATE = document.getElementById("appoinment_date").value;
        var CONFIRMATION_DATE = document.getElementById("confirmed_date").value;
        var RESIGNATION_DATE = document.getElementById("resignation_date").value;
        var STATUS = $("#status option:selected").value;

        var params = "EMP_ID=" + EMP_ID + "&COMPANY_ID=" + COMPANY_ID + "&ETF=" + ETF + "&EPF=" + EPF +
                "&TITLE=" + TITLE + "&FULL_NAME=" + FULL_NAME + "&USED_NAME=" + USED_NAME + "&GENDER=" + GENDER +
                "&BIRTH_DATE=" + BIRTH_DATE + "&CIVIL_STATUS=" + CIVIL_STATUS + "&NIC_PASSPORT_NO=" + NIC_PASSPORT_NO +
                "&ADDRESS=" + ADDRESS + "&TELEPHONE=" + TELEPHONE + "&MOBILE=" + MOBILE +
                "&EMAIL=" + EMAIL + "&SERVICE_TYPE=" + SERVICE_TYPE + "&APPOINTMENT_DATE =" + APPOINTMENT_DATE +
                "&CONFIRMATION_DATE=" + CONFIRMATION_DATE + "&RESIGNATION_DATE=" + RESIGNATION_DATE + "&STATUS =" + STATUS;
        //Add operation type 

        params = params + "&opType=" + opType;


        // 3. Specify your action, location and Send to the server - Start 
        xhr.open('POST', '../scripts/entrep/comp_back_end.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(params);
        // 3. Specify your action, location and Send to the server - End
    }

    //deletes the row from table
    function deleteData(dataObject) {
        var rowId = dataObject["DT_RowId"].replace("row_", "");
        // 1. Create XHR instance - Start
        var xhr;
        if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        else {
            throw new Error("Ajax is not supported by this browser");
        }
        // 1. Create XHR instance - End

        // 2. Define what to do when XHR feed you the response from the server - Start
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status == 200 && xhr.status < 300) {
                    document.getElementById('status').innerHTML = xhr.responseText;
                }
            }
        }
        var params = "EMP_ID=" + rowId + "&opType=" + opType;
        xhr.open('POST', '../scripts/entrep/comp_back_end.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //loads DataTable row data to form
    function loadDataToForm(dataObject) {
        if (jQuery.isEmptyObject(dataObject["DT_RowId"])) {
            $("#emp_id").val("");
        }
        else {
            $("#emp_id").val(dataObject["DT_RowId"].replace("row_", ""));  // get row id
        }
        $("#company_id option").filter(function () {
            return $(this).text() === dataObject[0];
        }).prop('selected', true);

        $("#etf").val(dataObject[2]);
        $("#epf").val(dataObject[3]);
        $("#title option").filter(function () {
            return $(this).text() === dataObject[4];
        }).prop('selected', true);

        $("#full_name").val(dataObject[5]);
        $("#used_name").val(dataObject[6]);
        $("#gender option").filter(function () {
            return $(this).text() === dataObject[7];
        }).prop('selected', true);
        $("#date_of_birth").val(dataObject[8]);
        $("#material_status option").filter(function () {
            return $(this).text() === dataObject[9];
        }).prop('selected', true);
        $("#nic").val(dataObject[10]);
        $("#address").val(dataObject[11]);
        $("#telephone").val(dataObject[12]);
        $("#mobile").val(dataObject[13]);
        $("#email").val(dataObject[14]);
        $("#service_type").val(dataObject[15]);
        $("#appoinment_date").val(dataObject[16]);
        $("#confirmed_date").val(dataObject[17]);
        $("#resignation_date").val(dataObject[18]);
        $("#status").val(dataObject[19]);

    }

    //Enables and disables the control buttons
    //      display - Mode that displays the DataTable and hides the data antry form
    //      data - Mode that displays the data entry form and hidea the DataTable
    //      select - mode that when user selects a row
    function controlButtons(buttonMode) {
        switch (buttonMode) {
            case "display":
                $('#new').removeClass('disabled');
                $('#edit').addClass('disabled');
                $('#save').addClass('disabled');
                $('#delete').addClass('disabled');
                $('#cancel').addClass('disabled');
                $('#table-holder').show("slow");
                $('#form-holder').hide("slow");
                break;
            case "data":
                $('#edit').addClass('disabled');
                $('#save').removeClass('disabled');
                $('#delete').addClass('disabled');
                $('#cancel').removeClass('disabled');
                $('#table-holder').hide("slow");
                $('#form-holder').show("slow");
                break;
        }

    }

    //reset form data
    function resetFormData() {
        var resetObject = {};
        loadDataToForm(resetObject);
    }


</script>
<section class="content-header">
    <h1>
        Employees
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Employees</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">List of Employees</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="btn-group">
                        <a id="new" class="btn btn-app btn-primary">
                            <i class="fa fa-plus-square-o"></i> New
                        </a>
                        <a id="edit" class="btn btn-app">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a  id="save" class="btn btn-app" >
                            <i class="fa fa-save" ></i> Save
                        </a>
                        <a  id="delete" class="btn btn-app">
                            <i class="fa fa-trash-o"></i> Delete
                        </a>
                        <a  id="cancel" class="btn btn-app">
                            <i class="fa fa-times"></i> Cancel
                        </a>
                    </div>
                    <div id="table-holder">
                        <table id="employeelist" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="form-holder">
                        <form role="form">
                            <!-- MAILBOX BEGIN -->
                            <div class="mailbox row">
                                <div class="col-xs-12">
                                    <div class="box box-solid">
                                        <div class="box-body">
                                            <div class="box-header">
                                                <i class="fa fa-inbox"></i>
                                                <h3 class="box-title">Employee Details</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group" >
                                                        <label for="emp_id" >Emp ID </label>
                                                        <input type="text" class="form-control input-sm" id="emp_id" placeholder="Employee ID" >
                                                    </div>
                                                </div>
                                                <div class="col-md-2"><div class="form-group" >
                                                        <label for="status" style="width:25%">Status</label>
                                                        <select id="status" class="form-control input-sm" >                                               
                                                        </select>
                                                    </div></div>
                                                <div class="col-md-4">
                                                    <div class="form-group" >
                                                        <label for="company_id" >Company</label>
                                                        <select id="company_id" class="form-control input-sm" required >                                               
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <!-- BOXES are complex enough to move the .box-header around.
                                                         This is an example of having the box header within the box body -->

                                                    <!-- Navigation - folders-->
                                                    <div style="margin-top: 20px;">
                                                        <ul class="nav nav-pills nav-stacked">
                                                            <li class="active"><a href="nav_summary_div" data-toggle="tab"><i class="fa fa-inbox"></i> Summary</a></li>
                                                            <li><a href="#nav_personal_div" data-toggle="tab"><i class="fa fa-pencil-square-o"></i> Personal</a></li>
                                                            <li><a href="#nav_employment_div" data-toggle="tab"><i class="fa fa-mail-forward"></i> Employment</a></li>
                                                            <li><a href="#nav_attendance_div" data-toggle="tab"><i class="fa fa-star"></i> Attendance</a></li>
                                                            <li><a href="#nav_compensation_div" data-toggle="tab"><i class="fa fa-folder"></i> Compensation</a></li>
                                                            <li><a href="#nav_qualifications_div" data-toggle="tab"><i class="fa fa-folder"></i> Qualifications</a></li>
                                                            <li><a href="#nav_evaluation_div" data-toggle="tab"><i class="fa fa-folder"></i> Evaluation</a></li>
                                                            <li><a href="#nav_discipline_div" data-toggle="tab"><i class="fa fa-folder"></i> Discipline</a></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- /.col (LEFT) -->
                                                <div class="col-md-9">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="nav_summary_div">
                                                            <div class="box-body">

                                                                <div class="col-md-6">
                                                                    <div class="box-header">
                                                                        <i class="fa fa-text-width"></i>
                                                                        <h3 class="box-title">Mr. XYZ</h3>
                                                                    </div><!-- /.box-header -->
                                                                    <div class="box-body">
                                                                        <dl class="dl-horizontal">

                                                                            <dt>Full Name :</dt>
                                                                            <dd>Mr. Test Test</dd>
                                                                            <dt>Date Of Birth</dt>
                                                                            <dd>1970 - 10 - 10</dd>
                                                                            <dt>Mobile</dt>
                                                                            <dd>0772356521</dd>
                                                                            <dt>Division/Branch</dt>
                                                                            <dd>Chillaw</dd>
                                                                            <dt>Designation</dt>
                                                                            <dd>Manager</dd>
                                                                            <dt>Status</dt>
                                                                            <dd>Confirmed</dd>
                                                                        </dl>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div><!-- /.table-responsive -->
                                                        <div class="tab-pane" id="nav_personal_div"> 
                                                            <div class="box-body" style="margin-top: 25px;">
                                                                <div class="col-md-5">
                                                                <div class="form-group" >
                                                                    <label for="title" >Title</label>
                                                                    <select id="title" class="form-control input-sm" required>
                                                                        <option value="Mr">Mr</option>
                                                                        <option value="Ms">Ms</option>
                                                                        <option value="Dr">Dr</option>
                                                                        <option value="Rev">Rev</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="full_name" >Full Name </label>
                                                                    <input type="text" class="form-control input-sm" id="full_name" required placeholder="Full Name" >
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="used_name" >Used Name </label>
                                                                    <input type="text" class="form-control input-sm" id="full_name" required placeholder="Used Name" >
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="date_of_birth" >Date Of Birth </label>
                                                                    <input type="date" class="form-control input-sm" required id="date_of_birth">
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="gender" >Gender</label>
                                                                    <select id="gender" class="form-control input-sm" required>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="material_status" >Material Status</label>
                                                                    <select id="material_status" class="form-control input-sm">
                                                                        <option value="Married">Married</option>
                                                                        <option value="Unmarried">Unmarried</option>
                                                                    </select>
                                                                </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                <div class="form-group" >
                                                                    <label for="nic" >NIC / Passport </label>
                                                                    <input type="text" class="form-control input-sm" id="nic" required placeholder="NIC or PASSPORT Number" >
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="address" >Address </label>
                                                                    <input type="text" class="form-control input-sm" id="address" >
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="telephone" >Telephone </label>
                                                                    <input type="text" class="form-control input-sm" id="telephone" >
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="mobile" >Mobile </label>
                                                                    <input type="text" class="form-control input-sm" id="mobile" >
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="email" >E-mail </label>
                                                                    <input type="text" class="form-control input-sm" id="email" >
                                                                </div>
                                                            </div>
                                                            </div>                                                            
                                                        </div>
                                                        <div class="tab-pane" id="nav_employment_div">
                                                            <div class="box-body" style="margin-top: 25px;">
                                                                <div class="form-group" >
                                                                    <label for="etf" >ETF no </label>
                                                                    <input type="text" class="form-control input-sm" id="etf">
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="epf" >EPF no </label>
                                                                    <input type="text" class="form-control input-sm" id="epf">
                                                                </div>
                                                                 <div class="form-group" >
                                                                     <label for="service_type" >Service Type </label>
                                                                <select id="service_type" class="form-control input-sm" required>
                                                                    <option value="Probation">Probation</option>
                                                                    <option value="Permanent">Permanent</option>
                                                                    <option value="Temporary">Temporary</option>
                                                                    <option value="Contract">Contract</option>
                                                                </select>
                                                                     </div>
                                                                <div class="form-group" >
                                                                    <label for="appoinment_date"  required>Appointment Date </label>
                                                                    <input type="date" class="form-control input-sm" id="appoinment_date">
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="confirmed_date" >Confirmed Date </label>
                                                                    <input type="date" class="form-control input-sm" id="confirmed_date">
                                                                </div>
                                                                <div class="form-group" >
                                                                    <label for="resignation_date" >Resignation Date </label>
                                                                    <input type="date" class="form-control input-sm" id="resignation_date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="nav_attendance_div"> attendance</div>
                                                        <div class="tab-pane" id="nav_compensation_div"> compensation</div>
                                                        <div class="tab-pane" id="nav_qualifications_div"> qualifications</div>
                                                        <div class="tab-pane" id="nav_evaluation_div"> evaluation</div>
                                                        <div class="tab-pane" id="nav_discipline_div"> discipline</div>
                                                    </div><!-- /.col (RIGHT) -->
                                                </div>
                                            </div><!-- /.row -->
                                        </div><!-- /.box-body -->

                                    </div><!-- /.box -->
                                </div><!-- /.col (MAIN) -->
                            </div>
                            <!------------------------------------------------->

                        </form>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->