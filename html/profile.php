<?php
    include '../php/dbh.php';
?>

<!DOCTYPE html>
<html>
<title>TedBungalow</title>
<!--Font Awesome Stylesheet for icons-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/style.css">
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
  </div>

  <!-- End of Toolbar; start of Content -->
  <div id="wrap">
    <div id="pageHead">
      <?php
        if(isset($_COOKIE['loggedIn'])){
          if($_COOKIE['accType'] == 0)
            echo "<button id=\"optionsButton\" onclick=\"openOptions()\"><i class=\"fa fa-cog fa-2x\"></i></button>
                  <div id=\"options\">

                    <button>Terminate Account</button>
                  </div>";
        }
      ?>
      <!--<button id="optionsButton" onclick="openOptions()"><i class="fa fa-cog fa-2x"></i></button>
      <div id="options">
        <button>Terminate Account</button>
      </div>-->
      <!-- End of MODULE -->
      <img src="../images/loginavatar.png">
      <?php
        if($_GET['isUser'] == 1)
          echo "<h1>".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</h1>";
        else
          echo "<h1>".$_GET['mName']."</h1>";
      ?>
      <hr>
      <p class="pageLegend">
        <?php
          if($_GET['isUser'] == 1)
            echo $_COOKIE['occupation']." at ".$_COOKIE['affiliation'];
          else

        ?>
      </p>
    </div>
    <div id="tabButtons">
      <button id="defaultOpen" class="tabButton" onclick="openTab(event, 'details')">Details & Credentials</button>
      <button class="tabButton" onclick="openTab(event, 'projects')">Projects</button>
      <button class="tabButton" onclick="openTab(event, 'colleagues')">Colleagues</button>
    </div>
    <?php
      if($_GET['isUser'] == 0){
        $getMInfo = "SELECT * FROM users WHERE CONCAT(uFName, \" \", uLName) LIKE '".$_GET['mName']."'";
        $result = mysqli_query($conn,$getMInfo);
        $mInfo = mysqli_fetch_assoc($result);
      }
    ?>
    <div id="details" class="tabContent">
      <table>
        <tr>
          <th>Full Name:</th>
          <?php
            if($_GET['isUser'] == 1)
              echo "<td>".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</td>";
            else
              echo "<td>".$_GET['mName']."</td>";
          ?>
          <th>Gender:</th>
          <?php
            if($_GET['isUser'] == 1)
              echo "<td>".$_COOKIE['gender']."</td>";
            else
              echo "<td>".$mInfo['uGender']."</td>";
          ?>
        </tr>
        <tr>
          <th>Occupation:</th>
          <?php
            if($_GET['isUser'] == 1)
              echo "<td>".$_COOKIE['occupation']."</td>";
            else
              echo "<td>".$mInfo['uOccupation']."</td>";
          ?>
          <th>Affiliation:</th>
          <?php
            if($_GET['isUser'] == 1)
              echo "<td>".$_COOKIE['affiliation']."</td>";
            else
              echo "<td>".$mInfo['uAffiliation']."</td>";
          ?>
        </tr>
      </table>

      <ul>
        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        <li>Donec et ex fringilla, laoreet elit sed, fringilla nisl.</li>
        <li>Vestibulum laoreet justo consectetur sem maximus, ac vestibulum dui sagittis.</li>
        <li>Suspendisse at nibh eget turpis interdum vestibulum.</li>
        <li>Duis aliquet felis et nisi tempor mollis.</li>
        <li>Suspendisse ut eros imperdiet, ultrices nisi at, fermentum neque.</li>
        <li>Sed finibus leo eget mauris convallis pulvinar.</li>
        <li>Praesent non sem vel enim mattis pulvinar.</li>
        <li>Duis ac lacus ac elit sollicitudin egestas.</li>
        <li>Suspendisse maximus mi non leo rhoncus, vitae egestas lectus egestas.</li>
        <li>In in nulla facilisis, tristique elit in, molestie massa.</li>
        <li>Phasellus sit amet nulla sed orci blandit lobortis at vel tellus.</li>
        <li>Curabitur viverra nisl id justo sollicitudin mattis.</li>
        <li>Suspendisse dictum ante a felis efficitur dignissim.</li>
        <li>Phasellus feugiat justo eget consectetur rutrum.</li>
        <li>Sed et sapien sed nibh gravida sodales sit amet id tortor.</li>
        <li>Sed vitae nisi aliquet, cursus mauris rutrum, ultricies libero.</li>
        <li>Nunc euismod justo placerat quam ultricies venenatis.</li>
        <li>Phasellus a est nec risus faucibus dictum ac in leo.</li>
        <li>Vivamus eget arcu sollicitudin, consequat eros nec, ornare elit.</li>
        <li>Sed sit amet mi hendrerit, facilisis urna et, pellentesque nisl.</li>
        <li>Donec feugiat ipsum a nulla bibendum, nec semper ex cursus.</li>
        <li>Phasellus mattis velit vitae maximus semper.</li>
        <li>Etiam ultricies arcu a metus volutpat, in gravida ante semper.</li>
        <li>Etiam facilisis dolor sed faucibus facilisis.</li>
        <li>In accumsan risus nec rutrum imperdiet.</li>
        <li>Vestibulum a mi luctus, porttitor odio accumsan, pharetra nulla.</li>
        <li>Nullam auctor diam ut nisi dapibus, quis facilisis massa congue.</li>
        <li>Morbi bibendum nisi sit amet enim gravida placerat.</li>
        <li>Ut et urna faucibus felis tincidunt volutpat vel at sem.</li>
        <li>Curabitur nec velit accumsan, tincidunt diam eget, ullamcorper neque.</li>
      </ul>
    </div>

    <div id="projects" class="tabContent">
      <?php
          $sql = "SELECT * FROM tptable";
          $result = mysqli_query($conn,$sql);
          $queryResults = mysqli_num_rows($result);
          if ($queryResults > 0){
            while ($row = mysqli_fetch_assoc($result)){
              $memberIDs = explode(',', $row['tpMemberName']);
              $foundID = FALSE;
              $fllName;
              if($_GET['isUser'] == 1)
                  $fllName = $_COOKIE['uFName']." ".$_COOKIE['uLName'];
              else
                  $fllName = $_GET['mName'];

              foreach($memberIDs as $thisID){
                  if($fllName == $thisID){
                    $foundID = TRUE;
                    break;
                  }
              }
              if($foundID || $fllName == $row['pHead']){
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

                  echo "<div class=\"projectDisplay\">
                  <i class=\"".$iClass."\"></i>
                  <a class=\"projectTitle\" href='project.php?pid=".$row['tpID']."'>".$row['tpTitle']."</a>
                  <p class=\"projectHead\">".$row['pHead']."
                  <p class=\"projectStart\">".$projStart."
                 <p class=\"projectEnd\">".$projEnd."
                 <p class=\"projectAbstract\">".$row['tpDesc']."
                  <div class=\"cornerFold\">
                  </div>
                  </div>";
                }
            }
          }

      ?>
    </div>
    <!--<div id="projects" class="tabContent">
      <div class="projectDisplay">
        <i class="projectStatus fa fa-hourglass-end"></i>
        <p class="projectTitle">Project Title That Is Really Long That WIll Overlap With The Date
        <p class="projectHead">Project Head
        <p class="projectStart">January 1, 1990
        <p class="projectEnd">December 31, 2050
        <p class="projectAbstract">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel nisi id neque interdum ultrices sed nec lorem. Mauris et est orci. Vestibulum sagittis risus quis dolor luctus eleifend. Fusce gravida enim in ex congue, vel pulvinar quam molestie. Fusce vel rhoncus enim. Vivamus accumsan libero quis eros pellentesque tempor. Suspendisse sit amet volutpat nunc. Nam aliquam tellus quis purus dignissim convallis ac ac dolor. Praesent tristique non sem nec fringilla. Fusce nec diam et urna euismod faucibus vel et dolor. Fusce semper iaculis diam faucibus convallis.
        <div class="cornerFold">
        </div>
      </div>

      <div class="projectDisplay">
        <i class="projectStatus fa fa-hourglass"></i>
        <p class="projectTitle">Project Title
        <p class="projectHead">Project Head
        <p class="projectStart">January 1, 1990
        <p class="projectEnd">December 31, 2050
        <p class="projectAbstract">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel nisi id neque interdum ultrices sed nec lorem. Mauris et est orci. Vestibulum sagittis risus quis dolor luctus eleifend. Fusce gravida enim in ex congue, vel pulvinar quam molestie. Fusce vel rhoncus enim. Vivamus accumsan libero quis eros pellentesque tempor. Suspendisse sit amet volutpat nunc. Nam aliquam tellus quis purus dignissim convallis ac ac dolor. Praesent tristique non sem nec fringilla. Fusce nec diam et urna euismod faucibus vel et dolor. Fusce semper iaculis diam faucibus convallis.
        <div class="cornerFold">
        </div>
      </div>
    </div>-->

    <div id="colleagues" class="tabContent">
      <?php
        //$pHeadName = $_COOKIE['uFName']." ".$_COOKIE['uLName'];
        $sql = "SELECT tpMemberName FROM tptable WHERE pHead = '".$_GET['mName']."'";
        $result = mysqli_query($conn,$sql);
        $queryResults = mysqli_num_rows($result);
        $a=array("");

        if ($queryResults > 0){
          while ($row = mysqli_fetch_assoc($result)){

                  $pieces = explode(",",$row['tpMemberName']);

                  foreach($pieces as $value){
                    $pieces2 = explode(" ",$value);

                    $numberInArr = 0;
                    foreach($pieces2 as $value2){
                      $numberInArr++;
                    }

                    if($pieces2[0] != "" AND $pieces2[$numberInArr-1] != ""){
                      $sql2 = "SELECT * FROM users WHERE uFName LIKE '%".$pieces2[0]."%' AND uLName LIKE '%".$pieces2[$numberInArr-1]."%'";
                      $result2 = mysqli_query($conn,$sql2);
                      $queryResults2 = mysqli_num_rows($result2);
                      if ($queryResults2 > 0){
                        while ($row2 = mysqli_fetch_assoc($result2)){
                           $berTitle = "";
                           if($row2['uType'] == 0){
                             $berTitle = "Administrator";
                           }
                           else if($row2['uType'] == 1){
                             $berTitle = "Member";
                           }


                          if(!in_array($pieces2[0]." ".$pieces2[$numberInArr-1],$a)){
                          echo "<a href='profile.php?mName=".$row2['uFName']." ".$row2['uLName']."&isUser=0' style=\"text-decoration:none;\">
                          <div class=\"member\">
                          <img class=\"memberImage\" src=\"../images/loginavatar.png\">
                          <p class=\"memberName\">".$row2['uFName']." ".$row2['uLName'].
                          "<p class=\"memberTitle\">".$berTitle."
                          </div></a>";

                          array_push($a,$pieces2[0]." ".$pieces2[$numberInArr-1]);
                          }
                          else{

                          }
                          $numberInArr = 0;
                        }
                      }
                    }
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
      <div class="notification">

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
