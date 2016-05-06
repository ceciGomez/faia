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
		if (count($vectorInicio)< 10){
		    for ($i = 8; $i<10; $i++) {
             array_push($vectorInicio, '-');
		}
		  $this->acomodarArray($vectorInicio);
   			 $this->crearMatrizInicial();
		   }else{		 
		 $this->do_alert();
		 return;  }
	}
	
	public function crearMatrizInicial()
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
	}
	
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

}

/* End of file CI_Principal.php */
/* Location: ./application/controllers/CI_Principal.php */