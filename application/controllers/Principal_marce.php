<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal_marce extends CI_Controller 
{

	public function index()
	{
		
	}

	public function ingresar()
	{
		$this->load->view('ingresarDatos');
	}

	public function main()
	{
		$datosIniciales = $this->ingresarDatos();
		$vectorInicio = $datosIniciales['vectorInicio'];
		$vecCompleto = $datosIniciales['vecCompleto'];
		$operando1 = $datosIniciales['operando1'];
		$operando2 = $datosIniciales['operando2'];
		$resultado = $datosIniciales['resultado'];
		$operador = $datosIniciales['operador'];

		$atractividad = $this->atractividad ($vectorInicio, $operando1, $operando2, $resultado);
		//	$this->acomodarArray($vectorInicio);
	    //Luciernagas es un vector de la poblacion inicial.
	    $luciernagas = $this->crearMatrizInicial($poblacionInicial);

	    $this->aplicarAlgoritmo($luciernagas,$operador, $op1, $op2, $resul, $vectorInicio, $vecCompleto, $atractividad);
	 	
	}//FIN FUNCION MAIN
	

	public function mostrarResul ()
	{
		$data['brilloMayor'] = null;
		$data['bandera'] = "";
		$data["vecinicio"] = "";
		$data["operando1"] = "";
		$data["operando2"] = "";
		$data["resultado"] = "";
		$this->load->view('mostrarResultado', $data);
		$this-> ingresarDatos();
	}//FIN MOSTRAR RESULTADOS

	public function ingresarDatos()
	{
		//Este vector contiene todos los elementos ingresados, sin eliminar los repetidos
		$vecCompleto;
        //Este vector contiene todos los elementos pero sin repetir
		$vectorInicio;
		//Obtener los datos ingresados por pantalla
		$operando1 = $this->input->post('op1');
		$operando2 = $this->input->post('op2');
		$resultado = $this->input->post('res');
		$operador = $_POST["prop"];
		$poblacionInicial = $this->input->post('poblacion');
		
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
								 'operador' => $operador);
		return $datosIniciales;
	} // FIN INGRESAR DATOS


    /*La funcion acomodar vector inicio lo ordena de acuerdo a las
	unidades, decenas centas */
	public function acomodarVectorInicio($operando1,$operando2,$resultado)
	{
		$vectorInicio=array();
	    $totalElementos = count(array_merge($resultado,$operando2,$operando1));
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
  	}//FIN ACOMODAR ARRAY

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
		
		return $atractividad;
	}//FIN ATRACTIVIDAD

	/*Se cran la poblacion inicial con la que se va a trabajar en el resto del 
	algoritmo */
	public function crearMatrizInicial($poblacionInicial)
	{

         //Posicion del resultado que no debe valer 0
        $pos_izq_resul = sizeof($resul)-1;
        $pos_izq_resul = array_search($resul[$pos_izq_resul], $vecInicio);

        //Posicion del operador1 que no debe valer 0
        $pos_izq_op1 = sizeof($op1)-1;
        $pos_izq_op1 = array_search($op1[$pos_izq_op1], $vecInicio);

        //Posicion del operador2 que no debe valer 0
		$pos_izq_op2 = sizeof($op2)-1;
        $pos_izq_op2 = array_search($op2[$pos_izq_op2], $vecInicio);  

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
			if ($X1[$j] = $X2[$j]) {
				$d = $d + 10*$j;
			}
		}
		$d = fmod($d, 10);
		return $d;
	}//FIN DISTANCIA

	public function movimiento($X1, $X2, $distancia, $pos, $atractividad, $brillo, $pos_uno, $pos_izq_op1, $pos_izq_op2){
	//epsilon es un número aleatorio que varía de -1 a 1
	//$epsilon = -1;

	/* alfa es un número que con el tiempo debería tender a 0, si es que nos acercamos a la solución, 
	o ser un número alto si estamos lejos de la solución */
	$alfa = rand(0,9);

	//función de movimiento
	$beta = 1;
	$valor = $X1[$pos];
	//var_dump($X1);
	//echo "valor a cambiar: ".$valor.", ";

	if ($valor <> 1) {
		//Si el valor es distinto de 1, entonces aplico movimiento
		//$valor_nuevo = $valor + $beta * $distancia + $alfa*$epsilon;
		$valor_nuevo = $valor + $alfa;
		$valor_nuevo = fmod($valor_nuevo, 10);
		while ($valor_nuevo==1)
		    {
			$alfa = rand(0,9);
			$valor_nuevo=$valor + $alfa;
			$valor_nuevo = fmod($valor_nuevo, 10);
			}

		while (($pos==$pos_izq_op1 or $pos==$pos_izq_op2) and ($valor_nuevo==0))
		    {
			$alfa = rand(2,9);
			$valor_nuevo=$valor + $alfa;
			$valor_nuevo = fmod($valor_nuevo, 10);
			}
			
			$posicion = array_search($valor_nuevo, $X1);
			
		while(($atractividad[$posicion]<=$brillo)or($valor_nuevo==1)or($valor==$valor_nuevo))
			{
			//$valor_nuevo = $valor + $beta * $distancia + $alfa*$epsilon;							
			$alfa = rand(0,9);
			$valor_nuevo=$valor + $alfa;
			$valor_nuevo = fmod($valor_nuevo, 10);
			$posicion = array_search($valor_nuevo, $X1);			
			}
	}else{
			//Si es 1, entonces el valor del resultado más a la izquierda y debe serguir siendo = 1
			$valor_nuevo = 1;
		}		
		
		$X1=$this->controlarRepetidos($X1, $valor_nuevo,$valor);
		$X1[$pos]=$valor_nuevo;
		$this->acomodarArray($X1);
		return $X1;
	}//FIN MOVIMIENTO
	
	/*AplicarAlgoritmo recibe los vectores iniciales, los operadores iniciales (letras), el resultado inicial
	(letras) y el vector de inicio arreglado con los elementos sin repetir */
	public function aplicarAlgoritmo($luciernagas,$operador ,$op1, $op2, $resul, $vecInicio, $vecCompleto, $atractividad)
	{
		$brilloMayor = -100;
		$vector = "vector";
		$n = sizeof($luciernagas);
		$i = 1;
		while (($i <= 200)and($brilloMayor<count($resul))) { //while iteraciones
		
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
							//calcula la distancia entre ambos vectores
							$distancia = $this->distancia($valor_resul_A, $valor_resul_B);
							//busca la posicion a modificar
							$pos = $this->buscarPosicion($brilloA, $vecCompleto);							
							//mueve el de menor brillo
							$luciernagas[$j] = $this->movimiento($luciernagas[$j], $luciernagas[$k], $distancia, $pos, $atractividad, $brilloA,$pos_uno,$pos_izq_op1,$pos_izq_op2);				
							$valor_op1 = $this->extraerValoresPorOperando($luciernagas[$j], $op1, $vecInicio);
							$valor_op2 = $this->extraerValoresPorOperando($luciernagas[$j], $op2, $vecInicio);
							$valor_resul = $this->extraerValoresPorOperando($luciernagas[$j], $resul,$vecInicio);
							$suma = implode('',$valor_op1) + implode('',$valor_op2);
							//se recalcula el brillo del elemento que se movio.
							$brilloA = $this->obtenerBrillo($valor_resul,  $suma);											
							
						}elseif ($brilloA = $brilloB) 
						{	

							//calcula la distancia entre ambos vectores
							$distancia = $this->distancia($valor_resul_A, $valor_resul_B);
							//busca la posicion a modificar
							$pos = rand(0,9);
							
							//mueve el de menor brillo
							$luciernagas[$j] = $this->movimiento($luciernagas[$j], $luciernagas[$k], $distancia, $pos, $atractividad, $brilloA,$pos_uno,$pos_izq_op1,$pos_izq_op2);				
							$valor_op1 = $this->extraerValoresPorOperando($luciernagas[$j], $op1, $vecInicio);
							$valor_op2 = $this->extraerValoresPorOperando($luciernagas[$j], $op2, $vecInicio);
							$valor_resul = $this->extraerValoresPorOperando($luciernagas[$j], $resul,$vecInicio);
							$suma = implode('',$valor_op1) + implode('',$valor_op2);
							//se recalcula el brillo del elemento que se movio.
							$brilloA = $this->obtenerBrillo($valor_resul,  $suma);							
						}
						if ($brilloA >= $brilloMayor and $brilloA >$brilloB) 
							{
								$brilloMayor = $brilloA;
								$vectorSolucion = $luciernagas[$j];
								$suma = implode('', $valor_op1) + implode('', $valor_op2);
								$op1_solucion = $valor_op1;
								$op2_solucion = $valor_op2;
								$suma_solucion = $suma;
							}
					}
					
				}//Fin for
				
			}//Fin for
			$i = $i + 1;
		}//end while iteraciones
		//controlar si llego a la solucion;
		
		$data['brilloMayor'] = $brilloMayor;
		$data['vector'] = json_encode($vectorSolucion);
		$data['iteraciones'] = $i;
		$data['operador'] = $operador;
		if ($brilloMayor == count($resul)) 	{
	        $data["vecinicio"] = json_encode($vecInicio);
			$data["operando1"] = json_encode(array_reverse($op1));
			$data["operando2"] = json_encode(array_reverse($op2));
			$data["resultado"] = json_encode(array_reverse($resul));
			$data['bandera'] = true;
			$this->load->view('mostrarResultado', $data);
			//return $brilloMayor;
		}elseif ($brilloMayor < count($resul)) {
			$data['bandera'] = false;
			$this->load->view('mostrarResultado', $data);
		}
       
	} //FIN APLICAR ALGORITMO


}