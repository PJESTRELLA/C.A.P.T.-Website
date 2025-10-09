<?php
    session_start();
    header('Content-Type: application/json');

    echo json_encode(['name' => $_SESSION['name']]);
