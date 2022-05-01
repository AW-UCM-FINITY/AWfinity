<?php 
namespace es\ucm\fdi\aw;
use es\ucm\fdi\aw as path;

class Contacto{
	
	protected $id_user;
    protected $nombre;
    protected $email;
    protected $consulta;
    protected $motivo;

	/* CONSTRUCTOR */
	public function __construct($nombre, $email, $consulta, $motivo, $id_consulta=NULL){
        
        
    	
            $this->id_consulta = $id_consulta;
            $this->nombre =  $nombre;
			$this->email = $email;
            $this->consulta = $consulta;
            $this->motivo = $motivo;

	}
	
    public function getIdConsulta(){
		return $this->id_consulta;
	}

	public function getNombre(){
		return $this->nombre;
	}

	

	public function getEmail(){
		return $this->email;
	}

	

	public function getConsulta(){
		return $this->consulta;
	}

	
	public function getMotivo(){
		return $this->motivo;
	}

    
    static public function crearContacto($nombre, $email, $consulta, $motivo){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $nombre= $conn->real_escape_string($nombre);
        $email= $conn->real_escape_string($email);
        $consulta= $conn->real_escape_string($consulta);
        $motivo= $conn->real_escape_string($motivo);

        $query=sprintf("INSERT INTO consulta (nombre,email,consulta,motivo) VALUES ('%s', '%s', '%s', '%s')"
        
        ,$conn->real_escape_string($nombre)
        ,$conn->real_escape_string($email)
        ,$conn->real_escape_string($consulta)
        ,$conn->real_escape_string($motivo)
        );
	
		if($conn->query($query)){
            
			$result=true;
		}else{
			$result=false;
		}

		return $result;
	}
    
    static public function getTodosContactos()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM consulta");
        $rs = $conn->query($query);
        $result = array();
        if ($rs) {
           while($fila = mysqli_fetch_assoc($rs)){
            
                $result[] = new Contacto($fila['nombre'], $fila['email'], $fila['consulta'], $fila['motivo'], $fila['id_consulta']);
                 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

   
    
    static public function elimConsultas($id_consulta){//valoracion es el nombre del comentario

        $result = false;
        $conn =  Aplicacion::getInstance()->getConexionBd();
        $id_consulta= $conn->real_escape_string($id_consulta);
      
        $sql = "DELETE FROM consulta WHERE id_consulta=$id_consulta";
        $consulta = $conn->query($sql);
        if($consulta){
            $result=true;
        }
        
        
        return $result;
	}
   

}

?>