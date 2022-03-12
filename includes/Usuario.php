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
    
    public const ADMIN_ROLE = "admin";
    public const EDIT_ROLE = "editor";
    public const USER_ROLE = "user";
    
    private const TIPOS = array(self::ADMIN_ROLE,self::EDIT_ROLE, self::USER_ROLE); 


    /** Prevent creating a new instance outside of the class via the new operator.*/
    private function __construct($nombreUsuario, $nombre, $apellido, $password, $rol_user) {
        //$this->id_usuario= $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->password = $password;
        $this->rol_user = $rol_user;
    }
    /**Funciones get */
    public function getId() {
        return $this->id_usuario;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    /** Comprueba si la contraseña introducida coincide con la del Usuario.*/
    public function compruebaPassword($contrasenia){
        return password_verify($contrasenia, $this->password);
    }

    /*public function getRoles(){
        $arrayRoles = array();
        foreach(self::TIPOS as $i => $rol_user){
            $arrayRoles[] = $rol_user;
        }
        return $arrayRoles;
    }*/
    public function getAdmin(){
        return $this->rol_user == 'admin' ? true : false;
    }

    public function getEditor(){
        return $this->rol_user == 'editor' ? true : false;
    }

    /**Fin funciones get */

  /*  public function nuevoRol($role){ //Añade un nuevo rol
        $this->roles[] = $role;
    }*/


    /*public function tieneRol($role){
        if ($this->role_user == null) {
            self::cargaRoles($this);
        }
        return array_search($role, $this->roles) !== false;
    }*/
   /* private static function cargaRoles($usuario){
        $roles=[];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d", $usuario->id);
        $rs = $conn->query($query);
        if ($rs) {
            $roles = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $usuario->roles = [];
            foreach($roles as $rol) {
                $usuario->roles[] = $rol['rol'];
            }
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }*/

    
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
        $user = new Usuario($nombreUsuario, $nombre, $apellido, self::hashPassword($password), $rol_user);
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
        $query=sprintf("INSERT INTO usuarios(nombreUsuario, nombre, apellido, password, rol_user) VALUES ('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol_user)
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
    private static function actualiza($usuario){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE usuarios U SET nombreUsuario = '%s', nombre='%s', apellido='%s', password='%s', rol_user='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol_user)
            , $usuario->id
        );
        if ( $conn->query($query)) {
            /*$result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }*/
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $usuario;
    }
    public function actualizaRolUser($id, $rol_user){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE usuarios U SET rol_user = 'rol_user' WHERE U.id=$id");
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
    
    public function borrar($usuario){
        if ($usuario->id_usuario!== null) {
            return self::borra($this);
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
        $query = sprintf("DELETE FROM usuarios U WHERE U.id_usuario= %d"
            , $idUsuario
        );
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
                $result = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user']);
                
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE id=%d", $idUsuario);
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            $user = new Usuario($fila['nombreUsuario'], $fila['nombre'], $fila['apellido'], $fila['password'], $fila['rol_user']);
            $rs->free();

            return $user;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
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