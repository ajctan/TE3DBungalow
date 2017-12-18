function openAdvSearch(){
  document.getElementById('advSearch-content').style.display = "block";
  document.getElementById('advSearchbackground').style.display = "block";
}

function closeAdvSearch(){
  document.getElementById('advSearch-content').style.display = "none";
  document.getElementById('advSearchbackground').style.display = "none";
}

function performAdvSearch(){
	var search_term = document.getElementById('searchTerm').value;
	var member_term = "";
	var date_term = "";
	var funded_term = "";
	var status_term = "";
	console.log(search_term);

  var member_querybuilder = "SELECT * FROM users WHERE CONCAT(uFName, \" \", uLName) LIKE '%" + document.getElementById('membervalue').value + "%'";
  document.getElementById('memberQuery').value = member_querybuilder;

	var firstWhere = 0;
	if(search_term == ''){
	var stringbuilder = "SELECT * FROM tptable WHERE ";
	}
	else{
	var stringbuilder = "SELECT * FROM tptable WHERE tpTitle LIKE '%" + search_term + "%' OR tpDesc LIKE '%" + search_term + "%'";
	firstWhere = 1;
	}

	if(firstWhere == 1){
		stringbuilder = stringbuilder + " AND ";
	}
	else{
		firstWhere = 1;
	}

	stringbuilder = stringbuilder + "tpSDate = '" + document.getElementById('datevalue').value + "'";

	if(firstWhere == 1){
		stringbuilder = stringbuilder + " AND ";
	}
	else{
		firstWhere = 1;
	}

	stringbuilder = stringbuilder + "pVentureC LIKE '%" + document.getElementById('fundedbyvalue').value + "%'";

	var date_query = "";

	if(firstWhere == 1){
		stringbuilder = stringbuilder + " AND ";
	}
	else{
		firstWhere = 1;
	}

	if(document.getElementById('statusvalue').value == 'Ongoing'){
		date_query = "tpStatus = 1"
	}
	else if(document.getElementById('statusvalue').value == 'Finished'){
		date_query = "tpStatus = 2"
	}
	else if(document.getElementById('statusvalue').value == 'Cancelled'){
		date_query = "tpStatus = 0"
	}
	stringbuilder = stringbuilder + date_query;

  document.getElementById('projectQuery').value = stringbuilder;
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
