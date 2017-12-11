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
<link rel="shortcut icon" href="../images/logo_b.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/project.css">
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/project.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<?php
  $uli = '0';
  $accType = '2'; //0 Admin, 1 Member, 2 Guest
	$pID = $_GET['pid'];

  if(isset($_COOKIE['loggedIn'])){
    $uli = $_COOKIE['loggedIn'];
    $accType = $_COOKIE['accType'];
		$uliID = $_COOKIE['uID'];
  }

	$sql = "SELECT * FROM tptable WHERE tpID LIKE ".$pID;
	$result = mysqli_query($conn,$sql);
	$project = mysqli_fetch_assoc($result);
?>

</head>
<body>
  <!-- Start of Toolbar -->
	<div id="toolbar">
    <div id="logo">
      <img src="../images/dlsu_logo_w.png" height="30px">
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
      if($uli == '1'){
        echo "<ul id=\"toolbarButtons\">
                <li><button id=\"notificationButton\" class=\"toolbarButton\" onclick=\"openNotifications()\"><i id=\"notificationCount\">99</i><i class=\"fa fa-bell\"></i></button></li>
                <li><button id=\"userName\" class=\"toolbarButton\" onclick=\"location.href='profile.php?mID=".$_COOKIE['uID']."&isUser=1';\">".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</button></li>
                <li><button class=\"toolbarButton\" onclick=\"location.href='../php/logOut.php'\">Logout</button></li>
              </ul>";
      }else{
        echo "<ul id=\"toolbarButtons\">
                <li><button class=\"toolbarButton\" name=\"li1\" onclick=\"openLogin();\">Login</button></li>
              </ul>";
      }
    ?>
  </div>

  <!-- End of Toolbar; start of Content -->

  <div id="wrap">
    <div id="pageHead">
      <?php
				$query = 'SELECT uID, uFName, uLName FROM users WHERE uID = ' .$project['pHead'].'';
				$queryResult = mysqli_query($conn,$query);
				$pHeadResult = mysqli_fetch_assoc($queryResult);

      	if($uli == 1){
      		if($accType == 0 || $project['pHead'] == $uliID)
      			echo "<button id='optionsButton' onclick='openOptions()'><i class='fa fa-cog fa-2x'></i></button>
      				  <div id='options'>
	                <form action='../php/deleteProject.php' method='POST'>
	        					<button class='option' name='delete' value=".$pID.">Delete Project</button>
	                </form>
      				  </div>";
      	}
      ?>

      <!-- End of MODALS -->
			<img src="../images/projectlogo.png">
			<?php
				echo "<p id=\"pageTitle\">".$project['tpTitle'];
			?>
			<hr>
			<p class="pageLegend">
			<?php
				echo "<p id=\"projectHead\">".$pHeadResult['uFName']." ".$pHeadResult['uLName']."</p>";
			?>
		</div>

  	<div id="tabButtons">
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'abstract')">Abstract</button>
			<?php
	      if($uli == 1){
	      	echo "<button class=\"tabButton\" onclick=\"openTab(event, 'files')\">Files</button>";
					echo "<button class=\"tabButton\" onclick=\"openTab(event, 'contributors')\">Contributors</button>";
				}
	      else{
	      	echo "<button class=\"tabButton\" onclick=\"alert('Please Log in to view/retrieve files')\" disabled>Files</button>";
					echo "<button class=\"tabButton\" onclick=\"alert('Please Log in to view the contributors')\" disabled>Contributors</button>";
				}
			?>
    </div>

  	<div id="abstract" class="tabContent">
			<?php
				$sanitized = nl2br($project['tpDesc']);
				$pText = explode("<br />", $sanitized);
        foreach($pText as $pGraph)
         	echo "<p>".$pGraph."</p>";
      	echo "<br>";
      ?>
      <div class="footbuttonContainer">
        <button id="downloadAbstract" onclick=""><i class="fa fa-download"></i> Download Abstract (.pdf)</button>
        <button id="getCitation" onclick=""><i class="fa fa-file-text-o"></i> Get Citation</button>
        <button id="contactProjectHead" onclick="openContactHead()"><i class="fa fa-envelope-o"></i> Contact Project Head</button>
      </div>
      <div id="contactHead">
	      <div class="contactHeadHeader">
	      </div>
	      <form action="../php/cphead.php" method="POST">
	        <input type="text" name="email" placeholder="Your Email" required/>
	        <?php
	        	$sql = "SELECT * FROM tptable WHERE tpID LIKE ".$project['tpID'];
	    			$result = mysqli_query($conn,$sql);
	    			$row = mysqli_fetch_assoc($result);

	        	echo "<input name='projID' value=".$project['tpID']." type='hidden'>";
	        	echo "<input name='projHead' value=".$row['pHead']." type='hidden'>";
	        ?>
	        <textarea name="message" rows="17" required></textarea>
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
									<button class='fileDownload' type='submit'><i class='fa fa-download'></i></button>
								</form>
							 </td>
						   </tr>";
				}
			}

		?>

      </table>
			<div class="footbuttonContainer">
				<form action="../php/uploadFile.php" method="post" enctype="multipart/form-data">
					<?php echo '<input type="hidden" name="projToUpload" value='.$pID.'>'?>
					<input id="uploadFiles" type="file" onchange="this.form.submit()">
					<label id="uploadFilesLbl" for="uploadFiles" type="file"><i class="fa fa-upload"></i> Upload Files</label>
				</form>
			</div>
    </div>

    <div id="contributors" class="tabContent">
      <?php
				echo "
						<div class=\"member\">
							<img class=\"memberImage\" src=\"../images/userImages/" .$pHeadResult['uID']. ".png\">
							<a class=\"memberName\" href='profile.php?mID=".$pHeadResult['uID']."&isUser=0'>".$pHeadResult['uFName']." ".$pHeadResult['uLName']."</a>
							<p class=\"memberTitle\">Project Head
						</div>
						</a>";

				$getMembers = 'SELECT u.uID, u.uFName, u.uLName FROM users AS u, members AS m WHERE u.uID != '.$pHeadResult['uID'].' AND u.uID = m.userID AND m.projectID = ' .$pID.'';
				$result = mysqli_query($conn, $getMembers);
				$queryResults = mysqli_num_rows($result);

      	if($queryResults > 0){
      		while($mem = mysqli_fetch_assoc($result)){
  				echo "
  						<div class=\"member\">
    						<img class=\"memberImage\" src=\"../images/userImages/" .$mem['uID']. ".png\">
    						<a class=\"memberName\" href='profile.php?mID=".$mem['uID']."&isUser=0'>".$mem['uFName']." ".$mem['uLName']."</a>
    						<p class=\"memberTitle\">Member
  						</div>
  					  </a>";
					}
      	}
      ?>
    </div>
	</div>

  <div id="wrapbg">
  </div>

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
