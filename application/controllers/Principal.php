<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller 
{

	function __construct() {
		parent::__construct();

		// Load url helper
		$this->load->helper('url');
	}

	public function index()
	{
		
	}

	public function ingresar()
	{
		$this->load->view('ingresarDatos');
	}
		public function mostrarResul ()
	{
		
		$data['brilloMayor'] = null;
		$data['bandera'] = "";
		$data["vecinicio"] = "";
		$data["operando1"] = "";
		$data["operando2"] = "";
		$data["resultado"] = "";
		//$this->load->view('mostrarResultado', $data);
		
		$probarDeNuevo = 1;
		
		$this-> main($probarDeNuevo);
	}//FIN MOSTRAR RESULTADOS

	public function main($probarDeNuevo)
	{
		set_time_limit (60);
		if ($probarDeNuevo <200) {
			
			echo "prueba n°: ".$probarDeNuevo.'. ';
	
			$datosIniciales = $this->ingresarDatos();
			$vectorInicio = $datosIniciales['vectorInicio'];
			$vecCompleto = $datosIniciales['vecCompleto'];
			$operador = $datosIniciales['operador'];
			$cant_iteraciones = $datosIniciales['cant_iteraciones'];
			$poblacionInicial = $datosIniciales['poblacionInicial'];

			$operando1 = $datosIniciales['operando1'];
			$operando2 = $datosIniciales['operando2'];
			$resultado = $datosIniciales['resultado'];

			//$atractividad = $this->atractividad ($vectorInicio, $operando1, $operando2, $resultado);
			//	$this->acomodarArray($vectorInicio);
		    //Luciernagas es un vector de la poblacion inicial.
		    //echo "crar bichitos";
		    $luciernagas = $this->crearMatrizInicial($poblacionInicial);
		    //echo "entrar a ";
		   
		 	$this->aplicarAlgoritmo($luciernagas,$operador, $operando1, $operando2, $resultado, $vectorInicio, $vecCompleto, $cant_iteraciones, $probarDeNuevo);
	
	 	
		} else {
			echo "no se encuentra solucion";
			$data['bandera'] = false;
			$this->load->view('mostrarResultado', $data);
		}
	}//FIN FUNCION MAIN

	public function ingresarDatos()
	{
		//Este vector contiene todos los elementos ingresados, sin eliminar los repetidos
		$vecCompleto;
        //Este vector contiene todos los elementos pero sin repetir
		$vectorInicio;
		//Obtener los datos ingresados por pantalla
		$operador = $_POST["prop"];

		if ($operador =='-') {
			$operando1 = $this->input->post('res');
			$operando2 = $this->input->post('op2');
			$resultado = $this->input->post('op1');
		}else{
			$operando1 = $this->input->post('op1');
			$operando2 = $this->input->post('op2');
			$resultado = $this->input->post('res');
		}
		
		$poblacionInicial = $this->input->post('poblacion');
		$cant_iteraciones = $this->input->post('cant_iteraciones');
		
		//la funcion str_split divide en elementos y lo pone en un arreglo
		//la funcion array_reverse da vuelta el array
		$operando1 = str_split($operando1);
		$operando1 = array_reverse($operando1);
		$operando2 = str_split($operando2);
		$operando2 = array_reverse($operando2);
		$resultado = str_split($resultado);
		$resultado = array_reverse($resultado);
		$vecCompleto=$this->acomodarVectorInicio($operando1, $operando2, $resultado);
        //Elimna los elementos repetidos
		$vectorInicio = array_unique($vecCompleto);
		//Elimina las posiciones vacias
		$vectorInicio = array_values( $vectorInicio );
		//controlo si la cantidad sin repetir no superan las 10, sino muestro un mensaje de alerta
		if (count($vectorInicio)<= 10)
		{
			  //rellenar con guiones las demas posiciones del array hasta completar 10.
				$posiciones = count($vectorInicio);
				//var_dump($posiciones);
				$posFaltantes= 10 - $posiciones;
				//var_dump($posFaltantes);
			  for ($i= 1; $i <= $posFaltantes; $i++) { 
			  	array_push($vectorInicio, '-');
	    }
			 
		}else{
		   	 //se va a mostrar una alerta cuando se ingresen mas de 10 letras diferentes
		   	 $this->do_alert();
		 	 return;  
		 }
		$datosIniciales = array('vectorInicio' => $vectorInicio,
								'vecCompleto' => $vecCompleto,
								'operando1' => $operando1,
								'operando2' => $operando2,
								'resultado' => $resultado,
								'operador' => $operador,
								'poblacionInicial' =>$poblacionInicial,
								'cant_iteraciones'=>$cant_iteraciones);
		return $datosIniciales;
	} // FIN INGRESAR DATOS
		/*La funcion acomodar vector inicio lo ordena de acuerdo a las
	unidades, decenas centas */

    /*La funcion acomodar vector inicio lo ordena de acuerdo a las
	unidades, decenas centenas */
	public function acomodarVectorInicio($operando1, $operando2, $resultado)
	{
		$vectorInicio=array();
	    $totalElementos = count(array_merge($resultado, $operando2, $operando1));
        $index=max(count($operando1),count($operando2),count($resultado));
           for ($i=0; $i < $index; $i++) { 
             	if(isset($operando1[$i])){
            		$vectorInicio[]=$operando1[$i];	
            	}            	          	
            	if(isset($operando2[$i])){
            		$vectorInicio[]=$operando2[$i];	
            		            	}
            	if(isset($resultado[$i])){
            		$vectorInicio[]=$resultado[$i];	
            	}
            }
          return $vectorInicio;
	}// fin de acomodar vector inicio

	
	//Funcion para mostrar como matriz.
	public function acomodarArray(array $id)
	{
	   $output = array();
       foreach ($id as $vectorInicio =>$a) 
       {
           foreach ((array)$a as $key => $value) 
           {
             $output[$key][] = $value; 
           }
 		 }
       foreach ($output as $o) 
       {
           echo '<tr><td>' . implode('</td><td>', $o) . '</td></tr>'."<br/>";
	    }
	}//fin de acomodar array

	public function atractividad ($vector_letras, $operando1, $operando2, $resultado)
	{
		// Así debería quedar el vector para SEND+MORE=MONEY $atractividad= array(1,1,1,2,2,3,4,4,100,100);

		//Inicializo el vector atractividad
		for ($i=0; $i < 10 ; $i++) { 
			$atractividad[$i]=0;
		}

		//Para que comience el while, el final de los vectores $operando1, $operando2, $resultado debe ser FALSE
		$fin_op1 = false;
		$fin_op2 = false;
		$fin_res = false;
		$i=0;
		while ((!$fin_op1)or(!$fin_op2)or(!$fin_res)) {
			//Operando1
			if (sizeof($operando1)>$i) {
				$pos = array_search($operando1[$i], $vector_letras);
				if ($atractividad[$pos]==0) {
					$atractividad[$pos]= $i+1;
				}
			}else{
				$fin_op1 = true;
			}

			//Operando2
			if (sizeof($operando2)>$i) {
				$pos = array_search($operando2[$i], $vector_letras);
				if ($atractividad[$pos]==0) {
					$atractividad[$pos]= $i+1;
				}
			}else{
				$fin_op2 = true;
			}

			//Operando1
			if (sizeof($resultado)>$i) {
				$pos = array_search($resultado[$i], $vector_letras);
				if ($atractividad[$pos]==0) {
					$atractividad[$pos]= $i+1;
				}
			}else{
				$fin_res = true;
			}

			$i=$i+1;
			
		}

		//Donde el Vector Letras tiene un guión, completo atractividad con valor 100
		for ($i=0; $i < 10 ; $i++) { 
			if ($vector_letras[$i]=='-') {
				$atractividad[$i] = 100;
			}
		}
		//echo "</BR>atractividad: ";
		var_dump($atractividad);
		return $atractividad;
	}//FIN ATRACTIVIDAD

	/*Se cran la poblacion inicial con la que se va a trabajar en el resto del 
	algoritmo */
	public function crearMatrizInicial($poblacionInicial)
	{ 
	 //Cantidad total de luciérnagas
        $n = $poblacionInicial;
        for($i=1; $i <=$n; $i++)
        {
        	//se crea el array
		    $luciernagas[$i]=array('0','1', '2','3','4','5','6','7','8','9'); 
		    //se lo mezcla al array creado
		   	shuffle($luciernagas[$i]);
		}
		return $luciernagas;	
	} //FIN CREAR MATRIZ INICIAL
    
    //aplicar restricciones a la poblacion inciial
    public function aplicarRestricciones($luciernagas)
    {
    	return $luciernagas;
    }


    public function intToArray($x)
	{
			$arr = array();
		    $arr = array_map('intval', str_split($x));
			return $arr;
	}//fin de int to array

    //Obtengo el brillo de cada luciernaga
	public function obtenerBrillo( $suma,  $resultado)
	{	
		$res=$this->intToArray($resultado);
		
		$sum=0;
		$i=(sizeof($res)-1);
		$j=(sizeof($suma)-1);
		$counter=0;
		if(sizeof($res)<sizeof($suma)){
			$counter=sizeof($res);
		}else{
			$counter=sizeof($suma);
		}

		for ($k = ($counter-1); $k >=0; $k--) {
		    if($res[($i)]==$suma[($j)]){			 
			    $i--;
			    $j--;		      
			    $sum++;
			}
		}
		return $sum;	
	}//FIN OBTENER BRILLO

	/*Funcion distancia 
	Calcula la distancia entre dos luciernagas, comparando elemento a elemento
	y cuanta mas alta la posicion del vector mayor sera la distancia*/
	public function distancia($X1, $X2)
	{
		$i = count($X1);
		$d = 0;
		for ($j=0; $j < $i; $j++) { 
			if ($X1[$j] != $X2[$j]) {
				$d = $d + 2*$j+1;
			}
		}
		//var_dump('<br> resultado 1:' ,$X1,'<br> resultado 2: ', $X2);
		//$d = fmod($d, 10);
		//echo "</br>DISTANCIA: ".$d;
		return $d;
	}//FIN DISTANCIA

	public function controlarRepetidos($vectorEntrada, $valor_a_buscar, $valor)
	{		
		//$this->acomodarArray($vectorEntrada);		
		$posicion = array_search($valor_a_buscar, $vectorEntrada);	
		$vectorEntrada[$posicion] = $valor;
		//$this->acomodarArray($vectorEntrada);
		return $vectorEntrada;
	}//fin de controlar repetidos

	public function movimiento($X1, $distancia, $pos)
	{//Funcion movimiento
		//echo "</br> <b> EMPIEZA MOVIMIENTO </b>";
		$beta_cero = 1;
		$e = 2.718281828; 
		$gamma = 1;
		//Beta cero es la atractividad
		$beta = $beta_cero* $e^(-1)*($distancia);
		$epsilon = 1;
		$alfa = rand(0,1);
		$r2 = $distancia;
		$er2 = $r2* $e;

		//utilizando la funcion del paper otorgado.
		$elementoActual = $X1[$pos];
		$elementoNuevo=$X1[$pos] +(1- $beta) + $alfa*$epsilon;
		$elementoNuevo = fmod($elementoNuevo, 10);
		if ($elementoNuevo >= 0 and $elementoNuevo <10) {
			$X1 = $this->controlarRepetidos($X1, $elementoNuevo, $elementoActual);
			$X1[$pos] = (string)$elementoNuevo;
		}else{
			$X1[$pos] = $elementoActual;
		}
		return $X1;
	}//FIN MOVIMIENTO
	
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
	}// fin de extraer valores por operando

	public function calcularPosicion ($cotaSuperior, $vecComp) 
	{
           $maxPos=$cotaSuperior;
           $cotaFor=$maxPos-1;
           $vecCompleto=$vecComp;
           $pos=3;
           for ($i=0 ; $i < 2 ; $i++ ) { 
           	  for ($j=$cotaSuperior-2; $j <= $cotaFor; $j++) {
                	 if (isset($vecCompleto[$maxPos])) {
           	  	   		 if ($vecCompleto[$j]==$vecCompleto[$maxPos]) {
           	   	   	   	 $pos=$pos-1;
           	    	  	 break;
           	              } 
           	  	    }else{
           	  	 	    $pos=$pos-1;
           	  	    	break;
           	  	    }
           	  }
           	 $maxPos = $maxPos - 1;
           	 $cotaFor=$cotaFor-1;
           }
            return $pos;
	}//fin calcular posicion

	public function buscarPosicion($brillo, $vecCompleto)
	{
		$unidad = $this -> calcularPosicion(2, $vecCompleto);
		$decena = $this -> calcularPosicion(5, $vecCompleto);
		$centena = $this -> calcularPosicion(8, $vecCompleto);
		$udemil = $this -> calcularPosicion(11, $vecCompleto);
		$ddemil = $this -> calcularPosicion(14, $vecCompleto);
		$cdemil = $this -> calcularPosicion(17, $vecCompleto);
		$udemillon = $this -> calcularPosicion(20, $vecCompleto);
		switch ($brillo) {
		case  0:
			
			if (($unidad-1)<>0) {
				$pos = rand(0,$unidad-1);
			} else {
				$pos = 0;
			}
			
			return $pos;
			break;

		case 1:
			
		
			if (($decena-1)<>0) {
				$pos = rand($unidad, $decena-1);
			} else {
				$pos = $unidad;
			}
			
			return $pos;
			break;

		case 2:
			
		    $var=$unidad+$decena;
			if (($centena-1)<>0) {
				$pos = rand($var,$var- ($centena-1));
			} else {
				$pos = $var;
			}
						
			return $pos;
			break;

		case 3:
		 
			$var=$unidad+$decena+$centena;
			if (($udemil-1)<>0) {
				$pos = rand($var,$var-($udemil-1));
			} else {
				$pos = $var;
			}
			
			return $pos;
			break;

		case 4:
			
	         $var=$unidad+$decena+$centena+$udemil;
			if (($ddemil-1)<>0) {
				$pos = rand($var,$var-($ddemil-1));
			} else {
				$pos = $var;
			}
			
			return $pos;
			break;

		case 5:
			
	        $var=$unidad+$decena+$centena+$udemil+$cdemil;
			if (($cdemil-1)<>0) {
				$pos = rand($var,$var-($cdemil-1));
			} else {
				$pos = $var;
			}
			
			return $pos;
			break;

		case 6:
		
		    $var=$unidad+$decena+$centena+$udemil+$udemillon+$cdemil+$udemillon;
			if (($udemillon-1)<>0) {
				$pos = rand($var,$var-($udemillon-1));
			} else {
				$pos = $var;
			}
			
			return $pos;
			break;	

		}
	}//fin buscar posicion


	/*AplicarAlgoritmo recibe los vectores iniciales, los operadores iniciales (letras), el resultado inicial
	(letras) y el vector de inicio arreglado con los elementos sin repetir */
	public function aplicarAlgoritmo($luciernagas, $operador, $op1, $op2, $resul, $vecInicio, $vecCompleto, $cant_iteraciones,  $probarDeNuevo){
		$time_start = microtime(true);

		$brilloMayor = -100;
		$vector = "vector";
		$n = sizeof($luciernagas);
		$i = 1;
		while (($i <= $cant_iteraciones)and($brilloMayor<count($resul))) { //while iteraciones
		
			for ($j=1; $j <= $n; $j++) 
			{ 
				/*toma un vector y lo compara con todos los demas 
				Saca primero los valores de ese vector*/
				$valor_op1_A= $this->extraerValoresPorOperando($luciernagas[$j], $op1, $vecInicio);
				$valor_op2_A= $this->extraerValoresPorOperando($luciernagas[$j], $op2, $vecInicio);
				$valor_resul_A= $this->extraerValoresPorOperando($luciernagas[$j], $resul,$vecInicio);
				$sumaA = implode('', $valor_op1_A) + implode('', $valor_op2_A);
				$brilloA = $this->obtenerBrillo($valor_resul_A,  $sumaA);
					
				/*Tomo los demas vectores distintos al primero que tomo */				
				for ($k=1; $k <= $n ; $k++) 
				{ 
					if ($j <> $k)
					{
						$valor_op1_B= $this->extraerValoresPorOperando($luciernagas[$k], $op1,$vecInicio);
						$valor_op2_B= $this->extraerValoresPorOperando($luciernagas[$k], $op2,$vecInicio);
						$valor_resul_B= $this->extraerValoresPorOperando($luciernagas[$k], $resul,$vecInicio);
						$sumaB = implode('', $valor_op1_B) + implode('', $valor_op2_B);
						$brilloB = $this->obtenerBrillo($valor_resul_B,  $sumaB);
					
						if ($brilloA < $brilloB)
						 {
							//busca la posicion a modificar
							$pos = $this->buscarPosicion($brilloA, $vecCompleto);
						}
						elseif ($brilloA >= $brilloB) 
						{	
							//busca la posicion a modificar
							$pos = rand(0,9);
							
						}
							$distancia = $this->distancia($valor_resul_A, $valor_resul_B);
							$luciernagas[$j] = $this->movimiento($luciernagas[$j], $distancia, $pos);
							$valor_op1 = $this->extraerValoresPorOperando($luciernagas[$j], $op1, $vecInicio);
							$valor_op2 = $this->extraerValoresPorOperando($luciernagas[$j], $op2, $vecInicio);
							$valor_resul = $this->extraerValoresPorOperando($luciernagas[$j], $resul,$vecInicio);
							$suma = implode('',$valor_op1) + implode('',$valor_op2);
							//actualizar intensidad	- se recalcula el brillo del elemento que se movio.
							$brilloA = $this->obtenerBrillo($valor_resul,  $suma);

						if ($brilloA >= $brilloMayor and $brilloA >$brilloB) 
							{
								$brilloMayor = $brilloA;
								//echo "brillo mayor: ".$brilloMayor.' - ';
								$vectorSolucion = $luciernagas[$j];
								$suma = implode('', $valor_op1) + implode('', $valor_op2);
								$op1_solucion = $valor_op1;
								$op2_solucion = $valor_op2;
								$suma_solucion = $suma;
							}
					}	
					if ($brilloMayor == count($resul) and count($resul) == count($this->intToArray($suma_solucion))) 
					{
						var_dump(count($resul),$this->intToArray($suma_solucion) );
						$time_end = microtime(true);
						echo "</br><b> ---->>>>>>ENCONTRO SOLUCION<<<<<<------ </b><br>La solucion: ";
						$totalIteraciones = ($probarDeNuevo -1) * $cant_iteraciones + $i;
						echo "<br> cantidad de iteraciones: ".$totalIteraciones."<br>";
						$this->acomodarArray($vectorSolucion);
						$this->acomodarArray($vecInicio);
						
						if ($operador == '-') {
							//echo $resul;
							echo $suma_solucion. '<br>';
							echo " - ";
							$this->acomodarArray($op2_solucion );
							echo " = ";
							$this->acomodarArray($op1_solucion);
							$this->acomodarArray(array_reverse($resul));
							$this->acomodarArray(array_reverse($op2));
							$this->acomodarArray(array_reverse($op1));
						} else{
							$this->acomodarArray($op1_solucion);
							$this->acomodarArray($op2_solucion);
							echo $suma_solucion. '<br>';
							//$this->acomodarArray($suma_solucion);
							$this->acomodarArray(array_reverse($op1));
							echo " + ";				
							$this->acomodarArray(array_reverse($op2));
							echo " = ";
							$this->acomodarArray(array_reverse($resul));
							
							}
							$time = round(($time_end - $time_start), 4);
							echo "Displaying the render time: $time seconds\n";
							//llamo a la vista mostrarResultado;
							//para mostrar resultados
							$data['brilloMayor'] = $brilloMayor;
							$data['iteraciones'] = $i;
							$data['operador'] = $operador;
							$data["vecinicio"] = json_encode($vecInicio);
							$data["operando1"] = json_encode(array_reverse($op1));
							$data["operando2"] = json_encode(array_reverse($op2));
							$data["resultado"] = json_encode(array_reverse($resul));
							$data['vector'] = json_encode($vectorSolucion);
							$data['bandera'] = true;
							$this->load->view('mostrarResultado', $data);
						return;
					}
				}//Fin for	
			}//Fin for
			$i = $i + 1;
		}//end while iteraciones
		
			$probarDeNuevo++;
			//echo "probar de nuevo:" .$probarDeNuevo;
			$this->main($probarDeNuevo);
			//echo "no encuentra nada";
		
	} //FIN APLICAR ALGORITMO
}