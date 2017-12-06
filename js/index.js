function showCreateButtons(){
  document.getElementById('createSBContainer').classList.toggle("createSBContainer");
  document.getElementById('createProject').classList.toggle("createButtonContainer-active");
  document.getElementById('createUser').classList.toggle("createButtonContainer-active");
  document.getElementById('createButtonbackground').classList.toggle("createButtonbackground-visible");
}

function openCreateUserModal(){
  document.getElementById('createUserModal').style.display = "block";
  document.getElementById('createUserbackground').style.display = "block";
}

function closeCreateUserModal(){
  document.getElementById('createUserModal').style.display = "none";
  document.getElementById('createUserbackground').style.display = "none";
}
