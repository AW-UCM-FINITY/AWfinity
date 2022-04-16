<?php
namespace es\ucm\fdi\aw;
/**
 * Clase que agrupa toda la funcionalidad propia de la gestión de los usuarios.
 */

class Usuario
{

    private $id_usuario;
    private $nombreUsuario;
    private $nombre;
    private $apellido;
    private $password;
    private $rol_user;
    private $puntos;
    
    public const ADMIN_ROLE = "admin";
    public const EDIT_ROLE = "editor";
    public const USER_ROLE = "user";
    
    private const TIPOS = array(self::ADMIN_ROLE,self::EDIT_ROLE, self::USER_ROLE); 


    /** Prevent creating a new instance outside of the class via the new operator.*/
    private function __construct($nombreUsuario, $nombre, $apellido, $password, $rol_user,$puntos, $id = NULL) {
        $this->id_usuario= $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->password = $password;
        $this->rol_user = $rol_user;
        $this->puntos=$puntos;
    }
    /**Funciones get */
    public function getId() {
        return $this->id_usuario;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }
    public function getRol() {
        return $this->rol_user;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getPuntos(){
        return $this->puntos;
    }
    public function getApellido(){
        return $this->apellido;
    }

    /** Comprueba si la contraseña introducida coincide con la del Usuario.*/
    public function compruebaPassword($contrasenia){
        return password_verify($contrasenia, $this->password);
    }

    public function getAdmin(){
        return $this->rol_user == 'admin' ? true : false;
    }

    public function getEditor(){
        return $this->rol_user == 'editor' ? true : false;
    }

    public static function getRoles(){

        $arrayRol=array();
        foreach (self::TIPOS as $key => $value) {
            $arrayRol[]=$value;
        }
        return $arrayRol;
    }

    /**Fin funciones get */

    
   /* public function cambiaPassword($nuevoPassword){
        $this->password = self::hashPassword($nuevoPassword);
        $usuario = self::guarda($this);
    }*/

    /** Crea hash de la contraseña */
    private static function hashPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /** Crea un nuevo usuario con los datos introducidos por parámetro*/
    public static function crea($nombreUsuario, $nombre, $apellido, $password, $rol_user){
        $user = self::buscaUsuario($nombreUsuario);
        if ($user) {
            return false;
        }
        $user = new Usuario($nombreUsuario, $nombre, $apellido, self::hashPassword($password),$rol_user, 0);
        //$user->añadeRol($rol);
        return self::guarda($user);
    }

    public static function guarda($usuario){
        if ($usuario->id_usuario!== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }

     /** Inserta nuevo usuario en BD guarda() -> inserta() */
    private static function inserta($usuario){
        //$result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuarios(nombreUsuario, nombre, apellido, password, rol_user, puntos) VALUES ('%s', '%s', '%s', '%s', '%s', '%d')"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol_user)
            ,0
        );
        if ($conn->query($query)) {
            $usuario->id_usuario = $conn->insert_id;
            //$result = self::insertaRoles($usuario);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $usuario;
    }

    /** Actualiza el usuario existente en BD guarda() -> actualiza() */
    public static function actualiza($nombreUsuario, $nombre, $apellido, $password, $rol_user,$puntos, $id) {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE usuarios U SET nombreUsuario = '%s', nombre='%s', apellido='%s', password='%s', rol_user='%s', puntos='%s' WHERE U.id_user=%d"
            , $conn->real_escape_string($nombreUsuario)
            , $conn->real_escape_string($nombre)
            , $conn->real_escape_string($apellido)
            , self::hashPassword($conn->real_escape_string($password))
            , $conn->real_escape_string($rol_user)
            , $conn->real_escape_string($puntos)
            , $id
        );
        if ( $conn->query($query)) {
            $result = true;
            /*$result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }*/
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function actualizaRolUser($id, $rol_user){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query= "UPDATE usuarios U SET U.rol_user = '$rol_user' WHERE U.id_user=$id";
        if ( $conn->query($query) ) {
            /*$result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }*/
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }
    
    public static function borrar($id_usuario){
        if ($id_usuario!== null) {
            return self::borraPorId($id_usuario);
        }
        return false;
    }
     /**Elimina al usuario de la BD */
     private static function borra($usuario){
        return self::borraPorId($usuario->id);
    }
    
    private static function borraPorId($idUsuario){
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        //$query = sprintf("DELETE FROM usuarios U WHERE U.id_user= '%d'", $idUsuario);
        $query = "DELETE FROM usuarios WHERE id_user=$idUsuario";

        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    /** Usando las funciones anteriores, devuelve un objeto Usuario si el usuario existe y coincide su
    * contraseña. En caso contrario, devuelve false.
    */
    public static function login($nombreUsuario, $contrasenia){
        $result = false;
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($contrasenia)) {
           // return self::cargaRoles($usuario);
           $result = $usuario;
           //return $usuario;
        }
        return $result;
    }


    /** Devuelve un objeto Usuario con la información del usuario $nombreUsuario, o false si no lo encuentra*/
   /* public static function buscaUsuario($nombreUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombreUsuario ='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $p = false;
        if ($rs) {
            if($rs->num_rows == 1){ //Si no me da error 
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user']);
                //$user->id_usuario = $fila['id_usuario'];
                $p = $user;
            }
            $rs->free();

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $p;
    }*/

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombreUsuario='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user'] ,$fila['puntos'], $fila['id_user']);
                
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function getUsuariosOrdenPuntos()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios ORDER BY puntos DESC");
        $rs = $conn->query($query);
        $result = array();
        if ($rs) {
           while($fila = mysqli_fetch_assoc($rs)){
            
                $result[] = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user'],$fila['puntos'],  $fila['id_user']);
                 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function buscaPorId($idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE id_user=%d", $idUsuario);
        $rs = $conn->query($query);
        
        if ($rs) {
            $fila = $rs->fetch_assoc();
            $user = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user'],$fila['puntos'],  $fila['id_user']);
            $rs->free();

            return $user;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function buscaIDPorNombre($nombre){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE nombreUsuario='%s'", $nombre);
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            $user = $fila['id_user'];
            $rs->free();

            return $user;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function aumentarPuntos($id_usuario, $puntos){

        $conn = Aplicacion::getInstance()->getConexionBd();
        $query="UPDATE usuarios SET puntos = puntos + $puntos WHERE  id_user= $id_usuario";
    
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar los puntos de usuario.";
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
  
    public static function getTodosUsuarios()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios");
        $rs = $conn->query($query);
        $result = array();
        if ($rs) {
           while($fila = mysqli_fetch_assoc($rs)){
            
                $result[] = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user'],$fila['puntos'],  $fila['id_user']);
                 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    /*private static function insertaRoles($usuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        foreach($usuario->roles as $rol) {
            $query = sprintf("INSERT INTO RolesUsuario(usuario, rol) VALUES (%d, %d)"
                , $rol
                , $usuario->id
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
        }
        return $usuario;
    }*/
    

   /* private static function borraRoles($usuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario RU WHERE RU.usuario = %d"
            , $usuario->id
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }*/
   

}

?>