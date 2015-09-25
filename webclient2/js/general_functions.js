function ComboCompany(comboID){
   ComboBoxLoad('company_tab','company_id','name','company_id > 0',comboID);
   
}

function ComboDepartments(comboID){
   ComboBoxLoad('department_tab','dept_code','dept_desc','dept_code > 0',comboID);
   
}

function ComboDesignations(comboID){
   ComboBoxLoad('designation_tab','desg_code','desg_desc','desg_code > 0',comboID);
   
}

function ComboBranch(comboID){
   ComboBoxLoad('branch_tab','br_code','branch_name','br_code is not null',comboID);
   
}

function ComboBranchManager(company, comboID){
   ComboBoxLoad('manager_tab','manager_id','concat(title," ",name)','status = "Active"',comboID);
   
}

function ComboBoxLoad(table_, list_valvs_, list_text_, where_clm_ ,comboID){
	
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
		
		document.getElementById(comboID).innerHTML='<option>Loading.....</option>';
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    document.getElementById(comboID).innerHTML=xmlhttp.responseText;
		}
		
	  }
	xmlhttp.open("GET","../scripts/general_combo.php"+"?db_table="+table_+"&list_value_clm="+list_valvs_+"&list_text_clm="+list_text_+"&where_clm="+where_clm_,true);
	xmlhttp.send();
}