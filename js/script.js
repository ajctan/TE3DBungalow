function openNotifications(){
  document.getElementById('notifications').style.display="block";
  document.getElementById('notificationsBackground').style.display="block";
}

function closeNotifications(){
  document.getElementById('notifications').style.display="none";
  document.getElementById('notificationsBackground').style.display="none";
}

document.body.addEventListener("click", function() {
    var element = !document.getElementById("notifications");
    if (element) {
        element.style.display = "none";
    }
});
