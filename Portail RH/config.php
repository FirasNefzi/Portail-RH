<?php
class Config
{
    public static function getConnexion()
    {
        $dsn = "mysql:host=localhost;dbname=Portail_RH";
        $user = "root";
        $pw = "";
        try {
            $cnx = new PDO($dsn, $user, $pw);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $cnx;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
