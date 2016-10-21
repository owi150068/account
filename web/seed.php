<?php
$host = 'localhost:8889';
$dbname = 'account';
$username = "root";
$password = "root";

if(getenv('CLEARDB_DATABASE_URL')){
$host = getenv('DATABASE_HOST');
$dbname = getenv('DATABASE_DBNAME');
$username = getenv('DATABASE_USERNAME');
$password = getenv('DATABASE_PASSWORD');
}

$dsn = "mysql:host=$host;charset=utf8";

try{
    $pdo = new PDO($dsn, $username, $password);
    
    
    
    //CREATE DB
    $statement = $pdo->prepare("CREATE DATABASE IF NOT EXISTS $dbname;");
    $statement->execute();
    $pdo->query("use $dbname;");
    
    //USER TABLE
    $statement = $pdo->prepare("CREATE TABLE IF NOT EXISTS users(
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255),
    email varchar(255),
    avatar_path varchar(255),
    password_hash varchar(32),
    PRIMARY KEY (id)
    )");
    $statement->execute();
    
    
    
    //ADD USERS IF TABLE EMPTY
    $statement = $pdo->prepare("SELECT COUNT(*) FROM users;");
    $statement->execute();
    $numUsers = $statement->fetchColumn();
    if($numUsers == 0){
        $sql	=	"INSERT	INTO	users	(name,	email,	avatar_path,	password_hash)
                    VALUES	(:name,	:email,	:avatar_path, :password_hash);";
        $statement	=	$pdo->prepare($sql);
        $statement->bindValue(':name',	'Mark',	PDO::PARAM_STR);
        $statement->bindValue(':email',	'mark@facebook.com',	PDO::PARAM_STR);
        $statement->bindValue(':avatar_path',	'/images/mark.jpg',	PDO::PARAM_STR);
        $statement->bindValue(':password_hash',	md5('friendface'),	PDO::PARAM_STR);
        $statement->execute();
        
        $statement->bindValue(':name',	'Bill',	PDO::PARAM_STR);
        $statement->bindValue(':email',	'bill@microsoft.com',	PDO::PARAM_STR);
        $statement->bindValue(':avatar_path',	'/images/bill.jpg',	PDO::PARAM_STR);
        $statement->bindValue(':password_hash',	md5('windows'),	PDO::PARAM_STR);
        $statement->execute();
        
        $statement->bindValue(':name',	'Tim',	PDO::PARAM_STR);
        $statement->bindValue(':email',	'tim@web.com',	PDO::PARAM_STR);
        $statement->bindValue(':avatar_path',	'/images/tim.png',	PDO::PARAM_STR);
        $statement->bindValue(':password_hash',	md5('www'),	PDO::PARAM_STR);
        $statement->execute();
        
        $statement->bindValue(':name',	'Dennis',	PDO::PARAM_STR);
        $statement->bindValue(':email',	'dennis@unix.com',	PDO::PARAM_STR);
        $statement->bindValue(':avatar_path',	'/images/dennis.jpg',	PDO::PARAM_STR);
        $statement->bindValue(':password_hash',	md5('c++'),	PDO::PARAM_STR);
        $statement->execute();
    }
    
    
    $statement = $pdo->prepare("CREATE TABLE IF NOT EXISTS friendships(
    sender_id int,
    receiver_id int,
    accepted int(1),
    PRIMARY KEY(sender_id, receiver_id)
    )");
    $statement->execute();
    
     //ADD USERS IF TABLE EMPTY
    $statement = $pdo->prepare("SELECT COUNT(*) FROM friendships;");
    $statement->execute();
    $numUsers = $statement->fetchColumn();
    if($numFriendships == 0){
        $sql	=	"INSERT	INTO	friendships	(sender_id,	receiver_id, accepted)
                    VALUES	(:sender_id, :receiver_id, :accepted);";
        $statement	=	$pdo->prepare($sql);
        $statement->bindValue(':sender_id',	2,	PDO::PARAM_INT);
        $statement->bindValue(':receiver_id', 1,	PDO::PARAM_INT);
        $statement->bindValue(':accepted', 0,	PDO::PARAM_INT);
        $statement->execute();
        
         $statement->bindValue(':sender_id',	3,	PDO::PARAM_INT);
        $statement->bindValue(':receiver_id', 1,	PDO::PARAM_INT);
        $statement->bindValue(':accepted', 0,	PDO::PARAM_INT);
        $statement->execute();
         
        $statement->bindValue(':sender_id',	1,	PDO::PARAM_INT);
        $statement->bindValue(':receiver_id', 4,	PDO::PARAM_INT);
        $statement->bindValue(':accepted', 1,	PDO::PARAM_INT);
        $statement->execute();
    }
    
    
} catch (PDOException $exception){
    echo 'Database Error: ' . $exception->getMessage();
}
?>