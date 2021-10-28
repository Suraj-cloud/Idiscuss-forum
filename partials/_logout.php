<?php
session_start();
echo "You are logging out. Please hold on....";
session_destroy();
header("Location: /forum") 
?>