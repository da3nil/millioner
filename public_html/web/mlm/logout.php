<?php
session_start();
session_destroy();
echo '<script>alert("Успешно");window.location.assign("index");</script>';
?>