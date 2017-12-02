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
                  <li><button id=\"userName\" class=\"toolbarButton\" onclick=\"location.href='profile.html';\">".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</button></li>
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
  <?php
    if(!isset($_COOKIE['loggedIn'])){
      header("Location: index.php");
    }
  ?>
  <div id="wrap">
    <div id="pageHead">
      <button id="optionsButton" onclick="openOptions()"><i class="fa fa-cog fa-2x"></i></button>
      <!-- MODULE: Option (To keep the position relative to parent div) -->
      <div id="options">
        <button>Terminate Account</button>
      </div>
      <!-- End of MODULE -->
      <img src="../images/loginavatar.png">
      <?php
        echo "<h1>".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</h1>";
      ?>
      <hr>
      <p class="pageLegend">
        <?php
          echo $_COOKIE['occupation']." at ".$_COOKIE['affiliation'];
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
            echo "<td>".$_COOKIE['uFName']." ".$_COOKIE['uLName']."</td>";
          ?>
          <th>Gender:</th>
          <?php
            echo "<td>".$_COOKIE['gender']."</td>";
          ?>
        </tr>
        <tr>
          <th>Occupation:</th>
          <?php
            echo "<td>".$_COOKIE['occupation']."</td>";
          ?>
          <th>Affiliation:</th>
          <?php
            echo "<td>".$_COOKIE['affiliation']."</td>";
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
              $memberIDs = explode(',', $row['tpMemberID']);
              $foundID = FALSE;
              foreach($memberIDs as $thisID){
                if($_COOKIE['uID'] == $thisID){
                  $foundID = TRUE;
                  break;
                }
              }
              if($foundID || $_COOKIE['uFName']." ".$_COOKIE['uLName'] == $row['pHead']){
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
      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>

      <div class="member">
        <img class="memberImage" src="../images/loginavatar.png">
        <p class="memberName">John Smith
        <p class="memberTitle">Professor
      </div>
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
    <form action="index.html" method="post">
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
