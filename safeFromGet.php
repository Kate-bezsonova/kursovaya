<?php
function safeFromGet($name)
{
    global $DBC;
    return isset($_GET[$name]) ?  mysqli_real_escape_string($DBC, $_GET[$name]) : false;
}
?>