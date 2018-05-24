<?php

$mysqli = mysqli_connect("localhost", "root", "root", "dockerdemo");

echo $mysqli->server_info;