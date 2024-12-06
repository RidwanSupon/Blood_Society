<?php
$host = 'localhost';       
$db   = 'blood_bank';      
$user = 'root';            
$password = '';            

try {
    
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
