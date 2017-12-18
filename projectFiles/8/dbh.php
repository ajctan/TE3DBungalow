<?php

  $server = "localhost";
  $username = "root";
  $password = "";
  $dbname = "te3db";

  $conn = mysqli_connect($server, $username, $password, $dbname);

  function getAllProjectsByDate(){
    $query = 'SELECT *
              FROM tptable
              ORDER BY tpID DESC';
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getProjectHead($pHead){
    $query = 'SELECT uID, uFName, uLName
              FROM users
              WHERE uID = ' .$pHead;
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getAllMembers(){
    $query = 'SELECT uID, uFName, uLName
              FROM users
              ORDER BY uFName';
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getMemberProjects($memberID){
    $query = 'SELECT *
              FROM tptable
              WHERE tpID IN (SELECT projectID
                             FROM members
                             WHERE userID = '.$memberID.')';
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getMember($memberID){
    $query = 'SELECT *
              FROM users
              WHERE uID = ' .$memberID;
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getColleagues($memberID){
    $query = 'SELECT u.uID, u.uFName, u.uLName, u.uOccupation
              FROM users AS u, members AS m
              WHERE u.uID = m.userID AND u.uID != ' .$memberID. ' AND projectID IN (SELECT projectID
                                                                                       FROM members
                                                                                       WHERE userID = ' .$memberID. ')
              GROUP BY u.uID';
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getProject($projectID){
    $query = 'SELECT *
              FROM tptable
              WHERE tpID = '.$projectID;
  	return mysqli_query($GLOBALS['conn'],$query);
  }

  function getMemCount($projectID){
    $query = 'SELECT COUNT(memberID) as mCount from members WHERE projectID = '.$projectID;
    $count = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],$query));
    return $count['mCount'];
  }

  function checkMember($projectID, $userLoggedIn){
    $query = 'SELECT count(*) AS isPart
              FROM members
              WHERE projectID='.$projectID.' AND userID='.$userLoggedIn;
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getFiles($projectID){
    $query = 'SELECT *
              FROM files f, tptable tp
              WHERE f.tpID = tp.tpID
              AND tp.tpID = '.$projectID.'
              ORDER BY fileID DESC';
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getProjectMembers($projectID, $pHead){
    $query = 'SELECT DISTINCT u.uID, u.uFName, u.uLName
              FROM users AS u, members AS m
              WHERE u.uID != '.$pHead.' AND u.uID = m.userID AND m.projectID = ' .$projectID;
    return mysqli_query($GLOBALS['conn'],$query);
  }

  function getNonProjectMembers($projectID, $pHead){
    $query = 'SELECT uID, uFName, uLName
              FROM users
              WHERE uID NOT IN (SELECT userID
                                FROM members
                                WHERE projectID = '.$projectID.')
              AND uID != '.$pHead.'
              ORDER BY users.uFName';
    return mysqli_query($GLOBALS['conn'],$query);
  }
?>
