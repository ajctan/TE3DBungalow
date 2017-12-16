<?php
    include '../php/dbh.php';
    session_start();

    $userLoggedIn = 0;
    $uType = 2;
    if(isset($_SESSION['uID'])){
      $userLoggedIn = $_SESSION['uID'];
      $uType = $_SESSION['uType']; //0 Admin, 1 Member, 2 Guest
    }

    $memberID = $_GET['mID'];
    $member = mysqli_fetch_assoc(getMember($memberID));
?>

<!DOCTYPE html>
<html>
<title>TedBungalow</title>
  <!--Font Awesome Stylesheet for icons-->
  <link rel="shortcut icon" href="../images/logo_b.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/script.js" type="text/javascript"></script>
  <script src="../js/profile.js" type="text/javascript"></script>
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
        if(isset($_SESSION['uType'])){
          if($uType == 0 && $member['uType'] != 0)
            if($member['uActive'] == 1)
              echo "<button id='optionsButton' onclick='openOptions()'><i class='fa fa-cog fa-2x'></i></button>
                    <div id='options'>
                  	  <form action='../php/delAcc.php' method='POST' onsubmit='return confirm(\"Are you sure you want to deactivate ".$member['uFName']." ".$member['uLName']."?\")'>
                    	 <button class=\"option\" name=\"accID\" value=\"".$memberID."\">Deactivate Account</button>
                      </form>
                    </div>";
            else
              echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
                    <div id=\"options\">
                      <form action=\"../php/reacAcc.php\" method=\"POST\">
                       <button class=\"option\" name=\"accID\" value=\"".$memberID."\">Reactivate Account</button>
                      </form>
                    </div>";
        }
      ?>

      <!-- End of MODULE -->
      <?php
        echo "
          <img class='pageLogo' src='../images/userImages/".$member['uID'].".'>
          <p id=\"pageTitle\" <h1>".$member['uFName']." ".$member['uLName']."</h1>";
      ?>
      <hr>
      <p class="pageLegend">
        <?php
          echo $member['uOccupation'];
        ?>
      </p>
    </div>
    <div id="tabButtons">
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'details')">Details & Credentials</button>
      <button class="tabButton" onclick="openTab(event, 'projects')">Projects</button>
      <button class="tabButton" onclick="openTab(event, 'colleagues')">Colleagues</button>
    </div>
    <div id="details" class="tabContent">
      <table>
        <tr>
          <th>Full Name:</th>
          <?php
            echo "<td>".$member['uFName']." ".$member['uLName']."</td>";
          ?>
          <th>Gender:</th>
          <?php
            echo "<td>".$member['uGender']."</td>";
          ?>
        </tr>
        <tr>
          <th>Occupation:</th>
          <?php
            echo "<td>".$member['uOccupation']."</td>";
          ?>
          <th>Affiliation:</th>
          <?php
            echo "<td>".$member['uAffiliation']."</td>";
          ?>
        </tr>
      </table>
    </div>

    <div id="projects" class="tabContent">
      <?php
          $result = getMemberProjects($memberID);
          $nResults = mysqli_num_rows($result);

          if ($nResults > 0){
            while ($project = mysqli_fetch_assoc($result)){
              $pHead = mysqli_fetch_assoc(getProjectHead($project['pHead']));

              $iClass = "";
              $projStart = "";
              $projEnd = "";

              if($project['tpEDate'] != null && $project['tpEDate'] == $project['tpSDate']){
                $iClass = "projectStatus cancelled";
                $date = date_create($project['tpSDate']);
                $projStart = date_format($date, 'jS F Y');
                $date = date_create($project['tpEDate']);
                $projEnd = date_format($date, 'jS F Y');
              }
              else if($project['tpEDate'] != null && $project['tpEDate'] != $project['tpSDate']){
                $iClass = "projectStatus done";
                $date = date_create($project['tpSDate']);
                $projStart = date_format($date, 'jS F Y');
                $date = date_create($project['tpEDate']);
                $projEnd = date_format($date, 'jS F Y');
              }
              else if($project['tpEDate'] == null){
                $iClass = "projectStatus ongoing";
                $date = date_create($project['tpSDate']);
                $projStart = date_format($date, 'jS F Y');
              }

              echo "<div class=\"projectDisplay\">
              <i class=\"".$iClass."\"></i>
              <a class=\"projectTitle\" href='project.php?pid=".$project['tpID']."'>".$project['tpTitle']."</a>
              <p class=\"projectHead\">".$pHead['uFName']." ".$pHead['uLName']."
              <p class=\"projectStart\">".$projStart."
              <p class=\"projectEnd\">".$projEnd."
              <p class=\"projectAbstract\">".$project['tpDesc']."
              <div class=\"cornerFold\">
              </div>
              </div></a>";
            }
          }

      ?>
    </div>

    <div id="colleagues" class="tabContent">
      <?php
        $result = getColleagues($memberID);
        $nResults = mysqli_num_rows($result);

        if ($nResults > 0){
          while ($colleague = mysqli_fetch_assoc($result)){
            echo "
            <div class=\"member\">
            <img class=\"memberImage\" src=\"../images/userImages/" .$colleague['uID']. "\">
            <a class=\"memberName\" href='profile.php?mID=".$colleague['uID']."'>".$colleague['uFName']." ".$colleague['uLName']."</a>
            <p class=\"memberTitle\">".$colleague['uOccupation']."
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
      <div class="notification">
      </div>
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

  <div id="editUserModal" class="largeModal">
    <div class="modalPadding">
      <form action="../php/updateuser.php" method="post" enctype="multipart/form-data">
        <?php
					echo "<input id='nuserID' name='nuserID' type='hidden' value='".$memberID."'>";
				?>
        <div id="imgcontainer">
        <?php
          echo "<img id='previewImage' src='../images/userImages/".$memberID.".'>";
        ?>
        <input id="profimgfile" type="file" name="pic" accept="image/*" onchange="PreviewImage();">
        <label id="profimglbl" for="profimgfile"><i class="fa fa-pencil"></i></label>
        </div>

        <h3>Login Information</h3>
        <hr>
        <label class="p100" for="email">Email Address</label>
        <input id="nuseremail" name="email" class="p100" type="text" placeholder="me@domain.com" required/>
        <label class="p50" for="pwd">Password</label>
        <label class="p50" for="cpwd">Confirm Password</label>
        <input id="pwd" name="pwd" class="p50" type="password" onkeyup="validatePassword();" required/>
        <input id="cpwd" name="cpwd" class="p50" type="password" onkeyup="validatePassword();" required/>
        <label id="validatePwd" class="p100 validate">Passwords do not match!</label>

        <h3>Basic Information</h3>
        <hr>
        <label class="p50" for="fname">First Name</label>
        <label class="p50" for="lname">Last Name</label>
        <input id="nuserfname" name="fname" class="p50" type="text" placeholder="First Name" /required>
        <input id="nuserlname" name="lname" class="p50" type="text" placeholder="Last Name" /required>
        <label class="p50" for="gender">Gender</label>
        <label class="p50" for="placeholder"></label>
        <input id="malerbtn" name="gender" class="dnone" type="radio" value="Male" />
        <label id="malelbl" for="malerbtn"><i class="fa fa-male"></i> Male</label>
        <input id="femalerbtn" name="gender" class="dnone" type="radio" value="Female" />
        <label id="femalelbl" for="femalerbtn"><i class="fa fa-female"></i> Female</label>
        <label class="p50" for="placeholder"></label>
        <label class="p50" for="occupation">Occupation</label>
        <label class="p50" for="affiliation">Affiliation</label>
        <input id="nuseroccupation" name="occupation" class="p50" type="text" required/>
        <input id="nuseraffiliation" name="affiliation" class="p50" type="text" required/>
        <label class="p50"></label>
        <button id="createUserBtn" class="p50" type="submit">Update User</button>
      </form>
    </div>
  </div>

  <?php
		if($userLoggedIn > 0 && ($memberID == $userLoggedIn || $uType == 0)){
			echo "<button class='contextButton' onclick='openEditUserModal(\"".$member['uName']."\", \"".$member['uPass']."\", \"".$member['uFName']."\", \"".$member['uLName']."\", \"".$member['uGender']."\", \"".$member['uOccupation']."\", \"".$member['uAffiliation']."\")'><i class='fa fa-pencil fa-2x'	></i></button>";
		}
	?>

  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" class="modalBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" class="modalBackground" onclick="closeOptions()"></div>
  <div id="loginbackground" class="modalBackground" onclick="closeLogin()"></div>
  <div id="editUserBackground" class="modalBackground" onclick="closeEditUserModal()"></div>
</body>
</html>
