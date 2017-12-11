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
      <?php
        if(isset($_COOKIE['loggedIn'])){
          if($_COOKIE['accType'] == 0)
            echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
                  <div id=\"options\">

                    <button class=\"option\">Terminate Account</button>
                  </div>";
        }
      ?>

      <!-- End of MODULE -->
      <?php
        echo "
          <img class='pageLogo' src='../images/userImages/".$user['uID'].".png'>
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
            <img class=\"memberImage\" src=\"../images/userImages/" .$row['uID']. ".png\">
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
  <!-- These are transparent 100% x 100% box behind the module, that closes the module when clicked -->
  <div id="notificationsBackground" onclick="closeNotifications()"></div>
  <div id="optionsBackground" onclick="closeOptions()"></div>
  <div id="loginbackground" onclick="closeLogin()"></div>
</body>
</html>
