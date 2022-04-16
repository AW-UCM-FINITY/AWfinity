<?php
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class FormEditorEditUsuario extends Formulario
{
    private $nombUser;
    public function __construct($nombreUser) {
        $this->nombUser=$nombreUser;
        parent::__construct('formEditar', ['urlRedireccion' => 'perfil.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        if(isset($this->nombUser)){
            //modifica el reto
            $usuer=Usuario::buscaUsuario($this->nombUser);

            $nombreUsuario = $usuer->getNombreUsuario() ?? '';
            $nombre = $usuer->getNombre() ?? '';
            $apellido = $usuer->getApellido() ?? '';
           
        }
     

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'nombre', 'apellido', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
                <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario" readonly/>
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="nombre">Apellido:</label>
                <input id="apellido" type="text" name="apellido" value="$apellido" />
                {$erroresCampos['apellido']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <button type="submit" name="registro">Editar</button>
                <button type="submit" name="cancelar">Cancelar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        if(isset($datos['registro'])){
        $this->errores = [];

       

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre tiene que tener una longitud de al menos 5 caracteres.';
        }

        $apellido = trim($datos['apellido'] ?? '');
        $apellido = filter_var($apellido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $apellido || mb_strlen($apellido) < 5 ) {
            $this->errores['apellido'] = 'El apellido tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }

        if (count($this->errores) === 0) {
           // $usuario = path\Usuario::buscaUsuario($nombreUsuario);
          $usuer= $usuer=Usuario::buscaUsuario($this->nombUser);
	       $val=Usuario::actualiza($usuer->getNombreUsuario(), $nombre, $apellido,  $password, $usuer->getRol(), $usuer->getPuntos(), $usuer->getId());
            if (!$val) {
                $this->errores[] = "El usuario no se pudo actualizar";
            } 
        }
    }
}
}