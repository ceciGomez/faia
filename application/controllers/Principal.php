<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function index()
	{
		
	}
	public function ingresar(){
		$this->load->view('ingresarDatos');
	}
	 public function do_alert() 
    {
        echo '<script type="text/javascript">alert("' . "Ha excedido el número de caracteres permitidos" . '"); </script>';
    }
	public function ingresarDatos(){
		$operando1 = $this->input->post('op1');
		$operando2 = $this->input->post('op2');
		$resultado = $this->input->post('res');

		//la funcion str_split divide en elementos y lo pone en un arreglo
		//la funcion array_reverse da vuelta el array
		$operando1 = str_split($operando1);
		$operando1 = array_reverse($operando1);
		$operando2 = str_split($operando2);
		$operando2 = array_reverse($operando2);
		$resultado = str_split($resultado);
		$resultado = array_reverse($resultado);

		$vectorInicio = array_merge($resultado,$operando2,$operando1);
		//Elimna los elementos repetidos
		$vectorInicio = array_unique($vectorInicio);
		//Elimina las posiciones vacias
		$vectorInicio = array_values( $vectorInicio );
		if (count($vectorInicio)<= 10){

		  //rellenar con guiones las demas posiciones del array hasta completar 10.
			$posiciones = count($vectorInicio);
			//var_dump($posiciones);
			$posFaltantes= 10 - $posiciones;
			//var_dump($posFaltantes);
		  for ($i= 1; $i <= $posFaltantes; $i++) { 
		  	array_push($vectorInicio, '-');
		  }
		  echo "<br> Vector Inicio: ";
		  var_dump(count($vectorInicio));


		  $this->acomodarArray($vectorInicio);
   			 $this->crearMatrizInicial($operando1,$operando2,$resultado, $vectorInicio);
		   }else{		 
		 $this->do_alert();
		 return;  }
	}
	
	public function crearMatrizInicial($op1, $op2, $resul,$vecInicio)
	{
	
        /*$vector1 = array('0','1', '2','3','4','5','6','7','8','9');
        $vector2 = array('0','1', '2','3','4','5','6','7','8','9');
        $vector3 = array('0','1', '2','3','4','5','6','7','8','9');
        $vector4 = array('0','1', '2','3','4','5','6','7','8','9');
        $vector5 = array('0','1', '2','3','4','5','6','7','8','9');
        shuffle($vector1);
        shuffle($vector2);
        shuffle($vector3);
        shuffle($vector4);
        shuffle($vector5);
         $this->acomodarArray($vector1);
		 $this->acomodarArray($vector2);
		 $this->acomodarArray($vector3);
		 $this->acomodarArray($vector4);
		 $this->acomodarArray($vector5);
		*/ $a = 'vector'; 
		 for($i=1; $i < 6; $i++){
		   ${$a.$i}=array('0','1', '2','3','4','5','6','7','8','9'); 
		   shuffle(${$a.$i});
		    
		    echo "<br> -------------- <br>";
		    echo implode('', (${$a.$i}));
		   
		 $valor_op1= $this->extraerValoresPorOperando(${$a.$i}, $op1,$vecInicio);
		 $valor_op2= $this->extraerValoresPorOperando(${$a.$i}, $op2,$vecInicio);
		 $valor_resul= $this->extraerValoresPorOperando(${$a.$i}, $resul,$vecInicio);
		 echo "<br> -------------- <br>";
		 echo "Op 1: ";
		 
		 $this->acomodarArray($valor_op1);
		 //echo "<br>";
		 echo "Op 2: ";
		  $this->acomodarArray($valor_op2);
		 //echo "<br>";
		 echo "Resultado";
		 $this->acomodarArray($valor_resul);
		 //echo "<br>";
		 $suma = implode('',$valor_op1) + implode('',$valor_op2);
		 echo "suma: ". $suma .'</br>';
		 //var_dump($suma);
		 
		 }
	}
	//Funcion para mostrar como matriz.
	public function acomodarArray(array $id){
	   $output = array();
           foreach ($id as $vectorInicio =>$a) {
           foreach ((array)$a as $key => $value) {
             $output[$key][] = $value; 
           }
      }
       foreach ($output as $o) {
            echo '<tr><td>' . implode('</td><td>', $o) . '</td></tr>'."<br/>";
	        }
	}
	public function extraerValoresPorOperando($vector, $operando, $vecInicio)	
	{

		$operando = array_reverse($operando);
		$op1_val = array();
		for ($i=0; $i < count($operando) ; $i++) { 
			$pos = array_search($operando[$i], $vecInicio, true);			
			//extrae los valores del vector pasado como "vector" y que coincidan 
			//con el operador 1.
			$operando_val[] = $vector[$pos];

		}
			return $operando_val;
	}

}

/* End of file CI_Principal.php */
/* Location: ./application/controllers/CI_Principal.php */