<?php 
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class Valoracion{
	
	protected $id_valoracion;
    protected $idNoticia;
    protected $idUser;
    protected $contenido;
    protected $puntuacion;

	/* CONSTRUCTOR */
	public function __construct($idNoticia, $idUser, $contenido, $puntuacion, $id_valoracion=NULL){
        
        
    	
            $this->id_valoracion = $id_valoracion;
			$this->idNoticia = $idNoticia;
            $this->idUser = $idUser;
            $this->contenido =  $contenido;
			$this->puntuacion = $puntuacion;
            
		

	}
	public function getId_valoracion(){
		return $this->id_valoracion;
	}

	

	public function getIdNoticia(){
		return $this->idNoticia;
	}

	

	public function getIdUser(){
		return $this->idUser;
	}

	

	public function getContenido(){
		return $this->contenido;
	}

	
	public function getPuntuacion(){
		return $this->puntuacion;
	}

	

	
   
    
    static public function crearComentario($idNoticia, $idUser, $contenido, $puntuacion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $idNoticia= $conn->real_escape_string($idNoticia);
        $idUser= $conn->real_escape_string($idUser);
        $contenido= $conn->real_escape_string($contenido);
        $puntuacion= $conn->real_escape_string($puntuacion);
        $query=sprintf("INSERT INTO valoraciones (idNoticia,idUser,contenido,puntuacion) VALUES ('%s', '%s', '%s', '%s')"
        
        ,$conn->real_escape_string($idNoticia)
        ,$conn->real_escape_string($idUser)
        ,$conn->real_escape_string($contenido)
        ,$conn->real_escape_string($puntuacion)
    );
		
		$reult=true;

       
        
	
		if($conn->query($query)){
            
			$reult=true;
		}else{
			$reult=false;
		}

		return $reult;
	}
    
    /*static public function getValoracion($id_valoracion){

        $valoracion = array();
        
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE id_valoracion=$id_valoracion";
        $consulta = $conn->query($sql);
        if($consulta->num_rows != 0){
            while ($fila = mysqli_fetch_assoc($consulta)){
                
                $valoracion[] = new Valoracion($fila['idNoticia'],$fila['idUser'],$fila['contenido'],$fila['puntuacion'],$fila['id_valoracion']);
                
            }

        }
        $consulta->free();
        
        return $valoracion;
	}*/
    static public function getComentarios($idnoticia){

        $valoracion = array();
        
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE idNoticia=$idnoticia";
        $consulta = $conn->query($sql);
        if($consulta->num_rows != 0){
            while ($fila = mysqli_fetch_assoc($consulta)){
                
                $valoracion[] = new Valoracion($fila['idNoticia'],$fila['idUser'],$fila['contenido'],$fila['puntuacion'],$fila['id_valoracion']);
                
            }

        }
        $consulta->free();
        
        return $valoracion;
	}
    
    static public function getpuntuaciones($id_valoracion){

        $puntuaciones = false;
        
         $conn =  Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE id_valoracion=$id_valoracion";
        $consulta = $conn->query($sql);
        if($consulta->num_rows != 0){
          
            if ($fila = mysqli_fetch_assoc($consulta)){
                $puntuaciones = $fila['puntuacion'];
                
            }

        }
        $consulta->free();
        
        return $puntuaciones;
	}
    static public function getValoracion($id_valoracion){//valoracion es el nombre del comentario

        $result = false;
        
         $conn =  Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE id_valoracion=$id_valoracion";
        $consulta = $conn->query($sql);
        if($consulta->num_rows != 0){
          
            if ($fila = mysqli_fetch_assoc($consulta)){
                $result =  new Valoracion($fila['idNoticia'],$fila['idUser'],$fila['contenido'],$fila['puntuacion'],$fila['id_valoracion']);
                
            }

        }
        $consulta->free();
        
        return $result;
	}
    static public function elimValoracion($id_valoracion){//valoracion es el nombre del comentario

        $result = false;
        $conn =  Aplicacion::getInstance()->getConexionBd();
        $id_valoracion= $conn->real_escape_string($id_valoracion);
      
        $sql = "DELETE FROM valoraciones WHERE id_valoracion=$id_valoracion";
        $consulta = $conn->query($sql);
        if($consulta){
            $result=true;
        }
        
        
        return $result;
	}
    static public function getUsuario($id_valoracion){

        $usuario = false;
        
        $conn =  Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE id_valoracion=$id_valoracion";
        $consulta = $conn->query($sql);
        if($consulta->num_rows != 0){
        
            while ($fila = mysqli_fetch_assoc($consulta)){
                $usuario= Usuario::buscaPorId($fila['idUser']);
              
            }

        }
        $consulta->free();
        
        return $usuarios;
	}

   

}

?>