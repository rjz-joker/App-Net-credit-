<?php
session_start();
$_SESSION['LOGIN_AUTH']=md5('A8_t^a9uI-+?2');
header("Location: /Admin/Login/index.html");