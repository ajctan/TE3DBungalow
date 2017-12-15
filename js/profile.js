function openEditUserModal(email, password, fname, lname, gender, occupation, affiliation){
  document.getElementById('editUserModal').style.display="block";
  document.getElementById('editUserBackground').style.display="block";

  document.getElementById('nuseremail').value = email;
  document.getElementById('nuseremail').readOnly = true;
  document.getElementById('pwd').value = password;
  document.getElementById('cpwd').value = password;
  document.getElementById('nuserfname').value = fname;
  document.getElementById('nuserlname').value = lname;

  if(gender == "Male"){
    document.getElementById('malerbtn').checked = true;
  }
  else {
    document.getElementById('femalerbtn').checked = true;
  }

  document.getElementById('nuseroccupation').value = occupation;
  document.getElementById('nuseraffiliation').value = affiliation;
}

function closeEditUserModal(){
  document.getElementById('editUserModal').style.display="none";
  document.getElementById('editUserBackground').style.display="none";
}

function changeStatus(){
  document.getElementById('statusTD').innerHTML = "test";
}
