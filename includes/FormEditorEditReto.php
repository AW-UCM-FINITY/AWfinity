<?php
namespace es\ucm\fdi\aw;

class FormEditorEditReto extends Formulario
{
    private $id_Reto;

    public function __construct($id_Reto) {
        // en funcion de si le esta pasando el id de la reto, va a ser crear o modificar
        $this->id_Reto = $id_Reto;
        
        if(isset($this->id_Reto)){    //si existe el id -> actualizamos
            $urll='retoVista.php?nombreid='.$this->id_Reto;
            parent::__construct('FormEditorEditReto', ['enctype' => 'multipart/form-data','urlRedireccion' => $urll]);  //por ahora queda mas claro asi
        }
        else{   //sino -> creamos
            parent::__construct('FormEditorCreaReto', ['enctype' => 'multipart/form-data','urlRedireccion' =>  'reto.php']);
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
            $puntos = $reto->getPuntos() ?? '';
        }
        else{
            // crea la reto
            $nombre = $datos['nombre'] ?? '';
            $num_usuarios = $datos['num_usuarios'] ?? '';
            $num_completado = $datos['num_completado'] ?? '';
            $dificultad = $datos['dificultad'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $dias = $datos['dias'] ?? '';
            $puntos = $datos['puntos']?? ''; 
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
                <label for="nombre">nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>

            <div>
                <label for="descripcion">descripcion:</label>
                <textarea rows=5 cols=50 name="descripcion" required>{$descripcion}</textarea>
                {$erroresCampos['descripcion']}
            </div>
            
            $selectDificultad 

            <div>
                <label for="dias">dias (1-30):</label>
                <input id="dias" type="number" name="dias" value="$dias" min="1" max="30"/>
                {$erroresCampos['dias']}
            </div>

            <div>
            <label for="puntos">puntos (5-100):</label>
            <input id="puntos" type="range" name="puntos" value="$puntos" min="5" max="100"/>
            {$erroresCampos['puntos']}
            </div>

            

            <div>
            <label for="num_usuarios">num_usuarios: "$num_usuarios"</label>
            </div>
            <div>
            <label for="num_completado">num_completado: "$num_completado"</label>
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
        if ( ! $nombre || mb_strlen($nombre) < 5) {
            $this->errores['nombre'] = 'El nombre de reto tiene que tener una longitud de al menos 5 caracteres.';
        }


        $descripcion = trim($datos['descripcion'] ?? '');
        if ( empty( $descripcion)) {
            $this->errores['descripcion'] = 'La descripcion no puede ser vacio';//para empezar lo dejamos asi, mas tarde en otra tabla
        }

       
       
        
    }
}