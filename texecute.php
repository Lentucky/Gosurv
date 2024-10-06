<?php

if ($_SERVER['REQUEST_METHOD'] === "GET")
{
    if (isset($_GET['questionSettings']))
    {
        $get = $_GET['questionSettings'];
        print($get);
    } else {
        print('Error');
    }
}