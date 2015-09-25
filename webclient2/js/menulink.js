 var host = "../..";
    $(document).ready(function(){
        $("#sidebar-menu-id li").click(function(){
            $("#main-content").load(host.concat($(this).attr("id")));
           // $.getScript("../dist/js/tableutil.js");
        });
        $("#treeview-menu-id li").click(function(){
           // alert(host.concat($(this).attr("id")));
            $("#main-content").load(host.concat($(this).attr("id")));
           // $.getScript("../dist/js/tableutil.js");
        });
    });