<?php
    include '../php/dbh.php';
?>

<!DOCTYPE html>
<html>
<title>TedBungalow</title>
<!--Font Awesome Stylesheet for icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/index.css">
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/index.js" type="text/javascript"></script>
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
                  <li><button class=\"toolbarButton\" name=\"".$uli."\" onclick=\"openLogin();\">Login</button></li>
                </ul>";
          if(!isset($_COOKIE['accType']))
            setcookie("accType", "2", 0, "/");
      }

    ?>
    <!--<ul id="toolbarButtons">
      <li><button id="notificationButton" class="toolbarButton" onclick="openNotifications()"><i id="notificationCount">99</i><i class="fa fa-bell"></i></button></li>
      <li><button id="userName" class="toolbarButton" onclick="location.href='profile.html';">Juan dela Cruz</button></li>
  		<li><button class="toolbarButton" onclick="openLogin();">Login</button></li>
    </ul>-->
  </div>

  <!-- End of Toolbar; start of Content -->
  <div id="wrap">
    <div id="pageHead">
      <img src="../images/projectlogo.png">
      <h1>Projects</h1>
      <hr>
      <p class="pageLegend">
        <i class="fa fa-hourglass-2"></i>: Ongoing
        <i class="fa fa-hourglass-end"></i>: Finished
        <i class="fa fa-hourglass"></i>: Cancelled
      </p>
    </div>
      <?php
          $sql = "SELECT * FROM tptable ORDER BY tpSDate DESC";
          $result = mysqli_query($conn,$sql);
          $queryResults = mysqli_num_rows($result);

          if ($queryResults > 0){
            while ($row = mysqli_fetch_assoc($result)){
                  $iClass = "";
                  $projStart = "";
                  $projEnd = "";
                  if($row['tpEDate'] != null && $row['tpEDate'] == $row['tpSDate']){
                    $iClass = "projectStatus fa fa-hourglass";
                    $date = date_create($row['tpSDate']);
                    $projStart = date_format($date, 'jS F Y');
                    $date = date_create($row['tpEDate']);
                    $projEnd = date_format($date, 'jS F Y');
                  }
                  else if($row['tpEDate'] != null && $row['tpEDate'] != $row['tpSDate']){
                    $iClass = "projectStatus fa fa-hourglass-end";
                    $date = date_create($row['tpSDate']);
                    $projStart = date_format($date, 'jS F Y');
                    $date = date_create($row['tpEDate']);
                    $projEnd = date_format($date, 'jS F Y');
                  }
                  else if($row['tpEDate'] == null){
                    $iClass = "projectStatus fa fa-hourglass-2";
                    $date = date_create($row['tpSDate']);
                    $projStart = date_format($date, 'jS F Y');
                  }

                  echo "<a href='project.php?pid=".$row['tpID']."' style=\"text-decoration:none;\"><div class=\"projectDisplay\">
                  <i class=\"".$iClass."\"></i>
                  <p class=\"projectTitle\">".$row['tpTitle']."
                  <p class=\"projectHead\">".$row['pHead']."
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

  <!--<div id="wrap">
    <div id="pageHead">
      <img src="../images/projectlogo.png">
      <h1>Projects</h1>
      <hr>
      <p class="pageLegend">
        <i class="fa fa-hourglass-2"></i>: Ongoing
        <i class="fa fa-hourglass-end"></i>: Finished
        <i class="fa fa-hourglass"></i>: Cancelled
      </p>
    </div>

    <div class="projectDisplay">
      <i class="projectStatus fa fa-hourglass-o"></i>
      <p class="projectTitle">Project Title
      <p class="projectHead">Project Head
      <p class="projectStart">Start Date
      <p class="projectEnd">End Date
      <p class="projectAbstract">Abstract
      <div class="cornerFold">
      </div>
    </div>

    <div class="projectDisplay">
      <i class="projectStatus fa fa-hourglass-2"></i>
      <p class="projectTitle">Project Title
      <p class="projectHead">Project Head
      <p class="projectStart">November 2, 2017
      <p class="projectEnd">-
      <p class="projectAbstract">An ongoing project will no have an end date and wil only have a "dash" in it's place.
      <div class="cornerFold">
      </div>
    </div>

    <div class="projectDisplay">
      <i class="projectStatus fa fa-hourglass-end"></i>
      <p class="projectTitle">Long Project Titles WIll Be Cut Off To Give The Impression That It Still Has Content
      <p class="projectHead">Project Head
      <p class="projectStart">November 2, 2017
      <p class="projectEnd">November 3, 2017
      <p class="projectAbstract">... the impression that it still has content. A finished project will have the date it was marked "finished" displayed below the project's start date.
      <div class="cornerFold">
      </div>
    </div>

    <div class="projectDisplay">
      <i class="projectStatus fa fa-hourglass"></i>
      <p class="projectTitle">Long Abstracts Will Be Cut Off As Well
      <p class="projectHead">Project Head
      <p class="projectStart">November 2, 2017
      <p class="projectEnd">November 2, 2017
      <p class="projectAbstract">A cancelled project will have the date it was marked "cancelled" displayed on the end date. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel nisi id neque interdum ultrices sed nec lorem. Mauris et est orci. Vestibulum sagittis risus quis dolor luctus eleifend. Fusce gravida enim in ex congue, vel pulvinar quam molestie. Fusce vel rhoncus enim. Vivamus accumsan libero quis eros pellentesque tempor. Suspendisse sit amet volutpat nunc. Nam aliquam tellus quis purus dignissim convallis ac ac dolor. Praesent tristique non sem nec fringilla. Fusce nec diam et urna euismod faucibus vel et dolor. Fusce semper iaculis diam faucibus convallis.
      <div class="cornerFold">
      </div>
    </div>
  </div>-->

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

  <div id="createProjectModal">
    <div id="createProjectContainer">
      <form action="index.html" method="post">
        <div style="text-align: center;">
          <label class="p100" for="nprojectTitle">Project Title</label>
          <input class="p100" name="nprojectTitle" type="text" />
          <label class="p100" for="nprojectHead">Project Head</label>
          <input type="text" name="selectedprojectHead" class="p50 selectedprojectHead" value="Juan dela Cruz" readonly>
          <button class="p50 modalBtn">Change</button>
          <label class="p100" for="nprojectAbstract">Abstract</label>
          <textarea name="nprojectAbstract" rows="17" required></textarea>

          <label class="p100" for="nprojectFiles">Files</label>
          <table id="nprojectFiles">
            <tr>
              <th class="name">Name</th>
              <th class="size">Size</th>
              <th class="extension">Extension</th>
              <th></th>
            </tr>
            <tr>
              <td>File_1</td>
              <td>123kb</td>
              <td>.ext</td>
              <td><i class="fa fa-trash"></i></td>
            </tr>
            <tr>
              <td>File_2</td>
              <td>123kb</td>
              <td>.ext</td>
              <td><i class="fa fa-trash"></i></td>
            </tr>
            <tr>
              <td>File_3</td>
              <td>123kb</td>
              <td>.ext</td>
              <td><i class="fa fa-trash"></i></td>
            </tr>
            <tr>
              <td>File_4</td>
              <td>123kb</td>
              <td>.ext</td>
              <td><i class="fa fa-trash"></i></td>
            </tr>
            <tr>
              <td>File_5</td>
              <td>123kb</td>
              <td>.ext</td>
              <td><i class="fa fa-trash"></i></td>
            </tr>
          </table>

          <div class="alignRightContainer">
            <button class="p50 fRight modalBtn">Select File(s)</button>
          </div>

          <label for="nprojectMembers" class="p100">Members</label>
          <select id="nprojectMembers" class="p100" size="5" multiple="multiple">
            <option>Juana dela Cruz</option>
            <option>John Smith</option>
          </select>
          <button class="p50 modalBtn">Remove User</button>
          <button class="p50 modalBtn">Add User(s)</button>
        </div>

        <div class="alignRightContainer">
          <button class="p50 fRight modalBtn" type="submit">Create Project</button>
        </div>
      </form>
    </div>
  </div>

  <div id="createUserModal">
    <div id="createUserContainer">
      <form action="index.html" method="post">
        <div id="imgcontainer">
        <img src="../images/loginavatar.png" />
        <input id="profimgfile" type="file" name="pic" accept="image/*">
        <label id="profimglbl" for="profimgfile"><i class="fa fa-pencil"></i></label>
        </div>

        <h3>Login Information</h3>
        <hr>
        <label class="p100" for="email">Email Address</label>
        <input name="email" class="p100" type="text" placeholder="me@domain.com" required/>
        <label class="p50" for="pwd">Password</label>
        <label class="p50" for="cpwd">Confirm Password</label>
        <input name="pwd" class="p50" type="password" required/>
        <input name="cpwd" class="p50" type="password" required/>

        <h3>Basic Information</h3>
        <hr>
        <label class="p45" for="fname">First Name</label>
        <label class="p10" for="mname">M.I.</label>
        <label class="p45" for="lname">Last Name</label>
        <input name="fname" class="p45" type="text" placeholder="First Name" /required>
        <input name="mname" class="p10" type="text" placeholder="M.I." /required>
        <input name="lname" class="p45" type="text" placeholder="Last Name" /required>
        <label class="p50" for="bdate">Birth Date</label>
        <label class="p50" for="gender">Gender</label>
        <input name="bdate" class="p50" type="date" required/>
        <input id="malerbtn" name="gender" class="dnone" type="radio" value="Male" />
        <label id="malelbl" for="malerbtn"><i class="fa fa-male"></i> Male</label>
        <input id="femalerbtn" name="gender" class="dnone" type="radio" value="Female" />
        <label id="femalelbl" for="femalerbtn"><i class="fa fa-female"></i> Female</label>

        <label class="p50"></label>
        <button class="p50" type="submit">Create User</button>
      </form>
    </div>
  </div>

  <div id="createSBContainer" class="createSBContainer-hidden">
    <button id="createProject" class="createButtonContainer" onclick="openCreateProjectModal()"><p>Create Project</p> <div class="createSpecificButton"><i class="fa fa-folder-open"></i></div></button>
    <button id="createUser" class="createButtonContainer" onclick="openCreateUserModal(); showCreateButtons()"><p>Create User</p> <div class="createSpecificButton"><i class="fa fa-user-plus"></i></div></button>
  </div>
  <button id="createButton" onclick="showCreateButtons()"><i class="fa fa-plus-circle fa-2x"></i></button>

  <div id="notificationsBackground" onclick="closeNotifications()"></div>
  <div id="loginbackground" onclick="closeLogin()"></div>
  <div id="createButtonbackground" class="createButtonbackground" onclick="showCreateButtons()"></div>
  <div id="createUserbackground" onclick="closeCreateUserModal()"></div>
  <div id="createProjectbackground" onclick="closeCreateProjectModal()"></div>
</body>
</html>
