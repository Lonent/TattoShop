<?php
$host = 'mlkvmh1q.beget.tech';
$dbname = 'mlkvmh1q_tatto';
$user = 'mlkvmh1q_tatto';
$pass = 'tattoPASSWORD1';

try {
  $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Error connecting to database: " . $e->getMessage();
  die();
}
?>
