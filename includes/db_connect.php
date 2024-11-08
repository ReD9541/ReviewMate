<?php
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $db = "reviewmate";

    $servername = '153.92.15.26';
    $db = 'u791027335_movie_db';
    $username = 'u791027335_admin';
    $password = 'l7HGSK8|';

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
   ?>