function openNotifications(){
  document.getElementById('notifications').style.display="block";
  document.getElementById('notificationsBackground').style.display="block";
}

function closeNotifications(){
  document.getElementById('notifications').style.display="none";
  document.getElementById('notificationsBackground').style.display="none";
}

function openLogin(){
  document.getElementById('login').style.display="block";
  document.getElementById('loginbackground').style.display="block";
}

function closeLogin(){
  document.getElementById('login').style.display="none";
  document.getElementById('loginbackground').style.display="none";
}

function afterLoad(){
  document.getElementById("defaultOpen").click();
}

function openOptions(){
  document.getElementById('options').style.display = "block";
  document.getElementById('optionsBackground').style.display = "block";
}

function closeOptions(){
  document.getElementById('options').style.display = "none";
  document.getElementById('optionsBackground').style.display = "none";
}

function PreviewImage() {
  var reader = new FileReader();
  reader.readAsDataURL(document.getElementById("profimgfile").files[0]);

  reader.onload = function (e) {
      document.getElementById("previewImage").src = e.target.result;
  };
}

function addMember(){
  var allMembers = document.getElementById('allMembers');
  var projectMembers = document.getElementById('projectMembers');
  var selectedItem = allMembers.selectedIndex;

  if(selectedItem == -1){
    window.alert("Select a member to add");
  } else{
    var newMember = allMembers[selectedItem].cloneNode(true);

    projectMembers.appendChild(newMember);
    allMembers.removeChild(allMembers[selectedItem]);
  }
}

function removeMember(){
  var projectMembers = document.getElementById('projectMembers');
  var allMembers = document.getElementById('allMembers');
  var selectedItem = projectMembers.selectedIndex;

  if(selectedItem == -1){
    window.alert("Select a member to remove");
  } else{
    var selMember = projectMembers[selectedItem].cloneNode(true);

    allMembers.appendChild(selMember);
    projectMembers.removeChild(projectMembers[selectedItem]);
  }
}

function submitMembers(){
  var projectMembers = document.getElementById('projectMembers');

  for(var i = 0; i < projectMembers.options.length; i++){
    projectMembers.options[i].selected = true;
  }
}

function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabContent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tabButton");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

window.onload = afterLoad;
