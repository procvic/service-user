<?php

if (!file_exists('configuration.php')) {
    $erorrConfigurationMessage = 'You have to create a file \'configuration.php\'. '
        . 'You can inspire in \'configuration.example.php\'';
    throw new Exception($erorrConfigurationMessage);
}

require 'configuration.php';

const ROLE_USER = 'user';
const ROLE_ADMIN = 'admin';
const MAIL_UNVERIFIED = 0;
const MAIL_VERIFIED = 1;


function connectDB()
{
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOSTNAME;
    $user = DB_USER;
    $password = DB_PASSWORD;

    try {
        $dbh = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        throw new Exception('Connection failed: ' . $e->getMessage());
    }

    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $dbh;
}


/**
 * @todo send email after success registration, user have to confirm email
 * @todo transaction
 */
function registerWithPassword(PDO $dbh, $email, $password)
{
    $userData = [
        'email' => $email,
        'password' => \Nette\Security\Passwords::hash($password),
        'role' => ROLE_USER,
    ];

    $hash = sha1($email . time());

    $emailData = [
        'hash' => $hash,
        'verified' => MAIL_UNVERIFIED
    ];

    $sql = '
		INSERT INTO users (email, password, role)
		VALUES(:email, :password, :role)';
    $sth = $dbh->prepare($sql);
    $sth->execute($userData);

    $sql = '
		INSERT INTO users_verified_emails (hash, verified, user)
		VALUES(:hash, :verified, LAST_INSERT_ID())';
    $sth = $dbh->prepare($sql);
    $sth->execute($emailData);
}


function existsEmailInUsers(PDO $dbh, $email)
{
    $sql = '
		SELECT COUNT(id)
		FROM users
		WHERE email = :email';
    $sth = $dbh->prepare($sql);
    $sth->execute(['email' => $email]);

    return ($sth->fetch() > 0);
}


function userExists(PDO $dbh, $userId)
{
    $sql = '
		SELECT COUNT(id)
		FROM users
		WHERE id = :id';
    $sth = $dbh->prepare($sql);
    $sth->execute(['id' => $userId]);

    return ($sth->fetch() > 0);
}


function getUserInformation(PDO $dbh, $userId)
{
    $sql = '
		SELECT email, name, surname
		FROM users
		WHERE id = :id';
    $sth = $dbh->prepare($sql);
    $sth->execute(['id' => $userId]);

    return $sth->fetch();
}
