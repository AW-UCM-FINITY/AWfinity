<?php
namespace es\ucm\fdi\aw;

class FormEditorEditReto extends Formulario
{
    private $id_Reto;

    public function __construct($id_Retoo) {
        // en funcion de si le esta pasando el id de la reto, va a ser crear o modificar
        $this->id_Reto = $id_Retoo;
        
        if(isset($this->id_Reto)){    //si existe el id -> actualizamos
            $urll='retoSingVist.php?retoid='.$this->id_Reto;
            parent::__construct('FormEditorEditReto', ['enctype' => 'multipart/form-data','urlRedireccion' => $urll]);  //por ahora queda mas claro asi
        }
        else{   //sino -> creamos
            parent::__construct('FormEditorCreaReto', ['enctype' => 'multipart/form-data','urlRedireccion' =>  'retoVista.php']);
        }
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        if(isset($this->id_Reto)){
            //modifica el reto
            $reto=Reto::buscarPorId($this->id_Reto);

            $nombre = $reto->getNombre() ?? '';
            $num_usuarios = $reto->getNumMiembros() ?? '';
            $num_completado = $reto->getNumCompletado() ?? '';
            $dificultad = $reto->getDificultad() ?? '';
            $descripcion = $reto->getDescripcion() ?? '';
            $dias = $reto->getDias() ?? '';
            $puntos = $reto->getPuntos() ?? '5';
        }
        else{
            // crea la reto
            $nombre = $datos['nombre'] ?? '';
            $num_usuarios = $datos['num_usuarios'] ?? '0';
            $num_completado = $datos['num_completado'] ?? '0';
            $dificultad = $datos['dificultad'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $dias = $datos['dias'] ?? '1';
            $puntos = $datos['puntos']?? '5'; 
        }
        //dias
        $dificultades = Reto::getdificultades();
        $selectDificultad = "<select class='reto_dificultad' name=dificultad>" ;
        
        foreach ($dificultades as $key => $value) {
            if($value == $dificultad){
                $selectDificultad.="<option selected> $value </option> ";
            }
            else{
                $selectDificultad.="<option> $value </option> ";
            }
        } 
            $selectDificultad.="</select>";

        
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'descripcion','dias', 'puntos'], $this->errores, 'span', array('class' => 'error'));

        if(isset($this->id_Reto)){
            $funcionalidad = "modificación";
            $textoBoton = "modificar";
        } 
        else{
            $funcionalidad = "creación";
            $textoBoton = "crear";
        } 

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para la {$funcionalidad} de reto</legend>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>

            <div>
                <label for="descripcion">Descripcion:</label>
                <textarea rows=5 cols=50 name="descripcion" required>{$descripcion}</textarea>
                {$erroresCampos['descripcion']}
            </div>
            
            <div>
                <label for="dificultad">Dificultad:</label>
                {$selectDificultad} 

            </div>
            <div>
                <label for="dias">Dias (1-30):</label>
                <input id="dias" type="number" name="dias" value="$dias" min="1" max="30"/>
                {$erroresCampos['dias']}
            </div>

            <div>
            <label for="puntos">Puntos (5-100):</label>
            <input id="puntos" type="range" name="puntos" value="$puntos" min="5" max="50" oninput="puntosout.value = puntos.value"/>
            <output name="puntosout" id="puntosout">$puntos</output>
            {$erroresCampos['puntos']}
            </div>

            

            <div>
            <label for="num_usuarios">Han aceptado este reto: {$num_usuarios} personas</label>
            </div>
            <div>
            <label for="num_completado">Han completado este reto: {$num_completado} personas</label>
            </div>

            <div>
                <button type="submit" name="registro">{$textoBoton}</button>
            </div>
            </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombre || mb_strlen($nombre) < 1) {
            $this->errores['nombre'] = 'El nombre de reto tiene que tener una longitud de al menos 5 caracteres.';
        }


        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion  = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty( $descripcion)) {
            $this->errores['descripcion'] = 'La descripcion no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        }

       
        $num_usuarios =trim( $datos['num_usuarios'] ?? '0');
        

        $num_completado =trim( $datos['num_completado'] ?? '0');
        

        
        $dificultad = trim($datos['dificultad'] ?? '');
        $dificultad  = filter_var($dificultad, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $dias = trim($datos['dias'] ?? '1');
        $dias  = filter_var($dias, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($dias<1){
            $this->errores['dias'] = 'El dia no puede ser menor que 1';//para empezar lo dejamos asi, mas tarde en otra tabla
  
        }

        $puntos = $puntos['puntos']?? '5'; 
        $puntos  = filter_var($puntos, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($puntos<5){
            $this->errores['puntos'] = 'Los puntos no pueden ser menores que 5';//para empezar lo dejamos asi, mas tarde en otra tabla
  
        }
 
        if (count($this->errores) === 0) {
            
                    if(isset($this->id_Reto)){//existe
                        $reto=  Reto::actualiza($nombre, $num_usuarios, $num_completado, $dificultad, $descripcion, $dias, $puntos, $this->id_Reto);
                    }
                    else{//no existe 
                        $reto=Reto::crea($nombre, $num_usuarios, $num_completado, $dificultad, $descripcion, $dias, $puntos);
                        if(!$reto){
                            $this->errores['nombre'] =  "Error ya existe un reto con ese nombre";
                        }
                    }
                   
                 
            
           
        }else{
            $this->errores['nombre'] =  "Error de crea/edita";
        }  
       return null; 
    }
}