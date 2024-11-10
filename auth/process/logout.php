<?php
session_start();
session_unset();
session_destroy();

header("Location: /ReviewMate/index.php");
exit();
?>
