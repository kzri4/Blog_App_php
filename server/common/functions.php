<?php

require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connectDb()
{
    try {
        return new PDO(DSN, USER, PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        echo 'システムエラーが発生しました';
        error_log($e->getMessage());
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}
