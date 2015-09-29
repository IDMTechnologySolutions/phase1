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

        var params = "EMP_ID=" + EMP_ID  + "&COMPANY_ID=" + COMPANY_ID  + "&ETF=" + ETF  + "&EPF=" + EPF +
                "&TITLE=" + TITLE  +"&FULL_NAME=" + FULL_NAME  + "&USED_NAME=" + USED_NAME  + "&GENDER=" + GENDER +
               "&BIRTH_DATE=" + BIRTH_DATE  + "&CIVIL_STATUS=" + CIVIL_STATUS  + "&NIC_PASSPORT_NO=" + NIC_PASSPORT_NO +
               "&ADDRESS=" + ADDRESS  + "&TELEPHONE=" + TELEPHONE  + "&MOBILE=" + MOBILE + 
               "&EMAIL=" + EMAIL  + "&SERVICE_TYPE=" + SERVICE_TYPE  + "&APPOINTMENT_DATE =" + APPOINTMENT_DATE +
               "&CONFIRMATION_DATE=" + CONFIRMATION_DATE  + "&RESIGNATION_DATE=" + RESIGNATION_DATE  + "&STATUS =" + STATUS;
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
        if(jQuery.isEmptyObject( dataObject["DT_RowId"])){
           $("#EMP_ID").val("");
        }
        else{
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
    function resetFormData(){
        var resetObject = {};
        loadDataToForm(resetObject);
    }
    

</script>
<section class="content-header">
    <h1>
        Companies
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Companies</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">List of Companies</h3>
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
                                    <th>Company Name</th>
                                    <th>Company Type</th>
                                    <th>Mailing Address</th>
                                    <th>Business Address</th>
                                    <th>Registration No</th>
                                    <th>Bank Name</th>
                                    <th>Account No</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Company Type</th>
                                    <th>Mailing Address</th>
                                    <th>Business Address</th>
                                    <th>Registration No</th>
                                    <th>Bank Name</th>
                                    <th>Account No</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="form-holder">
                        <form role="form">
                            <div class="box-body">
                                <div class="form-group" style="width:50%">
                                    <input type="text" class="sr-only" id="companyid" >
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="companyname">Company Name</label>
                                    <input type="text" class="form-control" id="companyname" placeholder="Company name">
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="companytype">Company Type</label>
                                    <select id="companytype" class="form-control">
                                        <option>Single Owner</option>
                                        <option>Joint Venture</option>
                                        <option>Partnership</option>
                                        <option>Franchise</option>
                                    </select>
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="mailaddr">Mailing Address</label>
                                    <input type="text" class="form-control" id="mailaddr" placeholder="Mailing Address">
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="busiaddr">Business Address</label>
                                    <input type="text" class="form-control" id="busiaddr" placeholder="Business Address">
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="regno">Registration No</label>
                                    <input type="text" class="form-control" id="regno" placeholder="Registration No">
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="bankname">Bank Name</label>
                                    <input type="text" class="form-control" id="bankname" placeholder="Bank Name">
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="accno">Account No</label>
                                    <input type="text" class="form-control" id="accno" placeholder="Account No">
                                </div>
                            </div><!-- /.box-body -->
                        </form>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->