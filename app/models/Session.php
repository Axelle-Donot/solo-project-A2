<?php

class Session
{
    public static function initSession(): void
    {
        session_start();
        // création du tableau user
        if (!isset($_SESSION['user'])) {
            echo "création du tableau user<br>";
            $_SESSION['user'] = array();
            // Création variable connexion user->isLogged
            if (!isset($_SESSION['user']['isLogged']))
                $_SESSION['user']['isLogged'] = false;
            else
                echo "isLogged déjà créé<br>";
            // Création variable identification user->userId
            if (!isset($_SESSION['user']['userId']))
                $_SESSION['user']['userId'] = "";
            else
                echo "isLogged déjà créé<br>";

        } else {
            //echo "tableau user déjà créé<br>";
        }
        // Création du tableau du panier
        if (!isset($_SESSION['cart'])) {
            //echo "création cart session<br>";
            $_SESSION['cart'] = array();
            // Création variable product_id cart->product_id
            if(!isset($_SESSION['cart']['product_id'])){
                $_SESSION['cart']['product_id'] = array();
            }
            // Création variable quantity cart->quantity
            if(!isset($_SESSION['cart']['quantity'])){
                $_SESSION['cart']['quantity'] = array();
            }
        } else {
            //echo "cart session déjà créé<br>";
        }
    }

    public static function isConnected(): bool
    {
        return $_SESSION['user']['isLogged'];
    }

    public static function changeToConnected(): void
    {
        $_SESSION['user']['isLogged'] = true;
    }

    public static function changeToDisconnected(): void
    {
        $_SESSION['user']['isLogged'] = false;
    }

    public static function getUserId(): string
    {
        return $_SESSION['user']['userId'];
    }

    public static function updateUserId(string $userId): void
    {
        $_SESSION['user']['userId'] = $userId;
    }

    public static function addProduct($product_id): void
    {
        //True si le produit est présent
        $positionProduct = array_search($product_id, $_SESSION['cart']['product_id']);
        if($positionProduct){
            $_SESSION['cart']['quantity'][$positionProduct] += 1;
        }
        else{
            array_push($_SESSION['cart']['product_id'], $product_id);
            array_push($_SESSION['cart']['quantity'], 1);
        }
    }
}