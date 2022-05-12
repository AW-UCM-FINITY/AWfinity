<?php

//funcion para generar el panel de cada miembro
function htmlMiembros($nombre, $rutaImagen, $alt, $correo, $descripcion, $debilidad, $rutaImg, $alt2, $gema){
    $miembro = <<< EOS
    <div class="miembros-box-item">
    <div class="miembros-top">
        <h2>$nombre</h2>
        <img class="a" src=$rutaImagen alt="$alt" />
    </div>
    <div class="miembros-list">
        <ul>
            <li class="correo"> Email <span>$correo</span></li>
            <li> Descripción

            <p>$descripcion 
            </p></li>
            <li> Debilidad <span>$debilidad</span></li>
            <li class="rol"> Rol en el equipo <img src=$rutaImg alt="$alt2" /><span>$gema</span></li>
        </ul>
    </div>                   
    </div>
    EOS;
    return $miembro;
}


