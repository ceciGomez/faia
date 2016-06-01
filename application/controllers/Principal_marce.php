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
		//Obtener los datos ingresados por pantalla
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
	   		  $this->crearMatrizInicial($operando1,$operando2, $resultado, $vectorInicio);
		   	 }else{		 
		 	$this->do_alert();
		 	return;  
		 }
	}
	
	public function crearMatrizInicial($op1, $op2, $resul,$vecInicio)
	{
	
        $a = 'vector'; 
		 for($i=1; $i < 6; $i++){
		     ${$a.$i}=array('0','1', '2','3','4','5','6','7','8','9'); 
		   	 shuffle(${$a.$i});
		    
		     echo "vector".$i.": ";
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
			 echo "suma: ". $suma.'</br>';
			 $brilloInicial = $this->obtenerBrillo($valor_resul,  $suma);
			 echo "Brillo inicial: ".$brilloInicial."</br>";
			 
		 }
		 $this->aplicarAlgoritmo($vector1, $vector2, $vector3, $vector4, $vector5, $op1, $op2, $resul, $vecInicio);
	}
	
	public function aplicarAlgoritmo($vector1, $vector2, $vector3, $vector4, $vector5, $op1, $op2, $resul, $vecInicio)
	{
		//empezar con 5 iteraciones
		 $vector= 'vector'; 
		 $vecPos = 'vecPos';
		 for ($t=1; $t < 6; $t++) { 
		 		${$vecPos.$t} = array('0','0', '0','0','0','0','0','0','0','0');  
		 	}
		 
		
		for ($i=1; $i < 10; $i++) { 
			//comparar vectores
			for ($j=1; $j < 6; $j++) { 
				//comparar elemento A con todos los demas elementos
				$valor_op1_A= $this->extraerValoresPorOperando(${$vector.$j}, $op1, $vecInicio);
				$valor_op2_A= $this->extraerValoresPorOperando(${$vector.$j}, $op2, $vecInicio);
				$valor_resul_A= $this->extraerValoresPorOperando(${$vector.$j}, $resul,$vecInicio);
				$sumaA = implode('', $valor_op1_A) + implode('', $valor_op2_A);
				$brilloA = $this->obtenerBrillo($valor_resul_A,  $sumaA);
				echo "Brillo de A: ".$brilloA;				
				
				for ($k=1; $k < 6; $k++) { 
					$valor_op1_B= $this->extraerValoresPorOperando(${$vector.$k}, $op1,$vecInicio);
					$valor_op2_B= $this->extraerValoresPorOperando(${$vector.$k}, $op2,$vecInicio);
					$valor_resul_B= $this->extraerValoresPorOperando(${$vector.$k}, $resul,$vecInicio);
					$sumaB = implode('', $valor_op1_B) + implode('', $valor_op2_B);
					$brilloB = $this->obtenerBrillo($valor_resul_B,  $sumaB);
					echo "Brillo de B: ".$brilloB;
				
					if ($brilloA <= $brilloB) {
						//se calcula la distancia entre A y B y el resultado
						$distancia = $this->distancia($valor_resul_A, $valor_resul_B, $resul);
						$pos = $this->buscarPosicion(${$vector.$j}, $brilloA, $valor_op1_A, $valor_op2_A, $valor_resul_A);

						$valor_Anterior = ${$vector.$j}[$pos];
						//se mueve el menos brilloso hacia el mas brilloso
						${$vector.$j} = $this->movimiento(${$vector.$j}, ${$vector.$k}, $distancia, $pos);

						//Es el mismo vector sin valores repedios
						//${$vector.$j} = $this->controlarRepetidos(${$vector.$j}, $pos, $valor_Anterior);

						$valor_op1 = $this->extraerValoresPorOperando(${$vector.$j}, $op1, $vecInicio);
						$valor_op2 = $this->extraerValoresPorOperando(${$vector.$j}, $op2, $vecInicio);
						$valor_resul = $this->extraerValoresPorOperando(${$vector.$j}, $resul,$vecInicio);
						$suma = implode('',$valor_op1) + implode('',$valor_op2);
						//se recalcula el brillo del elemento que se movio.
						$brilloA = $this->obtenerBrillo($valor_resul,  $suma);
						echo "Vector".$j.": ";
						$this->acomodarArray(${$vector.$j});
						echo "suma: ". $suma.'</br>';
						echo "Resultado: ";
			 			$this->acomodarArray($valor_resul);
			 			echo "Nuevo brillo de A: ".$brilloA." </br>--------------</br>";
				
					} elseif ($brilloA >= count($resul)) {
						return "Se ha encontrado una solucion";
					}
				}
			} //fin comparacion vectores

		}//fin iteraciones
	}
	public function buscarPosicion($vectorOrigen, $brillo, $op1, $op2, $resul)
	{
		switch ($brillo) {
			case  0:
			$pos = 6;
			return $pos;
			break;

		case 1:
			$ul_pos_op1 = count($op1) - 1;
			$ul_pos_op2 = count($op2) - 1;
			$ul_pos_res = count($resul) - 1;

			$pos = 2;
			return $pos;
			# code...
			break;

		case 2:

			$pos = 3;
			return $pos;
			# code...
			break;

		case 3:
			$pos = 4;
			return $pos;
			# code...
			break;

		case 4:
			# code...
			break;

		case 5:
			# code...
			break;

		case  6:
			# code...
			break;
		}
	}

	public function intToArray( $x){
			$arr = array();
		    $arr = array_map('intval', str_split($x));
			return $arr;
		}
	
	public function obtenerBrillo( $x,  $y){
	  $var1=$this->intToArray($y);
	  $sum=0;
	  $i=(sizeof($var1)-1);
	  $j=(sizeof($x)-1);
	  $counter=0;
	  if(sizeof($var1)<sizeof($x)){
		$counter=sizeof($var1);}
		else{
		$counter=sizeof($x);}
	  for ($k = ($counter-1); $k >=0; $k--) {
	      if($var1[($i)]==$x[($j)]){
		 
		  $i--;
		  $j--;
	      
		 $sum++;
			}else{
			//echo "Brillo: ". $sum.'</br>';
			 //echo "-------------- <br>";
			return $sum;
			}
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
	//Funcion tentativa
	public function distancia($X1, $X2, $resultado){
		$d1 = abs(implode('', $resultado) - implode('', $X1));
		$d2 = abs(implode('', $resultado) - implode('', $X2));
		$d=abs($d1-$d2);
		return $d;
	}

	public function beta(){
		$valor_beta = 1;
		return $valor_beta;
	}

 // esta función se utiliza por elemento del vector luciernaga
	public function movimiento($X1, $X2, $distancia, $pos){
		//epsilon es un número aleatorio que varía de -1 a 1
		$epsilon = -1;

		/* alfa es un número que con el tiempo debería tender a 0, si es que nos acercamos a la solución, 
		o ser un número alto si estamos lejos de la solución */
		$alfa = 1;

		//función de movimiento
		$beta = $this->beta();
		$distancia = 3;
		$valor_a_cambiar = $X1[$pos];
		//var_dump($X1);
		echo "valor a cambiar: ".$valor_a_cambiar.", ";

		$valor_a_cambiar = $valor_a_cambiar + $beta * $distancia + $alfa*$epsilon;
		echo "valor cambiado: ".$valor_a_cambiar;
		echo "</br>";


		$valor_a_cambiar = fmod($valor_a_cambiar, 10);

		$X1=$this->controlarRepetidos($X1, $valor_a_cambiar,$X1[$pos]);

		$X1[$pos]=$valor_a_cambiar;
		//var_dump($X1);
		return $X1;

	}

	// Se busca los repetidos y se modifican
	public function controlarRepetidos($vectorEntrada, $valor_a_buscar, $valor_nuevo)
	{
		echo "VECTOR DE ENTRADAAAA: ";
		$this->acomodarArray($vectorEntrada);
		
		echo "valor a buscar: ".$valor_a_buscar;
		$posicion = array_search($valor_a_buscar, $vectorEntrada);
		echo "posicion: ".$posicion;
		echo ", valor nuevo: ".$valor_nuevo."</br>";
		$vectorEntrada[$posicion] = $valor_nuevo;
		echo " Array arreglado: ";
		$this->acomodarArray($vectorEntrada);
		return $vectorEntrada;
	}

}

/* End of file CI_Principal.php */
/* Location: ./application/controllers/CI_Principal.php */