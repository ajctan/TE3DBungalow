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
        <button id="searchButton" type="submit" name ="search-button">
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
  </div>

  <!-- End of Toolbar; start of Content -->

  <div id="wrap">
    <div id="pageHead">
      <img src="../images/searchlogo.png">
      <?php
        echo "<h3>Search results for: '".$_POST['search-field']."'</h3>"
      ?>
      <hr>
      <p class="pageLegend">
        'search query here'
      </p>
    </div>
    <div id="tabButtons">
      <button id="defaultOpen" class="tabButton half" onclick="openTab(event, 'projects')">Projects</button>
      <button class="tabButton half" onclick="openTab(event, 'members')">Members</button>
    </div>

    <div id="projects" class="tabContent">
      <?php
          $term = $_POST['search-field'];
          $sql = "SELECT * FROM tptable WHERE tpTitle LIKE '%".$term."%' OR tpDesc LIKE '%".$term."%'";
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

    <div id="members" class="tabContent">
        <?php
          $term = $_POST['search-field'];
          $sql = "SELECT * FROM users WHERE CONCAT(uFName, \" \", uLName) LIKE '%".$term."%'";
          $result = mysqli_query($conn,$sql);
          $queryResults = mysqli_num_rows($result);

          if ($queryResults > 0){
            while ($row = mysqli_fetch_assoc($result)){
                  $berTitle = "";
                  if($row['uType'] == 0){
                    $berTitle = "Administrator";
                  }
                  else if($row['uType'] == 1){
                    $berTitle = "Member";
                  }
                  echo "<a href='profile.php?mName=".$row['uFName']." ".$row['uLName']."&isUser=0' style=\"text-decoration:none;\">
                  <div class=\"member\">
                  <img class=\"memberImage\" src=\"../images/userImages/" .$row['uID']. ".png\">
                  <p class=\"memberName\">".$row['uFName']." ".$row['uLName'].
                  "<p class=\"memberTitle\">".$berTitle."
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
  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" onclick="closeOptions()"></div>
  <div id="loginbackground" onclick="closeLogin()"></div>
</body>
</html>
