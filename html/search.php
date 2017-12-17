<?php
    include '../php/dbh.php';

    session_start();

    $userLoggedIn = 0;
    $uType = 2;
    if(isset($_SESSION['uID'])){
      $userLoggedIn = $_SESSION['uID'];
      $uType = $_SESSION['uType']; //0 Admin, 1 Member, 2 Guest
    }
?>

<!DOCTYPE html>
<html>
<title>TedBungalow</title>
<!--Font Awesome Stylesheet for icons-->
<link rel="shortcut icon" href="../images/logo_b.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/search.css">
<script src="../js/script.js" type="text/javascript"></script>
<script src="../js/search.js" type="text/javascript"></script>

<?php
  if(array_key_exists('search-field', $_POST) == FALSE){
    $term = $_POST['search-field-searchpage'];
  }
  else{
  $term = $_POST['search-field'];
  }
  $member = "";
  $date = "";
  $funded = "";
  $status = "";
  $memberCh = false;
  $datCh = false;
  $funCh = false;
  $staCh = false;
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
        <input id="searchTerm" type="text" name="search-field-searchpage" placeholder="Search"/>
        <button id="searchButton" type="submit" name ="search-button">
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
      <img class="pageLogo" src="../images/searchlogo.png">
      <?php
         if(array_key_exists('search-field', $_POST) == FALSE){
         //echo "<h3>Search results for: '".$_POST['proj_q']." ".$_POST['mem_q']."'</h3>";
         }
        else{
        echo "<h3>Search results for: '".$_POST['search-field']."'</h3>";
        }
      ?>
      <hr>
      <div id="advSearch" onclick="openAdvSearch()">
        <p>Advanced Search <i class="right fa fa-caret-down"></i>
        <div id="advSearch-content" class="close">
          <form action="search.php" method="POST" onsubmit="performAdvSearch()">
            <input id="member" type="checkbox" onclick="toggleCheckBoxMember()"></input><label id="memberlbl" class="checkLabel" for="member">Member <input type="text" id="membervalue" placeholder="Member name"/></label>
            <input id="datestart" type="checkbox" onclick="toggleCheckBoxDate()"></input><label id="datestartlbl" class="checkLabel" for="datestart">Date Start <input type="date" id="datevalue"/></label>
            <input id="fundedby" type="checkbox" onclick="toggleCheckBoxFunded()"></input><label id="fundedbylbl" class="checkLabel" for="fundedby">Funded by <input type="text" id="fundedbyvalue" placeholder="Funded by"/></label>
            <input id="status" type="checkbox" onclick="toggleCheckBoxStatus()"></input><label id="statuslbl" class="checkLabel" for="status">Status <select placeholder="Status" id="statusvalue">
                                                                                                                      <option>Ongoing</option>
                                                                                                                      <option>Finished</option>
                                                                                                                      <option>Cancelled</option>
                                                                                                                    </select></label>
            <button class="p100 modalBtn" type="submit">Advanced Search</button>
            <input type="hidden" id="memberQuery" name="mem_q" value="" />
            <input type="hidden" id="projectQuery" name="proj_q" value="" />

          </form>
        </div>
      </div>
    </div>
    <div id="tabButtons">
      <button id="defaultOpen" class="tabButton half" onclick="openTab(event, 'projects')">Projects</button>
      <?php
        if($userLoggedIn > 0)
          echo '<button class="tabButton half" onclick="openTab(event, \'members\')">Members</button>';
      ?>
    </div>

    <div id="projects" class="tabContent">
      <?php
          if(array_key_exists('search-field', $_POST) == FALSE){
            $sql = $_POST['proj_q'];
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
          }
          else{
            $sql = "SELECT * FROM tptable WHERE tpTitle LIKE '%".$term."%' OR tpDesc LIKE '%".$term."%'";
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
          }
      ?>

    </div>

    <div id="members" class="tabContent">
        <?php
         if(array_key_exists('search-field', $_POST) == FALSE){
          $sql = $_POST['mem_q'];
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
          }
          else{
          $sql = "SELECT * FROM users WHERE CONCAT(uFName, \" \", uLName) LIKE '%".$term."%' ORDER BY uFName";
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
