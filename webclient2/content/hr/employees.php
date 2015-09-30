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
        var EMP_ID = document.getElementById("EMP_ID").value;
        var COMPANY_ID = $("#COMPANY_ID option:selected").value;
        var ETF = document.getElementById("mailaddr").value;
        var EPF = document.getElementById("mailaddr").value;
        var TITLE = document.getElementById("TITLE").value;
        var FULL_NAME = document.getElementById("busiaddr").value;
        var USED_NAME = document.getElementById("regno").value;
        var GENDER = $("#GENDER option:selected").value;
        var BIRTH_DATE = document.getElementById("BIRTH_DATE").value;
        var CIVIL_STATUS = $("#CIVIL_STATUS option:selected").value;
        var NIC_PASSPORT_NO = document.getElementById("NIC_PASSPORT_NO").value;
        var ADDRESS = document.getElementById("ADDRESS").value;
        var TELEPHONE = document.getElementById("TELEPHONE").value;
        var MOBILE = document.getElementById("MOBILE").value;
        var EMAIL = document.getElementById("EMAIL").value;
        var SERVICE_TYPE = $("#SERVICE_TYPE option:selected").value;
        var APPOINTMENT_DATE = document.getElementById("APPOINTMENT_DATE").value;
        var CONFIRMATION_DATE = document.getElementById("CONFIRMATION_DATE").value;
        var RESIGNATION_DATE = document.getElementById("RESIGNATION_DATE").value;
        var STATUS = $("#STATUS option:selected").value;

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
            $("#EMP_ID").val("");
        }
        else {
            $("#EMP_ID").val(dataObject["DT_RowId"].replace("row_", ""));  // get row id
        }
        $("#COMPANY_ID option").filter(function () {
            return $(this).text() === dataObject[0];
        }).prop('selected', true);

        $("#ETF").val(dataObject[2]);
        $("#EPF").val(dataObject[3]);
        $("#TITLE option").filter(function () {
            return $(this).text() === dataObject[4];
        }).prop('selected', true);

        $("#FULL_NAME").val(dataObject[5]);
        $("#USED_NAME").val(dataObject[6]);
        $("#GENDER option").filter(function () {
            return $(this).text() === dataObject[7];
        }).prop('selected', true);
        $("#BIRTH_DATE").val(dataObject[8]);
        $("#CIVIL_STATUS option").filter(function () {
            return $(this).text() === dataObject[9];
        }).prop('selected', true);
        $("#NIC_PASSPORT_NO").val(dataObject[10]);
        $("#ADDRESS").val(dataObject[11]);
        $("#TELEPHONE").val(dataObject[12]);
        $("#MOBILE").val(dataObject[13]);
        $("#EMAIL").val(dataObject[14]);
        $("#SERVICE_TYPE").val(dataObject[15]);
        $("#APPOINTMENT_DATE").val(dataObject[16]);
        $("#CONFIRMATION_DATE").val(dataObject[17]);
        $("#RESIGNATION_DATE").val(dataObject[18]);
        $("#STATUS").val(dataObject[19]);

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
                                                <div class="col-md-4">
                                                    <div class="form-group" >
                                                        <label for="employeeid" style="width:50%">Employee ID </label>
                                                        <input type="text" class="form-control" id="employeeid" placeholder="Employee ID" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" >
                                                        <label for="company">Company</label>
                                                        <select id="company" class="form-control">                                               
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4"><div class="form-group" style="width:25%">
                                                        <label for="company">Status</label>
                                                        <select id="company" class="form-control">                                               
                                                        </select>
                                                    </div></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-4">
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
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="nav_summary_div">
                                                        <div class="box-body">
                                                            <div class="col-md-4">

                                                                IMAGE
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="box-header">
                                                                    <i class="fa fa-text-width"></i>
                                                                    <h3 class="box-title">Mr. XYZ</h3>
                                                                </div><!-- /.box-header -->
                                                                <div class="box-body">
                                                                    <dl class="dl-horizontal">
                                                                        <dt>Emp ID:</dt>
                                                                        <dd>02154874</dd>
                                                                        <dt>Company:</dt>
                                                                        <dd>XXXXXX (PVT) ltd</dd>
                                                                        <dt>Full Name :</dt>
                                                                        <dd>Mr. Test Test</dd>
                                                                        <dt>Date Of Birth</dt>
                                                                        <dd>1970 - 10 - 10</dd>
                                                                        <dt>Mobile</dt>
                                                                        <dd>0772356521</dd>
                                                                        <dt>Division/Branch</dt>
                                                                        <dd>Chillaw</dd>
                                                                        <dt>Designation</dt>
                                                                        <dd>Chillaw</dd>
                                                                    </dl>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div><!-- /.table-responsive -->
                                                    <div class="tab-pane" id="nav_personal_div"> 
                                                        <div class="box-body" style="margin-top: 25px;">
                                                            Test
                                                        </div>                                                            
                                                    </div>
                                                    <div class="tab-pane" id="nav_employment_div"> employment</div>
                                                    <div class="tab-pane" id="nav_attendance_div"> attendance</div>
                                                    <div class="tab-pane" id="nav_compensation_div"> compensation</div>
                                                    <div class="tab-pane" id="nav_qualifications_div"> qualifications</div>
                                                    <div class="tab-pane" id="nav_evaluation_div"> evaluation</div>
                                                    <div class="tab-pane" id="nav_discipline_div"> discipline</div>
                                                </div><!-- /.col (RIGHT) -->
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