function changeStatus(){
  document.getElementById('statusID').style.display = "none";
  document.getElementById('changeBtn').style.display = "none";
  document.getElementById('newStatus').style.display = "inline-block";
  document.getElementById('saveBtn').style.display = "inline-block";
}

function openContactHead(){
  document.getElementById('contactHead').style.display="block";
  document.getElementById('contactHeadBackground').style.display="block";
}

function closeContactHead(){
  document.getElementById('contactHead').style.display="none";
  document.getElementById('contactHeadBackground').style.display="none";
}

function openEditProjectModal(title, pVentureC, abstract){
  document.getElementById('editProjectModal').style.display="block";
  document.getElementById('editProjectBackground').style.display="block";

  document.getElementById('nprojectTitle').value = title;
  document.getElementById('nprojectCapital').value = pVentureC;
  document.getElementById('nprojectAbstract').innerHTML = abstract;
}

function closeEditProjctModal(){
  document.getElementById('editProjectModal').style.display="none";
  document.getElementById('editProjectBackground').style.display="none";
}

function copyAbstractToClipboard(abstract){
  document.getElementById('textToCopy').style.display = "inline-block";
  document.getElementById('textToCopy').innerHTML = abstract;
  textToCopy.select();
  document.execCommand("copy");
  document.getElementById('textToCopy').style.display = "none";
  alert("The abstract has been copied to your clipboard!");
}

function copyCitationToClipboard(){
  document.getElementById('textToCopy').style.display = "inline-block";
  document.getElementById('textToCopy').innerHTML = document.getElementById('projectCitation').innerHTML;
  textToCopy.select();
  document.execCommand("copy");
  document.getElementById('textToCopy').style.display = "none";
  alert("The citation has been copied to your clipboard!");
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
