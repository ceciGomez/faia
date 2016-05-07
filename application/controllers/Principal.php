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

		$operando1 = str_split($operando1);
		$operando1 = array_reverse($operando1);
		$operando2 = str_split($operando2);
		$operando2 = array_reverse($operando2);
		$resultado = str_split($resultado);
		$resultado = array_reverse($resultado);

		$vectorInicio = array_merge($resultado,$operando2,$operando1);
		$vectorInicio = array_unique($vectorInicio);
		$vectorInicio = array_values( $vectorInicio );
		if (count($vectorInicio)<= 10){

		  //rellenar con guiones las demas posiciones del array hasta completar 10.
			$posiciones = count($vectorInicio);
			var_dump($posiciones);
			$posFaltantes= 10 - $posiciones;
			var_dump($posFaltantes);
		  for ($i= 1; $i <= $posFaltantes; $i++) { 
		  	array_push($vectorInicio, '-');
		  }
		  var_dump(count($vectorInicio));

		  $this->acomodarArray($vectorInicio);
   			 $this->crearMatrizInicial($operando1,$operando2,$resultado, $vectorInicio);
		   }else{		 
		 $this->do_alert();
		 return;  }
	}
	
	public function crearMatrizInicial($op1, $op2, $resul,$vecInicio)
	{
	
        $vector1 = array('0','1', '2','3','4','5','6','7','8','9');
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
		 
		 $this->extraerValoresPorArray($vector1, $op1,$op2,$resul, $vecInicio);
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
	public function extraerValoresPorArray($vector, $op1, $op2, $resul,$vecInicio)	
	{
		$op1 = array_reverse($op1);
		$vectorFinal = '5';
		for ($i=0; $i < count($op1) ; $i++) { 
			$pos = array_search($op1[$i], $vecInicio, true);
			echo "vector inicio: ";
			var_dump(count($vecInicio));
			echo "<br>";
			echo "pos: ";
			var_dump($op1[$i]) ;var_dump($pos); var_dump($vecInicio[$pos]);
			echo "<br>";
			$vectorFinal = array_push($vectorFinal,$vector[$pos]);
			var_dump($vectorFinal);
		}
		
	}

}

/* End of file CI_Principal.php */
/* Location: ./application/controllers/CI_Principal.php */