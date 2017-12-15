<?php
    include '../php/dbh.php';
?>

<!DOCTYPE html>
<html>
<title>TedBungalow</title>
<!--Font Awesome Stylesheet for icons-->
<link rel="shortcut icon" href="../images/logo_b.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/index.css">
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/index.js" type="text/javascript"></script>

<?php
  $uli = '0';
  $accType = '2'; //0 Admin, 1 Member, 2 Guest

  if(isset($_COOKIE['loggedIn'])){
		$uli = $_COOKIE['loggedIn'];
		if($uli == 1){
	    $accType = $_COOKIE['accType'];
			$uliID = $_COOKIE['uID'];
		}
  }
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
      <img class="pageLogo" src="../images/projectlogo.png">
      <h1>Projects</h1>
      <hr>
      <p class="pageLegend">
        <i class="ongoing"></i>: Ongoing
        <i class="done"></i>: Finished
        <i class="cancelled"></i>: Cancelled
      </p>
    </div>
      <?php
          $sql = "SELECT * FROM tptable ORDER BY tpSDate DESC";
          $result = mysqli_query($conn,$sql);
          $queryResults = mysqli_num_rows($result);

          if ($queryResults > 0){
            while ($row = mysqli_fetch_assoc($result)){
                  $query = 'SELECT uFName, uLName FROM users WHERE uID = ' .$row['pHead'].'';
                  $queryResult = mysqli_query($conn,$query);
                  $pHeadResult = mysqli_fetch_assoc($queryResult);

                  $iClass = "";
                  $projStart = "";
                  $projEnd = "";
                  if($row['tpEDate'] != null && $row['tpEDate'] == $row['tpSDate']){
                    $iClass = "projectStatus cancelled";
                    $date = date_create($row['tpSDate']);
                    $projStart = date_format($date, 'jS F Y');
                    $date = date_create($row['tpEDate']);
                    $projEnd = date_format($date, 'jS F Y');
                  }
                  else if($row['tpEDate'] != null && $row['tpEDate'] != $row['tpSDate']){
                    $iClass = "projectStatus done";
                    $date = date_create($row['tpSDate']);
                    $projStart = date_format($date, 'jS F Y');
                    $date = date_create($row['tpEDate']);
                    $projEnd = date_format($date, 'jS F Y');
                  }
                  else if($row['tpEDate'] == null){
                    $iClass = "projectStatus ongoing";
                    $date = date_create($row['tpSDate']);
                    $projStart = date_format($date, 'jS F Y');
                  }

                  echo "<div class=\"projectDisplay\">
                  <i class=\"".$iClass."\"></i>
                  <a class=\"projectTitle\" href='project.php?pid=".$row['tpID']."'>".$row['tpTitle']."</a>
                  <p class=\"projectHead\">".$pHeadResult['uFName']." ".$pHeadResult['uLName']."
                  <p class=\"projectStart\">".$projStart."
                  <p class=\"projectEnd\">".$projEnd."
                  <p class=\"projectAbstract\">".$row['tpDesc']."
                  <div class=\"cornerFold\">
                  </div>
                  </div></a>";
            }
          }

      ?>
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

  <div id="createProjectModal" class="largeModal">
    <div class="modalPadding">
      <form action="../php/createProject.php" method="post">
        <div class="center">
          <label class="p100" for="nprojectTitle">Project Title</label>
          <input class="p100" name="nprojectTitle" type="text" />
          <label class="p100" for="nprojectcapital">Project Venure Capital</label>
          <input class="p100" name="nprojectcapital" type="text" />
          <label class="p100" for="nprojectHead">Project Head</label>
		  <select name='selectedprojectHead' class="p100">
			<?php
				$query = 'SELECT uID, uFName, uLName FROM users ORDER BY uFName';
				$result = mysqli_query($conn,$query);
				$queryResults = mysqli_num_rows($result);
				if ($queryResults > 0){
					while ($row = mysqli_fetch_assoc($result)){
						echo "<option value=".$row['uID'].">".$row['uFName']. " ".$row['uLName']."</option>";
					}
				}

			?>
		  </select>
          <label class="p100" for="nprojectAbstract">Abstract</label>
          <textarea name="nprojectAbstract" rows="17" required></textarea>


          <label class="p50">All Members</label>
          <label class="p50">Project Members</label>
          <select id="allMembers" class="select p50" size="5" multiple="multiple">
            <?php
              $query = 'SELECT uID, uFName, uLName FROM users ORDER BY uFName';
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

          </select>
          <button class="p50" type="button" onclick="addMember()">Add</button>
          <button class="p50" type="button" onclick="removeMember()">Remove</button>
        </div>

        <div class="alignRightContainer">
          <button class="p50 fRight" type="submit" onclick="submitMembers()">Create Project</button>
        </div>
      </form>
    </div>
  </div>

  <div id="createUserModal" class="largeModal">
    <div class="modalPadding">
      <form action="../php/createuser.php" method="post" enctype="multipart/form-data">
        <div id="imgcontainer">
        <img id="previewImage" src="../images/loginavatar.png" />
        <input id="profimgfile" type="file" name="pic" accept="image/*" onchange="PreviewImage();">
        <label id="profimglbl" for="profimgfile"><i class="fa fa-pencil"></i></label>
        </div>

        <h3>Login Information</h3>
        <hr>
        <label class="p100" for="email">Email Address</label>
        <input name="email" class="p100" type="text" placeholder="me@domain.com" required/>
        <label class="p50" for="pwd">Password</label>
        <label class="p50" for="cpwd">Confirm Password</label>
        <input id="pwd" name="pwd" class="p50" type="password" onkeyup="validatePassword();" required/>
        <input id="cpwd" name="cpwd" class="p50" type="password" onkeyup="validatePassword();" required/>
        <label id="validatePwd" class="p100 validate">Passwords do not match!</label>

        <h3>Basic Information</h3>
        <hr>
        <label class="p50" for="fname">First Name</label>
        <label class="p50" for="lname">Last Name</label>
        <input name="fname" class="p50" type="text" placeholder="First Name" /required>
        <input name="lname" class="p50" type="text" placeholder="Last Name" /required>
        <label class="p50" for="gender">Gender</label>
        <label class="p50" for="placeholder"></label>
        <input id="malerbtn" name="gender" class="dnone" type="radio" value="Male" />
        <label id="malelbl" for="malerbtn"><i class="fa fa-male"></i> Male</label>
        <input id="femalerbtn" name="gender" class="dnone" type="radio" value="Female" />
        <label id="femalelbl" for="femalerbtn"><i class="fa fa-female"></i> Female</label>
        <label class="p50" for="placeholder"></label>
        <label class="p50" for="occupation">Occupation</label>
        <label class="p50" for="affiliation">Affiliation</label>
        <input name="occupation" class="p50" type="text" required/>
        <input name="affiliation" class="p50" type="text" required/>
        <label class="p50"></label>
        <button id="createUserBtn" class="p50" type="submit">Create User</button>
      </form>
    </div>
  </div>

  <?php
    if($uli == '1'){
      echo "
      <div id=\"createSBContainer\" class=\"createSBContainer-hidden\">
        <button id=\"createProject\" class=\"createButtonContainer\" onclick=\"openCreateProjectModal(); showCreateButtons()\"><p>Create Project</p> <div class=\"createSpecificButton\"><i class=\"fa fa-folder-open\"></i></div></button>";
        if($_COOKIE['accType'] == 0)
          echo "<button id=\"createUser\" class=\"createButtonContainer\" onclick=\"openCreateUserModal(); showCreateButtons()\"><p>Create User</p> <div class=\"createSpecificButton\"><i class=\"fa fa-user-plus\"></i></div></button>";
      echo "
      </div>
      <button id=\"createButton\" onclick=\"showCreateButtons()\"><i class=\"fa fa-plus-circle fa-2x\"></i></button>";
    }
  ?>

  <div id="notificationsBackground" class="modalBackground" onclick="closeNotifications()"></div>
  <div id="loginbackground" class="modalBackground" onclick="closeLogin()"></div>
  <div id="createButtonbackground" class="modalBackground createButtonbackground" onclick="showCreateButtons()"></div>
  <div id="createUserbackground" class="modalBackground" onclick="closeCreateUserModal()"></div>
  <div id="createProjectbackground" class="modalBackground" onclick="closeCreateProjectModal()"></div>
</body>
</html>
