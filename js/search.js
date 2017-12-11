function openAdvSearch(){
  document.getElementById('advSearch-content').classList.toggle("open");
}
function toggleCheckBoxMember(){
 if(document.getElementById("member").checked){ // checked
 var getvalue = document.getElementById("member").value; // from current form

 var passvalue = document.getElementById("mem"); //hidden mem in form

 passvalue.value = getvalue; // pass form value to search form

 var passcheck = document.getElementById("memChecked"); //hidden memchecked in form

 passcheck.value = true; // pass form value to search form
 Console.log("testtrue");
              
 }
 else{ // not
  var passvalue = document.getElementById("mem"); //hidden mem in form

  passvalue.value = ""; // pass form value to search form

  var passcheck = document.getElementById("memChecked"); //hidden memchecked in form

  passcheck.value = false; // pass form value to search form

  Console.log("testfalse");
  }
}
function toggleCheckBoxDate(){
            if(document.getElementById("member").checked){ // checked
              var getvalue = document.getElementById("datestart").value; // from current form
              
              var passvalue = document.getElementById("dat"); //hidden mem in form

              passvalue.value = getvalue; // pass form value to search form

              var passcheck = document.getElementById("datChecked"); //hidden memchecked in form

              passcheck.value = true; // pass form value to search form
            }
            else{ // not
              var passvalue = document.getElementById("dat"); //hidden mem in form

              passvalue.value = ""; // pass form value to search form

              var passcheck = document.getElementById("datChecked"); //hidden memchecked in form

              passcheck.value = false; // pass form value to search form
            }
          }
          function toggleCheckBoxFunded(){
            if(document.getElementById("member").checked){ // checked
              var getvalue = document.getElementById("fundedby").value; // from current form
              
              var passvalue = document.getElementById("fun"); //hidden mem in form

              passvalue.value = getvalue; // pass form value to search form

              var passcheck = document.getElementById("funChecked"); //hidden memchecked in form

              passcheck.value = true; // pass form value to search form
            }
            else{ // not
              var passvalue = document.getElementById("fun"); //hidden mem in form

              passvalue.value = ""; // pass form value to search form

              var passcheck = document.getElementById("funChecked"); //hidden memchecked in form

              passcheck.value = false; // pass form value to search form
            }
          }
          function toggleCheckBoxStatus(){
            if(document.getElementById("member").checked){ // checked
              var getvalue = document.getElementById("status").value; // from current form
              
              var passvalue = document.getElementById("sta"); //hidden mem in form

              passvalue.value = getvalue; // pass form value to search form

              var passcheck = document.getElementById("staChecked"); //hidden memchecked in form

              passcheck.value = true; // pass form value to search form
            }
            else{ // not
              var passvalue = document.getElementById("sta"); //hidden mem in form

              passvalue.value = ""; // pass form value to search form

              var passcheck = document.getElementById("staChecked"); //hidden memchecked in form

              passcheck.value = false; // pass form value to search form
            }
          }