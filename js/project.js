function openContactHead(){
  document.getElementById('contactHead').style.display="block";
  document.getElementById('contactHeadBackground').style.display="block";
}

function closeContactHead(){
  document.getElementById('contactHead').style.display="none";
  document.getElementById('contactHeadBackground').style.display="none";
}

function openEditProjectModal(){
  document.getElementById('editProjectModal').style.display="block";
  document.getElementById('editProjectBackground').style.display="block";
  var projectTitle = document.getElementById('pageTitle').innerHTML;
  var projectAbstract = document.getElementById('projectAbstract').innerHTML;
  document.getElementById('nprojectTitle').value = projectTitle;
  document.getElementById('nprojectAbstract').innerHTML = projectAbstract.replace(/<[^>]*>/g, "");
}

function closeEditProjctModal(){
  document.getElementById('editProjectModal').style.display="none";
  document.getElementById('editProjectBackground').style.display="none";
}

function cph(){
  var eml = document.getElementById('email').value;
  var msg = document.getElementById('message').value;
  $.ajax({
    type:"post",
    url:"../php/cphead.php",
    data: {email:eml, message:msg},
    cache:false
  });
  return false;
}
