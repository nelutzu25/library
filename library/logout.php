<?php include('header.php');
session_destroy();
header('Location: '.$root.'login');
include('footer.php');?>