<?php

function __autoload($class_name) {
    require_once "../library/class/" . $class_name . ".php";
}

?>
