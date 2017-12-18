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
  <!-- End of Toolbar; start of Content -->
  <div id="wrap">
    <div id="pageHead">
      <!-- End of MODULE -->
      <img class='pageLogo' src='../images/bictory.png'>
      <p id="pageTitle" <h1>Bictory</h1>
      <hr>
      <p class="pageLegend">
        SOFENGG X22A
      </p>
    </div>
    <div id="tabButtons">
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'details')">Details & Credentials</button>
      <button class="tabButton" onclick="openTab(event, 'colleagues')">Members</button>
    </div>
    <div id="details" class="tabContent">
      We are students from De La Salle University currently taking Software Engineering under Ms. Ma. Christine A. Gendrano
    </div>

    <div id="colleagues" class="tabContent">
      <?php
        $sql = 'SELECT uID, uFName, uLName, uOccupation FROM users WHERE uAffiliation LIKE "Bictory"';
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

  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" class="modalBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" class="modalBackground" onclick="closeOptions()"></div>
  <div id="loginbackground" class="modalBackground" onclick="closeLogin()"></div>
  <div id="editUserBackground" class="modalBackground" onclick="closeEditUserModal()"></div>
</body>
</html>
