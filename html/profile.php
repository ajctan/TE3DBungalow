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
  <script src="../js/script.js" type="text/javascript"></script>
  <script src="../js/profile.js" type="text/javascript"></script>
  <?php
    $mID = $_GET['mID'];
    $query = 'SELECT * FROM users WHERE uID = ' .$mID;
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
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
      $uli = '0';
      if(isset($_COOKIE['loggedIn'])){
        $uli = $_COOKIE['loggedIn'];
        $uID = $_COOKIE['uID'];
        $uType = $_COOKIE['accType'];
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
      }else{
          echo "<ul id=\"toolbarButtons\">
                  <li><button class=\"toolbarButton\" name=\"".$uli."\" onclick=\"openLogin();\">Login</button></li>
                </ul>";
          if(!isset($_COOKIE['accType']))
            setcookie("accType", "2", 0, "/");
      }
    ?>
  </div>
  <!--<script>
  	function confirmDelete(){
  		var result = confirm("Are you sure you want to delete this account?");
  		if(result){
  			//window.location="../php/delAcc.php?accID=".document.getElementByID("accID");
			//window.location.replace("http://localhost/TE3dBungalow/php/delAcc.php?accID=".document.getElementByID("accID"));
			//window.location.href = "http://localhost/TE3dBungalow/php/delAcc.php?accID=".document.getElementByID("accID");
			//header("Location: ../php/delAcc.php".document.getElementByID("accID"));
			alert("../php/delAcc.php".document.getElementByID('accID').value);
  		}
  	}
  </script>-->
  <!-- End of Toolbar; start of Content -->
  <div id="wrap">
    <div id="pageHead">
      <?php
        if(isset($_COOKIE['loggedIn'])){
          if($_COOKIE['accType'] == 0 && $user['uType'] != 0)
            //echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
            //      <div id=\"options\">
            //        	<button class=\"option\" id=\"accID\" value=\"".$mID."\" onclick=\"confirmDelete()\">Terminate Account</button>
            //      </div>";
            if($user['uActive'] == 1)
              echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
                    <div id=\"options\">
                  	  <form action=\"../php/delAcc.php\" method=\"POST\">
                    	 <button class=\"option\" name=\"accID\" value=\"".$mID."\">Deactivate Account</button>
                      </form>
                    </div>";
            else
              echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
                    <div id=\"options\">
                      <form action=\"../php/reacAcc.php\" method=\"POST\">
                       <button class=\"option\" name=\"accID\" value=\"".$mID."\">Reactivate Account</button>
                      </form>
                    </div>";
        }
      ?>

      <!-- End of MODULE -->
      <?php
        echo "
          <img class='pageLogo' src='../images/userImages/".$user['uID'].".'>
          <p id=\"pageTitle\" <h1>".$user['uFName']." ".$user['uLName']."</h1>";
      ?>
      <hr>
      <p class="pageLegend">
        <?php
          echo $user['uOccupation'];
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
            echo "<td>".$user['uFName']." ".$user['uLName']."</td>";
          ?>
          <th>Gender:</th>
          <?php
            echo "<td>".$user['uGender']."</td>";
          ?>
        </tr>
        <tr>
          <th>Occupation:</th>
          <?php
            echo "<td>".$user['uOccupation']."</td>";
          ?>
          <th>Affiliation:</th>
          <?php
            echo "<td>".$user['uAffiliation']."</td>";
          ?>
        </tr>
      </table>
    </div>

    <div id="projects" class="tabContent">
      <?php
          $sql = "SELECT * FROM tptable WHERE tpID IN (SELECT projectID FROM members WHERE userID = ".$user['uID'].")";
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

    <div id="colleagues" class="tabContent">
      <?php
        $sql = 'SELECT u.uID, u.uFName, u.uLName, uOccupation FROM users AS u, members AS M WHERE u.uID = m.userID AND u.uID != ' .$user['uID']. ' AND projectID IN (SELECT projectID FROM members WHERE userID = ' .$user['uID']. ') GROUP BY u.uID';
        $result = mysqli_query($conn,$sql);
        $queryResults = mysqli_num_rows($result);

        if ($queryResults > 0){
          while ($row = mysqli_fetch_assoc($result)){
            echo "
            <div class=\"member\">
            <img class=\"memberImage\" src=\"../images/userImages/" .$row['uID']. "\">
            <a class=\"memberName\" href='profile.php?mID=".$row['uID']."&isUser=0'>".$row['uFName']." ".$row['uLName']."</a>
            <p class=\"memberTitle\">".$row['uOccupation']."
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
      <input id="username" name="uname" type="text" placeholder="Email" required/>
      <input id="password" name="pword" type="password" placeholder="Password" required/>
      <button type="submit">Log In</button>
      <a href="">Forgot Password?</a>
    </form>
  </div>

  <div id="editUserModal" class="largeModal">
    <div class="modalPadding">
      <form action="../php/updateuser.php" method="post" enctype="multipart/form-data">
        <?php
					echo "<input id='nuserID' name='nuserID' type='hidden' value='".$user['uID']."'>";
				?>
        <div id="imgcontainer">
        <?php
          echo "<img id='previewImage' src='../images/userImages/".$user['uID'].".'>";
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
		if($uli == 1 && ($mID == $uID || $uType == 0)){
			echo "<button class='contextButton' onclick='openEditUserModal(\"".$user['uName']."\", \"".$user['uPass']."\", \"".$user['uFName']."\", \"".$user['uLName']."\", \"".$user['uGender']."\", \"".$user['uOccupation']."\", \"".$user['uAffiliation']."\")'><i class='fa fa-pencil fa-2x'	></i></button>";
		}
	?>

  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" class="modalBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" class="modalBackground" onclick="closeOptions()"></div>
  <div id="loginbackground" class="modalBackground" onclick="closeLogin()"></div>
  <div id="editUserBackground" class="modalBackground" onclick="closeEditUserModal()"></div>
</body>
</html>
