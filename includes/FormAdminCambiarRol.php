<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormAdminCambiarRol extends Formulario
{
    private $nombUser;
    public function __construct($nombreUser) {
        $this->nombUser=$nombreUser;
        parent::__construct('FormAdminCambiarRol', ['urlRedireccion' => 'vistaAdminGestionUser.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        if(isset($this->nombUser)){
            
            $usuer=Usuario::buscaUsuario($this->nombUser);
            $id_usuario = $usuer->getId() ?? '';
            $nombreUsuario = $usuer->getNombreUsuario() ?? '';
            $nombre = $usuer->getNombre() ?? '';
            $apellido = $usuer->getApellido() ?? '';
            $rol = $usuer->getRol() ?? '';
        }
     
        $roles = Usuario::getRoles();
        $selectRoles = "<select class='usuario_roles' name=roles>" ;
        
        foreach ($roles as $key => $value) {
            if($value == $rol){
                $selectRoles.="<option selected> $value </option> ";
            }
            else{
                $selectRoles.="<option> $value </option> ";
            }
        } 
        $selectRoles.="</select>";


        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['rol'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Cambio de rol</legend>

            <input type="hidden" name="id_user" value="$id_usuario" />
            <div>
                <label for="nombreUsuario">Usuario: $nombreUsuario</label>
            </div>
            <div>
                <label for="nombre">Nombre: $nombre</label>
            </div>
            <div>
                <label for="nombre">Apellido: $apellido</label>
            </div>
            <div>
            <label for="nombre">Rol actual: $rol</label>
            <input type="hidden" name="rol_actual" value="$rol" />
            </div>
            <div>
                <label for="roles">Actualizar a : </label>
                {$selectRoles}
                {$erroresCampos['rol']} 
            </div>

            <div>
                <button type="submit" name="registro">Actualizar</button>
                <button type="submit" name="cancelar">Cancelar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        
        if (isset($datos['registro'])) {
            $this->errores = [];
            if ( $datos['roles'] === $datos['rol_actual']) {
                $this->errores['rol'] = 'Por favor, seleccione un rol diferente al actual.';
            }
            else{
                Usuario::actualizaRolUser($datos['id_user'], $datos['roles']);
            }
        }
    }
}