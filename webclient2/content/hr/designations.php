<!-- Content Header (Page header) -->
<script type="text/javascript">
    var opType;
    var selRow;
    $(document).ready(function () {
        controlButtons("display");

        var selected = [];
        var table = $("#desglist").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../scripts/hr/desg-objects.php",
            "rowCallback": function (row, data) {
                if ($.inArray(data.DT_RowId, selected) !== -1) {
                    $(row).addClass('selected');
                }
            }
        });

        $('#desglist tbody').on('click', 'tr', function () {
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
        var desg_code = document.getElementById("desg_code").value;
        var desg_desc = document.getElementById("desg_desc").value;
        var params = "DESG_CODE=" + desg_code + "&DESG_DESC=" + desg_desc ; 
        //Add operation type 

        params = params + "&opType=" + opType;


        // 3. Specify your action, location and Send to the server - Start 
        xhr.open('POST', '../scripts/hr/desg_back_end.php');
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
        var params = "DESG_CODE=" + rowId + "&opType=" + opType;
        xhr.open('POST', '../scripts/hr/desg_back_end.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }

    //loads DataTable row data to form
    function loadDataToForm(dataObject) {
       
        
        if(jQuery.isEmptyObject( dataObject["DT_RowId"])){
            $("#desg_code").val("");
        }
        else{
         $("#desg_code").val(dataObject["DT_RowId"].replace("row_", ""));  // get row id
        }
        $("#desg_desc").val(dataObject[1]); 
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
        Designations
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Designations</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">List of Designations</h3>
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
                        <table id="desglist" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Designation</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Code</th>
                                    <th>Designation</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="form-holder">
                        <form role="form">
                            <div class="box-body">
                                
                                <div class="form-group" style="width:50%">
                                    <label for="desg_code">Code</label>
                                    <input type="text" class="form-control" id="desg_code" placeholder="Designation Code">
                                </div>
                                <div class="form-group" style="width:50%">
                                    <label for="desg_desc">Designations</label>
                                    <input type="text" class="form-control" id="desg_desc" placeholder="Designation">
                                </div>
                                
                            </div><!-- /.box-body -->
                        </form>
                    </div>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->