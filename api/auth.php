<?php
session_start();

if (!isset($_SESSION['empresa_id'])) {
    header("Location: login.php");
    exit;
}
