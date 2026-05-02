<!--Content-->
<?php
session_start();
if (isset($_GET['x']) && $_GET['x'] == 'home') {
  $page = 'home.php';
  include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'orders') {
  if ($_SESSION["level_recafe"] == 1 || $_SESSION["level_recafe"] == 2) {
    $page = 'orders.php';
    include "main.php";
  } else {
    header("Location:home");
  }

} elseif (isset($_GET['x']) && $_GET['x'] == 'user') {
  if ($_SESSION["level_recafe"] == 1) {
    $page = 'user.php';
    include "main.php";
  } else {
    header("Location:home");
  }

} elseif (isset($_GET['x']) && $_GET['x'] == 'dapur') {
  if ($_SESSION["level_recafe"] == 1 || $_SESSION["level_recafe"] == 4) {
    $page = 'dapur.php';
    include "main.php";
  } else {
    header("Location:home");
  }

} elseif (isset($_GET['x']) && $_GET['x'] == 'reports') {
  if ($_SESSION["level_recafe"] == 1) {
    $page = 'reports.php';
    include "main.php";
  } else {
    header("Location:home");
  }

} elseif (isset($_GET['x']) && $_GET['x'] == 'menu') {
  if ($_SESSION["level_recafe"] == 1 || $_SESSION["level_recafe"] == 2) {
    $page = 'menu.php';
    include "main.php";
  } else {
    header("Location:home");
  }

} elseif (isset($_GET['x']) && $_GET['x'] == 'login') {
  include "login.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'logout') {
  include "proses/proses_logout.php";

} elseif (isset($_GET['x']) && $_GET['x'] == 'katmenu') {
  if ($_SESSION["level_recafe"] == 1) {
    $page = 'katmenu.php';
    include "main.php";
  } else {
    header("Location:home");
  }

} elseif (isset($_GET['x']) && $_GET['x'] == 'orderitem') {
  if ($_SESSION["level_recafe"] == 1 || $_SESSION["level_recafe"] == 2) {
    $page = 'orders_item.php';
    include "main.php";
  } else {
    header("Location:home");
  }
} elseif (isset($_GET['x']) && $_GET['x'] == 'viewitem') {
  if ($_SESSION["level_recafe"] == 1) {
    $page = 'view_item.php';
    include "main.php";
  } else {
    header("Location:home");
  }
} else {
  header("Location:home");
}
?>
<!--End Content-->