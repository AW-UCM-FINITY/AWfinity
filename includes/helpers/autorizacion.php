<?php

function estaLogado(){
    return isset($_SESSION['login']) && ($_SESSION['esEditor']==true);
}

function esEditor(){
    return estaLogado() && isset($_SESSION['esEditor']) && ($_SESSION['esEditor']==true);
}

function esAdmin(){
    return estaLogado() && isset($_SESSION['esAdmin']) && ($_SESSION['esAdmin']==true);
}


