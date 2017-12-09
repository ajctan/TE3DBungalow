<?php
include '../php/dbh.php';

function findContentType($ext){
	switch($ext){
		case 'docx': return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'; break;
		case 'xlsx':  return 'application/vnd.ms-excel'; break;
		case 'ppt':  return 'application/vnd.ms-powerpoint'; break;
		case 'pdf':  return 'application/pdf'; break;
		case 'html': return 'text/html'; break;
		case 'jpeg': return 'image/jpeg'; break;
		case 'png':  return 'image/png'; break;
		case 'css':  return 'text/css'; break;
		case 'zip':  return 'application/zip'; break;
		case 'rar': return 'application/x-rar-compressed'; break;
		default: return 'application/octet-stream';
	}
}

if(isset($_POST['file_name'])){

	$file = $_POST['file_name'];
	$download_file = 'SELECT * , OCTET_LENGTH(tpFile) as file_size FROM files f, tptable tp WHERE f.tpID = tp.tpID AND f.tpFileName = "'.$file.'"';
	$found_file = mysqli_query($conn, $download_file);
	$row = mysqli_fetch_assoc($found_file);
	$file_size= $row['file_size'];
	$file_extension = explode(".", $file);

    $file_exist = mysqli_num_rows($found_file);

	if ($file_exist > 0){

			header('Content-type: '. findContentType($file_extension[sizeof($file_extension)-1]));
			header("Content-Length: ". $file_size);
			header('Content-Disposition: attachment; filename="'.$file.'"');
			//readfile('uploads/'.$file);
			echo $row['tpFile'];
			mysqli_free_result($found_file);

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
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/project.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

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
      <form action="search.php" method="POST">
        <input id="searchTerm" type="text" name="search-field" placeholder="Search"/>
        <button id="searchButton" type="submit" name="search-button">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>
    <?php
      $uli = '0';
      if(isset($_COOKIE['loggedIn'])){
        $uli = $_COOKIE['loggedIn'];
        if($uli == '1'){
          echo "<ul id=\"toolbarButtons\">
                  <li><button id=\"notificationButton\" class=\"toolbarButton\" onclick=\"openNotifications()\"><i id=\"notificationCount\">99</i><i class=\"fa fa-bell\"></i></button></li>
                  <li><button id=\"userName\" class=\"toolbarButton\" onclick=\"location.href='profile.php?mName=".$_COOKIE['uFName']." ".$_COOKIE['uLName']."&isUser=1';\">".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</button></li>
                  <li><button class=\"toolbarButton\" onclick=\"location.href='../php/logOut.php'\">Logout</button></li>
                </ul>";
        }else{
          echo "<ul id=\"toolbarButtons\">
                  <li><button class=\"toolbarButton\" name=\"li1\" onclick=\"openLogin();\">Login</button></li>
                </ul>";
        }
      }else{
          echo "<ul id=\"toolbarButtons\">
                  <li><button class=\"toolbarButton\" onclick=\"openLogin();\">Login</button></li>
                </ul>";
          if(!isset($_COOKIE['accType']))
            setcookie("accType", "2", 0, "/");
      }

    ?>

  </div>

  <!-- End of Toolbar; start of Content -->

  <div id="wrap">
    <div id="pageHead">
      <?php
      	if(isset($_GET['pid'])){
      		setcookie("PID", $_GET['pid'], 0, "/");
      		$pID = mysqli_real_escape_string($conn, $_GET['pid']);
      		if($_COOKIE['PID'] != $_GET['pid'])
      			header('Location: ../html/project.php?pid='.$_GET['pid']);
      	}else
      		$pID = mysqli_real_escape_string($conn, $_COOKIE['PID']);

        $sql = "SELECT * FROM tptable WHERE tpID LIKE ".$pID;
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);

      	if(isset($_COOKIE['loggedIn'])){
      		if($_COOKIE['accType'] == 0 || $row['pHead'] == $_COOKIE['uFName']." ".$_COOKIE['uLName'])
      			echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
      				  <div id=\"options\">
                <form action=\"../php/deleteProject.php\" method=\"POST\">
        				<button name=\"dlete\" value=".$_COOKIE['PID'].">Delete Project</button>
                </form>
      				  </div>";
      	}
      ?>

      <!-- End of MODALS -->

      <?php
          $sanitized = nl2br($row['tpDesc']);
          $pText = explode("<br />", $sanitized);
          echo "<img src=\"../images/projectlogo.png\">
                <p id=\"projectTitle\">".$row['tpTitle']."
                <hr>
                <p class=\"pageLegend\">
                  <p id=\"projectHead\">".$row['pHead']."
                </p>
    </div>
                <div id=\"tabButtons\">
                  <button id=\"defaultOpen\" class=\"tabButton\" onclick=\"openTab(event, 'abstract')\">Abstract</button>";
          if(isset($_COOKIE['loggedIn']))
          	echo "<button class=\"tabButton\" onclick=\"openTab(event, 'files')\">Files</button>";
          else
          	echo "<button class=\"tabButton\" onclick=\"alert('Please Log in to view/retrieve files')\">Files</button>";

          echo 			"<button class=\"tabButton\" onclick=\"openTab(event, 'contributors')\">Contributors</button>
                </div>

  <div id=\"abstract\" class=\"tabContent\">";

          foreach($pText as $pGraph)
          	echo "<p>".$pGraph."</p>";
      	  echo "<br>";
      ?>
      <div id="footbuttonContainer">
        <button id="downloadAbstract" onclick=""><i class="fa fa-download"></i> Download Abstract (.pdf)</button>
        <button id="getCitation" onclick=""><i class="fa fa-file-text-o"></i> Get Citation</button>
        <button id="contactProjectHead" onclick="openContactHead()"><i class="fa fa-envelope-o"></i> Contact Project Head</button>
      </div>
      <div id="contactHead">
      <div class="contactHeadHeader">
        <button id="closeContactHead" onclick="closeContactHead()">X</button>
      </div>
      <form action="../php/cphead.php" method="POST">
        <input type="text" name="email" placeholder="Your Email" required/>
        <?php
        	$sql = "SELECT * FROM tptable WHERE tpID LIKE ".$_COOKIE['PID'];
    		$result = mysqli_query($conn,$sql);
    		$row = mysqli_fetch_assoc($result);

        	echo "<input name='projID' value=".$_COOKIE['PID']." type='hidden'>";
        	echo "<input name='projHead' value=".$row['pHead']." type='hidden'>";
        ?>
        <textarea name="message" rows="15" required></textarea>
        <button id="sendMessage" type="submit"><i class="fa fa-send fa-2x"></i></button>
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

		<?php
			$acquire_files = 'SELECT f.tpID, f.tpFile, OCTET_LENGTH(f.tpFile) as file_size, f.tpFileName, f.tpModified, tp.tpTitle, tp.pHead FROM files f, tptable tp WHERE f.tpID = tp.tpID  AND tp.tpID ='.$pID;
			$result = mysqli_query($conn,$acquire_files);
			$num_of_files = mysqli_num_rows($result);

			if ($num_of_files > 0){
				while ($row = mysqli_fetch_assoc($result)){
					$filename = $row['tpFileName'];
					$file_size = round($row['file_size'] / 1024);
					$modified_date = $row['tpModified'];
					$file_extension = explode(".", $filename);

					echo "<tr>
							 <td>".$file_extension[0]."</td>
							 <td>".$file_size." kb</td>
							 <td>.".$file_extension[sizeof($file_extension)-1]."</td>
							 <td>".$modified_date."</td>
							 <td>
								<form action='project.php' method='post' name='downloadform'>
									<input name='file_name' value=".$filename." type='hidden'>
									<i class='fa fa-download'></i>
									<input type='submit' value='Download'>
								</form>
							 </td>
						   </tr>";
				}
			}

		?>

      </table>
    </div>

    <div id="contributors" class="tabContent">
      <?php
      	$getMembers = 'SELECT pHead, tpMemberName FROM tpTable WHERE tpID='.$pID;
      	$result = mysqli_query($conn,$getMembers);
      	$queryResults = mysqli_num_rows($result);

      	if($queryResults > 0){
      		$row = mysqli_fetch_assoc($result);
      		echo "
      				<div class=\"member\">
        				<img class=\"memberImage\" src=\"../images/loginavatar.png\">
        				<a class=\"memberName\" href='profile.php?mName=".$row['pHead']."&isUser=0'>".$row['pHead']."</a>
        				<p class=\"memberTitle\">Project Head
      				</div>
      			  </a>";
      		if($row['tpMemberName'] != ""){
      			$members = explode(",", $row['tpMemberName']);
      			foreach($members as $mem){
      				if($mem == "")
      					break;
      				echo "
      						<div class=\"member\">
        						<img class=\"memberImage\" src=\"../images/loginavatar.png\">
        						<a class=\"memberName\" href='profile.php?mName=".$mem."&isUser=0'>".$mem."</a>
        						<p class=\"memberTitle\">Member
      						</div>
      					  </a>";
      			}
      		}
      	}
      ?>
      <!--<div class="member">
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
      </div>-->
    </div>

  <!--<div id="wrapbg">
  </div>-->

  <!-- End of Content; start of Modules -->

  <div id="notifications">
    <p class="notificationsTitle">Notifications
    <hr>
    <div id="notificationsContainer">

    </div>
  </div>

  <div id="login">
    <img src="../images/loginavatar.png">
    <form action="../php/logIn.php" method="post">
      <input id="username" name="uname" type="text" placeholder="Email" required/>
      <input id="password" name="pword" type="password" placeholder="Password" required/>
      <button type="submit">Log In</button>
      <a href="">Forgot Password?</a>
    </form>
  </div>
  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" onclick="closeOptions()"></div>
  <div id="contactHeadBackground" onclick="closeContactHead()"></div>
  <div id="loginbackground" onclick="closeLogin()"></div>
</body>
</html>
