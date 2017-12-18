<?php
  include '../php/dbh.php';
  session_start();

  $userLoggedIn = 0;
  $uType = 2;
  $isPart = 0;
  if(isset($_SESSION['uID'])){
    $userLoggedIn = $_SESSION['uID'];
    $uType = $_SESSION['uType']; //0 Admin, 1 Member, 2 Guest
  }

  $pID = $_GET['pid'];
	$project = mysqli_fetch_assoc(getProject($pID));
  $pHead = mysqli_fetch_assoc(getProjectHead($project['pHead']));
  if($userLoggedIn > 0){
    $isPart = mysqli_fetch_assoc(checkMember($pID, $userLoggedIn));
    if($isPart['isPart'] > 0){
      $isPart = 1;
    }
  }
  $memCount = getMemCount($pID);
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
      if($userLoggedIn > 0){
        echo "<ul id=\"toolbarButtons\">
                <li><button id=\"userName\" class=\"toolbarButton\" onclick=\"location.href='profile.php?mID=".$userLoggedIn."';\">".$_SESSION['uFName']." ".$_SESSION['uLName']."</button></li>
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
    		if($uType == 0 || $project['pHead'] == $userLoggedIn){
    			echo "<button id='optionsButton' onclick='openOptions()'><i class='fa fa-cog fa-2x'></i></button>
    				  <div id='options'>
                <form action='../php/deleteProject.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this project?\");'>
									<input name='delete' type='number' value='".$pID."' hidden/>
        					<button class='option'>Delete Project</button>
                </form>
    				  </div>";
    			$isPart = 1;
    		}
      ?>

      <!-- End of MODALS -->
			<?php
				echo "<p id=\"pageTitle\">".$project['tpTitle'];
			?>
			<hr>
			<p class="pageLegend">
			<?php
				echo "<p id=\"projectHead\">".$pHead['uFName']." ".$pHead['uLName']."</p>";
			?>
		</div>

  	<div id="tabButtons">
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'abstract')">Details & Abstract</button>
			<?php
	      if($userLoggedIn > 0){
	      	echo "<button class=\"tabButton\" onclick=\"openTab(event, 'files')\">Files</button>
					      <button class=\"tabButton\" onclick=\"openTab(event, 'contributors')\">Collaborators</button>";
				}
			?>
    </div>
  	<div id="abstract" class="tabContent">
			<?php
        $iClass = "";
        $date = date_create($project['tpSDate']);
        $projStart = date_format($date, 'jS F Y');
        $projEnd = "";
        if($project['tpStatus'] == 0){
          $iClass = "cancelled";
          $date = date_create($project['tpEDate']);
          $projEnd = date_format($date, 'jS F Y');
        }
        else if($project['tpStatus'] == 2){
          $iClass = "done";
          $date = date_create($project['tpEDate']);
          $projEnd = date_format($date, 'jS F Y');
        }
        else if($project['tpStatus'] == 1){
          $iClass = "ongoing";
        }
			?>
			<table class="pt100">
				<tr>
					<th class="p20">Start Date:</th>
					<?php
						echo "<td> ".$projStart." </td>";
					?>
					<th class="p15">Status:</th>
					<?php
						echo "
                  <form action='../php/changeStatus.php' method='POST'>
                    <td class='p30'>
                      <i id='statusID' class='".$iClass."'></i>
                      <select id='newStatus' name='newStatus'>
                        <option value='1'>Ongoing</option>
                        <option value='2'>Finished</option>
                        <option value='0'>Cancelled</option>
                      </select>
                    </td>
                    <td class='p50'>";
                      if($isPart == 1)
                        echo "<button id='changeBtn' onclick='changeStatus()' type='button'>Change Status</button>";
                      echo"<button id='saveBtn'>Save Status</button>
                    </td>
                    <input name='pID' type='hidden' value='".$pID."' />
                  </form>";
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
          <td></td>
				</tr>
			</table>
			<div id="projectAbstract">
  			<?php
  				$sanitized = nl2br($project['tpDesc']);
  				$pText = explode("<br>", $sanitized);
    			echo "<p>";
    			foreach($pText as $pGraph){
    				echo $pGraph."<br>";
    			}
    			echo "</p>";
        ?>
		  </div>
      <div class="footbuttonContainer">
        <?php
		    	$myURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		    	$head = $pHead['uLName'].", ".substr($pHead['uFName'], 0, 1).".";
	    		$pCitation = "(".$project['tpSDate']."). ".$project['tpTitle'].". Retrieved from: ".$myURL."?pid=".$pID;

		    	if($memCount == 1)
		    		echo "<div id=\"projectCitation\" class=\"hidden\">".$head." ".$pCitation."</div>";
		    	else
		    		echo "<div id=\"projectCitation\" class=\"hidden\">".$head.", et al. ".$pCitation."</div>";
            ?>

        <textarea id="textToCopy" class="hidden"></textarea>
        <?php
          echo "<button id=\"getAbstract\" onclick=\"copyAbstractToClipboard('".$project['tpDesc']."')\"><i class=\"fa fa-file-text-o\"></i> Copy Abstract</button>";
        ?>
    	  <button id="getCitation" onclick="copyCitationToClipboard()"><i class="fa fa-file-text-o"></i> Get Citation</button>

          <?php
        	if(!isset($_SESSION['uID']))
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
		<?php
			$result = getFiles($pID);
			$nResults = mysqli_num_rows($result);

			if ($nResults > 0){
        echo
        "<table id='projectFiles'>
          <tr>
            <th class='name'>Name</th>
            <th class='size'>Size</th>
            <th class='extension'>Extension</th>
            <th class='lastModified'>Last Modified</th>
            <th></th>";
            if($isPart == 1){
            echo "<th></th>";
            }
          echo "</tr>";
				while ($file = mysqli_fetch_assoc($result)){
					$filename = $file['tpFileName'];
					$file_size = round($file['tpSize'] / 1024);
					$modified_date = $file['tpModified'];
					$file_extension = explode(".", $filename);

					echo "<tr>
							 <td>".$file_extension[0]."</td>
							 <td>".$file_size." kb</td>
							 <td>.".$file_extension[sizeof($file_extension)-1]."</td>
							 <td>".$modified_date."</td>
               <td>
                <form action='../projectFiles/".$pID."/".$filename."'>
                  <button class='fileDownload' type='submit'><i class='fa fa-download'></i></button>
                </form>
               </td>";
               if($isPart == 1 && $project['tpStatus'] == 1){
                 echo "
                 <td>
                  <form action='../php/deleteFile.php' method='post' onsubmit='return confirm(\"Are you sure you want to delete ".$filename."?\")'>
                    <input name='pID' type='hidden' value='".$pID."'>
                    <input name='fileName' type='hidden' value='".$filename."'>
                    <input name='fileID' type='hidden' value='".$file['fileID']."'>
                    <button class='fileDelete' type='submit'><i class='fa fa-trash'></i></button>
                  </form>
                 </td>";
               }
						   echo "</tr>";
				}
			} else {
        echo "<p class='noFiles'>This project doesn't have any files.";
      }
		?>
      </table>

			<div class="footbuttonContainer">
			<?php
				if($isPart == 1 && $project['tpStatus'] == 1){
					echo "<form action=\"../php/uploadFile.php\" method=\"post\" enctype=\"multipart/form-data\">";

						echo "<input type='hidden' name='projToUpload' value='$pID'>";

						echo "<input id=\"uploadFiles\" name=\"fileToUpload[]\" type=\"file\" onchange=\"this.form.submit()\"  multiple='multiple'>";
						echo "<label id=\"uploadFilesLbl\" for=\"uploadFiles\" type=\"file\"><i class=\"fa fa-upload\"></i> Upload Files</label>";
					echo "</form>";
				}
				?>
			</div>
    </div>

    <div id="contributors" class="tabContent">
      <?php
				echo "
						<div class=\"member\">
							<img class=\"memberImage\" src=\"../images/userImages/" .$pHead['uID']. "\">
							<a class=\"memberName\" href='profile.php?mID=".$pHead['uID']."'>".$pHead['uFName']." ".$pHead['uLName']."</a>
							<p class=\"memberTitle\">Project Head
						</div>
						</a>";

				$result = getProjectMembers($pID, $pHead['uID']);
				$nResults = mysqli_num_rows($result);

      	if($nResults > 0){
      		while($member = mysqli_fetch_assoc($result)){
  				echo "
  						<div class=\"member\">
    						<img class=\"memberImage\" src=\"../images/userImages/" .$member['uID']. "\">
    						<a class=\"memberName\" href='profile.php?mID=".$member['uID']."'>".$member['uFName']." ".$member['uLName']."</a>
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
      <?php
        if(isset($_SESSION['error']))
         echo '<label class="incorrectLogin">Incorrect username/password!</label>';
      ?>
      <input id="username" name="uname" type="text" placeholder="Email" required/>
      <input id="password" name="pword" type="password" placeholder="Password" required/>
      <button type="submit">Log In</button>
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
  				$result = getAllMembers();
  				$nResults = mysqli_num_rows($result);
  				if ($nResults > 0){
  					while ($member = mysqli_fetch_assoc($result)){
              if($member['uID'] == $pHead['uID'])
                echo "<option value=".$member['uID']." selected='selected'>".$member['uFName']. " ".$member['uLName']."</option>";
              else
                echo "<option value=".$member['uID'].">".$member['uFName']. " ".$member['uLName']."</option>";
  					}
  				}
  			?>
		  </select>
          <label class="p100" for="nprojectAbstract">Abstract</label>
          <textarea id="nprojectAbstract" name="nprojectAbstract" rows="17" required></textarea>


          <label for="nprojectMembers" class="p100">Members</label>
					<select id="allMembers" class="select p50" size="5" multiple="multiple">
            <?php
              $result = getNonProjectMembers($pID, $pHead['uID']);
              $nResults = mysqli_num_rows($result);
              if ($nResults > 0){
                while ($member = mysqli_fetch_assoc($result)){
                  echo "<option value='".$member['uID']."'>".$member['uFName']. " ".$member['uLName']."</option>";
                }
              }
            ?>
          </select>

          <select id="projectMembers" name="nprojectMembers[]" class="select p50" size="5" multiple="multiple">
						<?php
              $result = getProjectMembers($pID, $pHead['uID']);
              $nResults = mysqli_num_rows($result);
              if ($nResults > 0){
                while ($member = mysqli_fetch_assoc($result)){
                  echo "<option value='".$member['uID']."'>".$member['uFName']. " ".$member['uLName']."</option>";
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
		if($isPart == 1){
			echo "<button class='contextButton' onclick='openEditProjectModal(\"".$project['tpTitle']."\", \"".$project['pVentureC']."\", \"".$project['tpDesc']."\")'><i class='fa fa-pencil fa-2x'	></i></button>";
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
