<?php

session_start();

// Generate a unique session ID for each tab
if (!isset($_SESSION['tab_id'])) {
  $_SESSION['tab_id'] = uniqid();
}

?>