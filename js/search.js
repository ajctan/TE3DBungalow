function openAdvSearch(){
  document.getElementById('advSearch-content').classList.toggle("open");
}

function performAdvSearch(){
	var search_term = document.getElementById('searchTerm').value;
	var member_term = "";
	var date_term = "";
	var funded_term = "";
	var status_term = "";
	console.log(search_term);

	//build query for members
	if(document.getElementById('member').checked){
		
		var member_querybuilder = "SELECT * FROM users WHERE CONCAT(uFName, \" \", uLName) LIKE '%" + document.getElementById('membervalue').value + "%'";
		document.getElementById('memberQuery').value = member_querybuilder;

		alert(document.getElementById('memberQuery').value);
	}
	else{
		var member_querybuilder = "SELECT * FROM users WHERE uFName = \"sdafoiasjdfoasfdasfd\"";
	}

	//build query for projects
	var firstWhere = 0;
	if(search_term == ''){
	var stringbuilder = "SELECT * FROM tptable WHERE ";
	}
	else{
	var stringbuilder = "SELECT * FROM tptable WHERE tpTitle LIKE '%" + search_term + "%' OR tpDesc LIKE '%" + search_term + "%'";
	firstWhere = 1;
	}
	if(document.getElementById('datestart').checked || document.getElementById('fundedby').checked || document.getElementById('status').checked){
		
			if(document.getElementById('datestart').checked){

			if(firstWhere == 1){
				stringbuilder = stringbuilder + " AND ";
			}
			else{
				firstWhere = 1;
			}

			stringbuilder = stringbuilder + "tpSDate = '" + document.getElementById('datevalue').value + "'";
		}
		if(document.getElementById('fundedby').checked){

			if(firstWhere == 1){
				stringbuilder = stringbuilder + " AND ";
			}
			else{
				firstWhere = 1;
			}

			stringbuilder = stringbuilder + "pVentureC = '" + document.getElementById('fundedbyvalue').value + "'";
		}
		if(document.getElementById('status').checked){
			var date_query = "";

			if(firstWhere == 1){
				stringbuilder = stringbuilder + " AND ";
			}
			else{
				firstWhere = 1;
			}

			if(document.getElementById('statusvalue').value == 'Ongoing'){
				date_query = "tpEDate IS NULL"
			}
			else if(document.getElementById('statusvalue').value == 'Finished'){
				date_query = "tpSDate != tpEDate"
			}
			else if(document.getElementById('statusvalue').value == 'Cancelled'){
				date_query = "tpSDate == tpEDate"
			}
			stringbuilder = stringbuilder + date_query;
		}	

		document.getElementById('projectQuery').value = stringbuilder;
		alert(document.getElementById('projectQuery').value);
	}
	
}

function toggleCheckBoxMember(){
	console.log("togglecheckboxmember");
}

function toggleCheckBoxDate(){
	console.log("togglecheckboxdate");
}

function toggleCheckBoxFunded(){
	console.log("togglecheckboxfunded");
}

function toggleCheckBoxStatus(){
	console.log("togglecheckboxstatus");
}