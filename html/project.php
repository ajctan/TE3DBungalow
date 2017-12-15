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
		if($uli == 1){
	    $accType = $_COOKIE['accType'];
			$uliID = $_COOKIE['uID'];
		}
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
										<input name='delete' type='number' value='".$pID."' hidden/>
	        					<button class='option'>Delete Project</button>
	                </form>
      				  </div>";
      	}
      ?>

      <!-- End of MODALS -->
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
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'abstract')">Details & Abstract</button>
			<?php
	      if($uli == 1){
	      	echo "<button class=\"tabButton\" onclick=\"openTab(event, 'files')\">Files</button>";
					echo "<button class=\"tabButton\" onclick=\"openTab(event, 'contributors')\">Collaborators</button>";
				}
			?>
    </div>
    <script>
        function copyToClipboard(element) {
    		var $temp = $("<input>");
    		$("body").append($temp);
    		$temp.val($(element).text()).select();
    		document.execCommand("copy");
    		$temp.remove();
    		alert("Citation has been copied to your clipboard!");
		}
    </script>
  	<div id="abstract" class="tabContent">
			<?php
				if($project['tpEDate'] != null && $project['tpEDate'] == $project['tpSDate']){
					$iClass = "cancelled";
					$date = date_create($project['tpSDate']);
					$projStart = date_format($date, 'jS F Y');
					$date = date_create($project['tpEDate']);
					$projEnd = date_format($date, 'jS F Y');
				}
				else if($project['tpEDate'] != null && $project['tpEDate'] != $project['tpSDate']){
					$iClass = "done";
					$date = date_create($project['tpSDate']);
					$projStart = date_format($date, 'jS F Y');
					$date = date_create($project['tpEDate']);
					$projEnd = date_format($date, 'jS F Y');
				}
				else if($project['tpEDate'] == null){
					$iClass = "ongoing";
					$date = date_create($project['tpSDate']);
					$projStart = date_format($date, 'jS F Y');
					$projEnd = "";
				}
			?>
			<table class="p100">
				<tr>
					<th class="p25">Start Date:</th>
					<?php
						echo "<td class='p25'> ".$projStart." </td>";
					?>
					<th class="p25">Status:</th>
					<?php
						echo "<td class='p25'><i class='".$iClass."'></i></td>";
					?>
				</tr>
				<tr>
					<th>End Date:</th>
					<?php
						echo "<td> ".$projEnd." </td>";
					?>
					<th>Funded By:</th>
					<?php
						echo "<td> ".$project['pVentureC']." </td>";
					?>
				</tr>
			</table>
			<div id="projectAbstract">
			<?php
				$sanitized = nl2br($project['tpDesc']);
				$pText = explode("<br>", $sanitized);
        foreach($pText as $pGraph)
         	echo "<p>".$pGraph."</p>";
      	echo "<br>";
      ?>
		</div>
      <div class="footbuttonContainer">
        <button id="downloadAbstract" onclick=""><i class="fa fa-download"></i> Download Abstract (.pdf)</button>
        <?php
        	$sql = "SELECT * FROM tptable, users WHERE tptable.pHead = users.uID AND tptable.tpID LIKE ".$project['tpID'];
		    	$result = mysqli_query($conn,$sql);
		    	$row = mysqli_fetch_assoc($result);
		    	$myURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		    	$head = $row['uLName'].", ".substr($row['uFName'], 0, 1).".";
	    		$pCitation = "(".$row['tpSDate']."). ".$row['tpTitle'].". Retrieved from: ".$myURL."?pid=".$pID;

	    		$sql = "select projectID, count(projectID) from members where projectID = ".$project['tpID']." group by projectID";
	    		$result = mysqli_query($conn,$sql);
		    	$row = mysqli_fetch_assoc($result);

		    	if($row['count(projectID)'] == 1)
		    		echo "<div id=\"copy-text\" class=\"hidden\">".$head." ".$pCitation."</div>";
		    	else
		    		echo "<div id=\"copy-text\" class=\"hidden\">".$head.", et al. ".$pCitation."</div>";
        	echo "<button id=\"getCitation\" onclick=\"copyToClipboard('#copy-text')\"><i class=\"fa fa-file-text-o\"></i> Get Citation</button>";
        	if(!isset($_COOKIE['loggedIn']))
        		echo "<button id=\"contactProjectHead\" onclick=\"openContactHead()\"><i class=\"fa fa-envelope-o\"></i> Contact Project Head</button>";

        	echo "<div id=\"copy-text\" class=\"hidden\">".$pCitation."</div>";
        ?>
      </div>

      <div id="contactHead">
	      <div class="contactHeadHeader">
	      </div>
	      <form action="../php/cphead.php" method="POST">
	        <input type="text" name="email" placeholder="Your Email" required/>
	        <?php
	        	$sql = "SELECT * FROM tptable, users WHERE tptable.pHead = users.uID AND tptable.tpID LIKE ".$project['tpID'];
	    		$result = mysqli_query($conn,$sql);
	    		$row = mysqli_fetch_assoc($result);

	        	echo "<input name='projID' value=".$project['tpID']." type='hidden'>";
	        	echo "<input name='projHead' value=".$row['pHead']." type='hidden'>";
	        ?>
	        <textarea name="message" rows="17" placeholder="Your Message to the project head" required></textarea>
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
								<form action='../php/downloadFile.php' method='post' name='downloadform'>
									<input name='file_name' value=".$filename." type='hidden'>
									<button class='fileDownload' type='submit'><i class='fa fa-download'></i></button>
								</form>
							 </td>
						   </tr>";
				}
			}

		?>

      </table>
      <?php
      		$sql = 'select count(*) from members where projectID = '.$pID.' and userID = '.$_COOKIE['uID'];
      		$result = mysqli_query($conn,$sql);
	    	$row = mysqli_fetch_assoc($result);

	    	if($row['count(*)'] > 0){
			echo '<div class="footbuttonContainer">';
				echo '<form action="../php/uploadFile.php" method="post" enctype="multipart/form-data">';
					echo '<input type="hidden" name="projToUpload" value='.$pID.'>';
					echo '<input id="uploadFiles" type="file" onchange="this.form.submit()">';
					echo '<label id="uploadFilesLbl" for="uploadFiles" type="file"><i class="fa fa-upload"></i> Upload Files</label>';
				echo '</form>';
			echo '</div>';
			}
	  ?>
    </div>

    <div id="contributors" class="tabContent">
      <?php
      			$canEdit = 0;
				echo "
						<div class=\"member\">
							<img class=\"memberImage\" src=\"../images/userImages/" .$pHeadResult['uID']. "\">
							<a class=\"memberName\" href='profile.php?mID=".$pHeadResult['uID']."&isUser=0'>".$pHeadResult['uFName']." ".$pHeadResult['uLName']."</a>
							<p class=\"memberTitle\">Project Head
						</div>
						</a>";
				if($_COOKIE['uID'] == $pHeadResult['uID'] || $_COOKIE['accType'] == 0)
					$canEdit = 1;
				$getMembers = 'SELECT DISTINCT u.uID, u.uFName, u.uLName FROM users AS u, members AS m WHERE u.uID != '.$pHeadResult['uID'].' AND u.uID = m.userID AND m.projectID = ' .$pID.'';
				$result = mysqli_query($conn, $getMembers);
				$queryResults = mysqli_num_rows($result);

      	if($queryResults > 0){
      		while($mem = mysqli_fetch_assoc($result)){
  				echo "
  						<div class=\"member\">
    						<img class=\"memberImage\" src=\"../images/userImages/" .$mem['uID']. "\">
    						<a class=\"memberName\" href='profile.php?mID=".$mem['uID']."&isUser=0'>".$mem['uFName']." ".$mem['uLName']."</a>
    						<p class=\"memberTitle\">Member
  						</div>
  					  </a>";
  					  if($canEdit == 0 && $mem['uID'] == $_COOKIE['uID'])
  					  	$canEdit = 1;
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

	<div id="editProjectModal" class="largeModal">
    <div class="modalPadding">
      <form action="../php/updateproject.php" method="post">
				<?php
					echo "<input id='nprojectID' name='nprojectID' type='hidden' value='".$pID."'>";
				?>
        <div class="center">
          <label class="p100" for="nprojectTitle">Project Title</label>
          <input id="nprojectTitle" class="p100" name="nprojectTitle" type="text" />
					<label class="p100" for="nprojectcapital">Project Venure Capital</label>
          <input id="nprojectCapital" class="p100" name="nprojectcapital" type="text" />
          <label class="p100" for="nprojectHead">Project Head</label>
		  <select name='selectedprojectHead' class="p100">
				<?php
					$query = 'SELECT uID, uFName, uLName FROM users ORDER BY uFName';
					$result = mysqli_query($conn,$query);
					$queryResults = mysqli_num_rows($result);
					if ($queryResults > 0){
						while ($row = mysqli_fetch_assoc($result)){
							if($row['uID'] == $project['pHead'])
								echo "<option value=".$row['uID']." selected='selected'>".$row['uFName']. " ".$row['uLName']."</option>";
							else
								echo "<option value=".$row['uID'].">".$row['uFName']. " ".$row['uLName']."</option>";
						}
					}

				?>
		  </select>
          <label class="p100" for="nprojectAbstract">Abstract</label>
          <textarea id="nprojectAbstract" name="nprojectAbstract" rows="17" required></textarea>


          <label for="nprojectMembers" class="p100">Members</label>
					<select id="allMembers" class="select p50" size="5" multiple="multiple">
            <?php
              $query = 'SELECT uID, uFName, uLName FROM users WHERE uID NOT IN (SELECT userID FROM members WHERE projectID = '.$pID.') AND uID != '.$project['pHead'].' ORDER BY users.uFName';
              $result = mysqli_query($conn,$query);
              $queryResults = mysqli_num_rows($result);
              if ($queryResults > 0){
                while ($row = mysqli_fetch_assoc($result)){
                  echo "<option value='".$row['uID']."'>".$row['uFName']. " ".$row['uLName']."</option>";
                }
              }
            ?>
          </select>

          <select id="projectMembers" name="nprojectMembers[]" class="select p50" size="5" multiple="multiple">
						<?php
              $query = 'SELECT uID, uFName, uLName FROM users WHERE uID IN (SELECT userID FROM members WHERE projectID = '.$pID.') AND uID != '.$project['pHead'].' ORDER BY users.uFName';
              $result = mysqli_query($conn,$query);
              $queryResults = mysqli_num_rows($result);
              if ($queryResults > 0){
                while ($row = mysqli_fetch_assoc($result)){
                  echo "<option value='".$row['uID']."'>".$row['uFName']. " ".$row['uLName']."</option>";
                }
              }
            ?>
          </select>
					<button class="p50" type="button" onclick="addMember()">Add</button>
          <button class="p50" type="button" onclick="removeMember()">Remove</button>
        </div>

        <div class="alignRightContainer">
          <button class="p50 fRight" type="submit" onclick="submitMembers()">Update Project</button>
        </div>
      </form>
    </div>
  </div>

	<?php
		if($uli == 1 && $canEdit == 1){
			echo "<button class='contextButton' onclick='openEditProjectModal(\"".$project['tpTitle']."\", ".json_encode($project['pVentureC']).", ".json_encode($project['tpDesc']).")'><i class='fa fa-pencil fa-2x'	></i></button>";
		}
	?>

  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" class="modalBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" class="modalBackground" onclick="closeOptions()"></div>
	<div id="editProjectBackground" class="modalBackground" onclick="closeEditProjctModal()"></div>
  <div id="contactHeadBackground" class="modalBackground" onclick="closeContactHead()"></div>
  <div id="loginbackground" class="modalBackground" onclick="closeLogin()"></div>
</body>
</html>
