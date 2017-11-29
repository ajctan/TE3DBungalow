<?php
if(isset($_POST['file_name'])){
    $file = $_POST['file_name'];
	$file_extension = explode(".", $file);

	if($file_extension[1] === 'pdf'){
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile('uploads/'.$file);
		exit();
	}
	
	if($file_extension[1] === 'docx'){
		header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile('uploads/'.$file);
		exit();
	}
	
	if($file_extension[1] === 'html'){
		header('Content-type: text/html');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile('uploads/'.$file);
		exit();
	}
	
	if($file_extension[1] === 'css'){
		header('Content-type: text/css');
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile('uploads/'.$file);
		exit();
	}
}
?>

<!DOCTYPE html>
<html>
<title>TedBungalow</title>
<!--Font Awesome Stylesheet for icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/project.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/project.js" type="text/javascript"></script>

<script>
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
</script>
</head>
<body>
  <!-- Start of Toolbar -->
  <div id="toolbar">
    <div id="logo">
      <a href="index.php"><img src="../images/logo_full.png" height="30px"></a>
    </div>

    <div id="searchBar">
      <form action="index.php" method="GET">
        <input id="searchTerm" type="text" placeholder="Search"/>
        <button id="searchButton" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>

    <ul id="toolbarButtons">
      <li><button id="notificationButton" class="toolbarButton" onclick="openNotifications()"><i id="notificationCount">99</i><i class="fa fa-bell"></i></button></li>
      <li><button id="userName" class="toolbarButton" onclick="location.href='profile.html';">Juan dela Cruz</button></li>
  		<li><button class="toolbarButton">Login</button></li>
    </ul>
  </div>

  <!-- End of Toolbar; start of Content -->

  <div id="wrap">
    <div id="pageHead">
      <button id="optionsButton" onclick="openOptions()"><i class="fa fa-cog fa-2x"></i></button>
      <!-- MODALS: (To keep the position relative to parent div) -->
      <div id="options">
        <button>Delete Project</button>
      </div>
      <!-- End of MODALS -->
      <img src="../images/projectlogo.png">
      <p id="projectTitle"><marquee direction="left" onmouseover="this.stop();" onmouseout="this.start();">Sample Active Project (With A Long TItle)</marquee>
      <hr>
      <p class="pageLegend">
        <p id="projectHead">Project Head
      </p>
    </div>
    <div id="tabButtons">
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'abstract')">Abstract</button>
      <button class="tabButton" onclick="openTab(event, 'files')">Files</button>
      <button class="tabButton" onclick="openTab(event, 'contributors')">Contributors</button>
    </div>

    <div id="abstract" class="tabContent">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas id enim luctus felis ornare pellentesque. Integer dictum tincidunt vulputate. Suspendisse sed sapien sit amet tellus vestibulum commodo. Ut quis magna rutrum, consequat orci sed, blandit augue. Proin ultricies velit erat, eget semper arcu bibendum vehicula. Proin in tempus dui, nec dapibus ante. Aliquam posuere augue turpis, mattis cursus felis tempor sed. Proin vitae hendrerit magna. Vivamus pretium eget nibh at consequat. Maecenas vulputate, mi id efficitur vestibulum, enim felis pulvinar magna, quis ultrices elit tortor a lectus. Morbi tincidunt efficitur erat, sit amet consectetur enim luctus et. Sed sed viverra velit. Etiam ornare lacus enim, a vehicula ipsum cursus ut. Nunc sit amet nibh et odio porttitor hendrerit. Phasellus sit amet magna non lectus viverra bibendum pretium sit amet massa.

      <p>Cras mattis, purus posuere venenatis egestas, leo nisl porta orci, sit amet lobortis sem massa eu ipsum. Curabitur dui elit, mattis nec accumsan eget, porta sed metus. Cras in efficitur nulla, a accumsan leo. Nulla posuere lacinia lectus at sollicitudin. In vitae lectus a nulla aliquet tincidunt sit amet pulvinar purus. Suspendisse potenti. Cras bibendum maximus lacus, vel tempor odio. Duis rutrum, libero at lobortis condimentum, ipsum quam elementum turpis, a finibus lectus felis vitae nunc. Maecenas tellus tellus, pharetra sed lacus eu, ultrices sagittis diam. Praesent viverra metus a nisi tincidunt pellentesque. Duis commodo erat elementum, maximus sapien at, porta odio. Nunc vel nulla quis quam porttitor aliquam. Nulla eget faucibus massa, eu tristique odio. Cras dolor sapien, dictum at ligula eu, interdum sollicitudin diam.

      <p>Morbi ornare purus eu est scelerisque, nec convallis nisi aliquet. Sed nec sollicitudin massa. Maecenas sollicitudin at mi sed maximus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla sit amet nisl urna. Morbi nec sodales quam. Vivamus id urna lorem.

      <p>Etiam posuere imperdiet tempor. Praesent aliquet, dui vel facilisis vehicula, tortor leo tempus nisi, id ornare odio elit vel sem. Phasellus sagittis aliquet aliquam. Cras erat tortor, tincidunt et quam eu, scelerisque ultricies tellus. Duis velit ante, tempus quis nulla eu, tristique interdum leo. Pellentesque vel consequat mauris. Fusce augue arcu, laoreet ac fermentum id, rutrum non neque. Morbi et ultricies dolor. Sed at mattis nisl, sed varius velit. In sagittis commodo mauris eu elementum. Proin eu nisl non tortor pellentesque auctor vel a diam. Curabitur quis sapien vel dolor faucibus tempus. Suspendisse gravida ultrices iaculis. Donec at ipsum scelerisque turpis fringilla vestibulum sed vel diam.

      <p>Sed sed vulputate dolor, et dictum nibh. Nam id enim eu orci porttitor mattis non non erat. Praesent varius turpis volutpat lacus volutpat, sit amet eleifend tellus tempor. Aliquam at laoreet nisl. Nunc vulputate nulla risus, in faucibus massa vulputate id. Nunc pellentesque sollicitudin enim. Etiam nec imperdiet purus. Cras est neque, viverra vitae arcu nec, tempor elementum felis.

      <button id="contactProjectHead" onclick="openContactHead()"><i class="fa fa-envelope-o"></i> Contact Project Head</button>
      <!-- MODALS: (To keep the position relative to parent div) -->
      <div id="contactHead">
        <div class="contectHeadHeader">
          <button id="closeContactHead" onclick="closeContactHead()">X</button>
        </div>
        <form>
          <input type="text" id="email" placeholder="Your Email" required/>
          <textarea id="message" rows="17" required></textarea>
          <button id="sendMessage" type="submit" onclick="return cph()"><i class="fa fa-send fa-2x"></i></button>
        </form>
      </div>
    </div>

    <div id="files" class="tabContent">
      <table id="projectFiles">
        <tr>
          <th class="name">Name</th>
          <th class="size">Size</th>
          <th class="extension">Extension</th>
          <th class="lastModified">Last Modified</th>
          <th></th>
        </tr>
        <tr>
          <td>File_1</td>
          <td>123kb</td>
          <td>.docx</td>
          <td>January 1, 1990</td>
          <td>
			<form action="project.php" method="post" name="downloadform">
				<input name="file_name" value="File_1.docx" type="hidden">
				<i class="fa fa-download"></i>
				<input type="submit" value="Download">
			</form>
		  </td>
        </tr>
        <tr>
          <td>File_2</td>
          <td>123kb</td>
          <td>.pdf</td>
          <td>January 1, 1990</td>
          <td>
			<form action="project.php" method="post" name="downloadform">
				<input name="file_name" value="File_2.pdf" type="hidden">
				<i class="fa fa-download"></i>
				<input type="submit" value="Download">
			</form>	
		  </td>
        </tr>
        <tr>
          <td>File_3</td>
          <td>123kb</td>
          <td>.pdf</td>
          <td>January 1, 1990</td>
          <td>
			<form action="project.php" method="post" name="downloadform">
			<input name="file_name" value="File_2.pdf" type="hidden">
			<i class="fa fa-download"></i>
			<input type="submit" value="Download">
			</form>	
		  </td>
        </tr>
        <tr>
          <td>File_4</td>
          <td>123kb</td>
          <td>.html</td>
          <td>January 1, 1990</td>
          <td>
			<form action="project.php" method="post" name="downloadform">
			<input name="file_name" value="File_4.html" type="hidden">
			<i class="fa fa-download"></i>
			<input type="submit" value="Download">	
			</form>	
		  </td>
        </tr>
        <tr>
          <td>File_5</td>
          <td>123kb</td>
          <td>.css</td>
          <td>January 1, 1990</td>
          <td>
			<form action="project.php" method="post" name="downloadform">
			<input name="file_name" value="File_5.css" type="hidden">
			<i class="fa fa-download"></i>
			<input type="submit" value="Download">
			</form>	
		  </td>
        </tr>
      </table>
    </div>

    <div id="contributors" class="tabContent">
      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>
    </div>

  <div id="wrapbg">
    <!--LEAVE THIS DIV BLANK. THIS IS JUST THE WHITE BACKGROUND THAT FILLS THE
    HEIGHT OF THE BROWSER WITHOUT ENABLING THE SCROLL BAR-->
  </div>

  <!-- End of Content; start of Modules -->

  <div id="notifications">
    <p class="notificationsTitle">Notifications
    <hr>
    <div id="notificationsContainer">
      <div class="notification">
        <img class="notificationImage" src="../images/loginavatar.png">
        <p class="notificationMessage"><b>MemberName</b> deleted a file in the project <b>ProjectTitle</b>
      </div>

      <div class="notification">
        <img class="notificationImage" src="../images/loginavatar.png">
        <p class="notificationMessage"><b>MemberName</b> deleted a file in the project <b>ProjectTitle</b>
      </div>

      <div class="notification">
        <img class="notificationImage" src="../images/loginavatar.png">
        <p class="notificationMessage"><b>MemberName</b> deleted a file in the project <b>ProjectTitle</b>
      </div>

      <div class="notification">
        <img class="notificationImage" src="../images/loginavatar.png">
        <p class="notificationMessage"><b>MemberName</b> deleted a file in the project <b>ProjectTitle</b>
      </div>

      <div class="notification">
        <img class="notificationImage" src="../images/loginavatar.png">
        <p class="notificationMessage"><b>MemberName</b> deleted a file in the project <b>ProjectTitle</b>
      </div>

      <div class="notification">
        <img class="notificationImage" src="../images/loginavatar.png">
        <p class="notificationMessage"><b>MemberName</b> deleted a file in the project <b>ProjectTitle</b>
      </div>
    </div>
  </div>
  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" onclick="closeOptions()"></div>
  <div id="contactHeadBackground" onclick="closeContactHead()"></div>
</body>
</html>
