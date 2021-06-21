<?php

require_once __DIR__ . '/../common/functions.php';

define ('RAND_VALUE', '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
echo "データベースをSET UPしますか？ [yes] or [no]" . PHP_EOL;

$answer = trim(fgets(STDIN));

if ($answer !== 'yes') exit;

try {
    $dbh = connectDb();
    $dbh->query('SET foreign_key_checks = 0');
    $sql_dir = __DIR__ . '/sql/';

    foreach (glob($sql_dir . "*.sql") as $file) {
        $sql = file_get_contents($file);
        $dbh->exec($sql);
    }
    
    echo '■■■■ テーブル削除完了 ■■■■' . PHP_EOL;
    echo '■■■■ categoriesテーブル SET UP完了 ■■■■' . PHP_EOL;

    $images_dir = __DIR__ . '/../public/images/';
    foreach (glob($images_dir . "*") as $dir) {
        if (is_dir($dir)) {
            foreach (glob($dir . "/*") as $file) {
                if (basename($file) !== 'no_image.png') {
                    unlink($file);
                }
            }
        }
    }
    echo '■■■■ 画像ファイル削除完了 ■■■■' . PHP_EOL;

    $sql = <<< EOM
    INSERT INTO
        users (email, password, name, profile, avator)
    VALUES
        (:email, :password, :name, :profile, :avator)
    EOM;

    $stmt = $dbh->prepare($sql);
    $images_dir = __DIR__ . 'images/users/';
    foreach (glob($images_dir . "*") as $i => $file) {
        $file_name = basename($file);
        $image = date('YmdHis') . '_' . $file_name;
        copy($file, $copy_dir . $image);
        $id = ++$i;
        $email = "test_" . (string) $id . "@example.com";
        $name = substr(str_shuffle(RAND_VALUE), 0, 50);
        $password = 

    }

    $dbh->query('SET foreign_key_checks = 1');

    echo '■■■■ データベース SET UP完了 ■■■■' . PHP_EOL;

} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}