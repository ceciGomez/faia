<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal_Ceci extends CI_Controller 
{

	public function index()
	{
		
	}

	public function ingresar()
	{
		$this->load->view('ingresarDatos');
	}

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
	}//fin distancia

	public function beta()
	{
		$valor_beta = 1;
		return $valor_beta;
	}
	public function atractividad ($vector_letras, $operando1, $operando2, $resultado)
	{
		// Aví debería quedar el vector para SEND+MORE=MONEY $atractividad= array(1,1,1,2,2,3,4,4,100,100);

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
		////echo "</BR>atractividad: ";
		//var_dump($atractividad);
		return $atractividad;
	}


 	// esta función se utiliza por elemento del vector luciernaga
	public function movimiento($X1, $X2, $distancia, $pos, $atractividad, $brillo, $pos_uno, $pos_izq_op1, $pos_izq_op2){
		//epsilon es un número aleatorio que //varía de -1 a 1
		//$epsilon = -1;

		/* alfa es un número que con el tiempo debería tender a 0, si es que nos acercamos a la solución, 
		o ser un número alto si estamos lejos de la solución */
		$alfa = rand(0,9);

		//función de movimiento
		$beta = $this->beta();
		$distancia = 3;
		$valor = $X1[$pos];
		////var_dump($X1);
		//echo "valor a cambiar: ".$valor.", ";

		if ($valor <> 1) {
			//Si el valor es distinto de 1, entonces aplico movimiento
			//$valor_nuevo = $valor + $beta * $distancia + $alfa*$epsilon;
			$valor_nuevo = $valor + $alfa;
			$valor_nuevo = fmod($valor_nuevo, 10);
			while ($valor_nuevo==1) {
				$alfa = rand(0,9);
				$valor_nuevo=$valor + $alfa;
				$valor_nuevo = fmod($valor_nuevo, 10);
			}

			while (($pos==$pos_izq_op1 or $pos==$pos_izq_op2) and ($valor_nuevo==0)) {
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
			//Si es 1, entonces el valor del resultado más a la izquierda y debe seguir siendo = 1
			$valor_nuevo = 1;
		}
		
		
		//echo "valor cambiado: ".$valor_nuevo;
		//echo "</br>";

		$X1=$this->controlarRepetidos($X1, $valor_nuevo,$valor);

		$X1[$pos]=$valor_nuevo;
		//echo "Array sin repetidos: ";
		//$this->acomodarArray($X1);
		////var_dump($X1);
		return $X1;
	}//fin movimiento


	//Funcion para mostrar como matriz.
	public function acomodarArray(array $id)
	{
	   $output = array();
           foreach ($id as $vectorInicio =>$a) {
           foreach ((array)$a as $key => $value) {
             $output[$key][] = $value; 
           }
      }
       foreach ($output as $o) {
            echo '<tr><td>' . implode('</td><td>', $o) . '</td></tr>'."<br/>";
	        }
	}//fin de acomodar array

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

	// Se busca los repetidos dentro del vector y se modifican
	public function controlarRepetidos($vectorEntrada, $valor_a_buscar, $valor)
	{
		//echo "VECTOR DE ENTRADA para controlar repetidos: ";
		//$this->acomodarArray($vectorEntrada);
		
		//echo "valor a buscar: ".$valor_a_buscar;
		$posicion = array_search($valor_a_buscar, $vectorEntrada);
		//echo "posicion: ".$posicion;
		//echo ", valor nuevo: ".$valor."</br>";
		$vectorEntrada[$posicion] = $valor;
		//echo " Array con repetidos: ";
		//$this->acomodarArray($vectorEntrada);
		return $vectorEntrada;
	}//fin de controlar repetidos

	public function ingresarDatos()
	{
		//Este vector contiene todos los elementos ingresado, sin eliminar los repetidos
		$vecCompleto;
        //Este vector contiene todos los elementos pero sin repetir
		$vectorInicio;
		//Obtener los datos ingresados por pantalla
		$operando1 = $this->input->post('op1');
		$operando2 = $this->input->post('op2');
		$resultado = $this->input->post('res');
		$operador = $_POST["prop"];
		
		//echo '<br> <b>'.$operando1.' '.$operador.' '.$operando2.' = '.$resultado.'</b><br>';

		//la funcion str_split divide en elementos y lo pone en un arreglo
		//la funcion array_reverse da vuelta el array
		$operando1 = str_split($operando1);
		$operando1 = array_reverse($operando1);
		$operando2 = str_split($operando2);
		$operando2 = array_reverse($operando2);
		$resultado = str_split($resultado);
		$resultado = array_reverse($resultado);
		$vecCompleto=$this->acomodarVectorInicio($operando1,$operando2,$resultado);
        $this->acomodarArray($vecCompleto);
        //Elimna los elementos repetidos
		$vectorInicio = array_unique($vecCompleto);
		//Elimina las posiciones vacias
		$vectorInicio = array_values( $vectorInicio );
		if (count($vectorInicio)<= 10){
			  //rellenar con guiones las demas posiciones del array hasta completar 10.
				$posiciones = count($vectorInicio);
				////var_dump($posiciones);
				$posFaltantes= 10 - $posiciones;
				////var_dump($posFaltantes);
			  for ($i= 1; $i <= $posFaltantes; $i++) { 
			  	array_push($vectorInicio, '-');
			  }
			  //echo "<br> Vector Inicio: ";
			  //var_dump(count($vectorInicio));
	   		  $atractividad = $this->atractividad ($vectorInicio, $operando1, $operando2, $resultado);
			  //$this->acomodarArray($vectorInicio);
	   		  $this->crearMatrizInicial($operando1,$operando2, $resultado, $vectorInicio, $vecCompleto, $atractividad);
		   	 }else{
		   	 //se va a mostrar una alerta cuando se ingresen mas de 10 letras diferentes
		   	 $this->do_alert();
		 	 return;  
		 }
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
	
	/*Se cran la poblacion inicial con la que se va a trabajar en el resto del 
	algoritmo */
	public function crearMatrizInicial($op1, $op2, $resul,$vecInicio, $vecCompleto, $atractividad)
	{
         
        //Obtenemos la posicion que debe valer 1
        $pos_uno = sizeof($resul)-1;
        $pos_uno = array_search($resul[$pos_uno], $vecInicio);

        //Obtenemos una posición que no debe ser 0
        $pos_izq_op1 = sizeof($op1)-1;
        $pos_izq_op1 = array_search($op1[$pos_izq_op1], $vecInicio);

        //Obtenemos la otra posición que no debe ser 0
		$pos_izq_op2 = sizeof($op2)-1;
        $pos_izq_op2 = array_search($op2[$pos_izq_op2], $vecInicio);        

        //Cantidad total de luciérnagas
        $n = 10;
        for($i=1; $i <=$n; $i++){

        	//se crea el array
		    $luciernagas[$i]=array('0','1', '2','3','4','5','6','7','8','9'); 
		    //se lo mezcla al array creado
		   	shuffle($luciernagas[$i]);
		    //echo "<br> -------------- <br> vector".$i.": ";
			//echo implode('', ($luciernagas[$i]));

			//El valor de más a la izquierda del resultado, debe ser 1
			$vec = $luciernagas[$i];
			if ($vec[$pos_uno]<>1) {
				$val = $vec[$pos_uno];
				$p = array_search(1, $vec);
				$vec[$p]=$val;
				$vec[$pos_uno]=1;
				$luciernagas[$i]=$vec;
			}

			//El valor de más a la izquierda de operando1, no puede ser 0
			if ($vec[$pos_izq_op1]==0) {
				$val = rand(2,9);
				$p = array_search($val, $vec);
				$vec[$pos_izq_op1]=$val;
				$vec[$p]=0;
				$luciernagas[$i]=$vec;
			}

			//El valor de más a la izquierda de operando2, no puede ser 0
			if ($vec[$pos_izq_op2]==0) {
				$val = rand(2,9);
				while ($val==$vec[$pos_izq_op1]) {
					$val = rand(2,9);
				}
				$p = array_search($val, $vec);
				$vec[$pos_izq_op2]=$val;
				$vec[$p]=0;
				$luciernagas[$i]=$vec;
			}

			//Se sacan los valores que corresponden a los operando ingresados
			$valor_op1= $this->extraerValoresPorOperando($luciernagas[$i], $op1,$vecInicio);
			$valor_op2= $this->extraerValoresPorOperando($luciernagas[$i], $op2,$vecInicio);
			$valor_resul= $this->extraerValoresPorOperando($luciernagas[$i], $resul,$vecInicio);
			 
			//echo "Op 1: ".implode('',$op1);		 
			//$this->acomodarArray($valor_op1);
			//echo " Op 2: ".implode('', $op2);
			//$this->acomodarArray($valor_op2);
			//echo "Resultado";
			//$this->acomodarArray($valor_resul);
			$suma = implode('',$valor_op1) + implode('',$valor_op2);
			//echo "suma: ". $suma.'</br>';
			$brilloInicial = $this->obtenerBrillo($valor_resul,  $suma);
			//echo "Brillo inicial: ".$brilloInicial."</br>";	 
		}
		$vector_resultado_final = array(
			$this->aplicarAlgoritmo($luciernagas, $op1, $op2, $resul, $vecInicio, $vecCompleto, $atractividad,$pos_uno, $pos_izq_op1, $pos_izq_op2));
		
		//$this->load->view('mostrarResultados');
	} //FIN CREAR MATRIZ INICIAL
	
	public function intToArray($x)
	{
			$arr = array();
		    $arr = array_map('intval', str_split($x));
			return $arr;
	}//fin de int to array

	/*El brillo se obtiene de acuerdo a la posicion y la igualdad 
	entre el resultado obtenido y el que se forma con las letras 
	de la solucion correcta, esto no quiere decir que ese resultado
	sea el correcto. */
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
	}// fin de obtener brillo

		//DEYNROSM es el nuevo vector
	//DEY corresponde a la unidad entonces devuelve 3 (puedo cambiar desde la posicion 0 a 2)
	//NR corresponde a la decena, ya no toma en cuenta la E, entonces devuelve 2 (puedo cambiar desde la posicion 3 a 4)
	//O corresponde a la decena,  E y N ya se repiten, entonces deuelve 1 (Puedo cambiar la posicion 5)
	//SM corresponde a la centena, la O ya no toma encuenta, entonces devuelve 2 (puedo cambiar la posicion 6 a 7)
	//Y asi recorre todo el vector DEYNROSM; esto es lo que devuelve calcularPosicion.
	//falta ver como manejamos esos valores para movernos sobre el vector
		public function buscarPosicion($brillo, $vecCompleto)
	{
		$unidad = $this -> calcularPosicion(2, $vecCompleto);
		$decena = $this -> calcularPosicion(5, $vecCompleto);
		$centena = $this -> calcularPosicion(8, $vecCompleto);
		$udemil = $this -> calcularPosicion(11, $vecCompleto);
		$ddemil = $this -> calcularPosicion(14, $vecCompleto);
		$cdemil = $this -> calcularPosicion(17, $vecCompleto);
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
			
		
			if (($centena-1)<>0) {
				$pos = rand($decena, $centena-1);
			} else {
				$pos = $decena;
			}
						
			return $pos;
			break;

		case 3:
		 
			
			if (($udemil-1)<>0) {
				$pos = rand($centena, $udemil-1);
			} else {
				$pos = $centena;
			}
			
			return $pos;
			break;

		case 4:
			
	
			if (($ddemil-1)<>0) {
				$pos = rand($udemil,$ddemil-1);
			} else {
				$pos = $udemil;
			}
			
			return $pos;
			break;

		case 5:
			
	
			if (($cdemil-1)<>0) {
				$pos = rand($ddemil,$cdemil-1);
			} else {
				$pos = $ddemil;
			}
			
			return $pos;
			break;

		}
	}//fin buscar posicion

	public function calcularPosicion ($cotaSuperior, $vecComp) {
           $maxPos=$cotaSuperior;
           $cotaFor=$maxPos-1;
           $vecCompleto=$vecComp;
           $pos=3;
           for ($i=0 ; $i < 3 ; $i++ ) { 
           	  for ($j=0; $j <= $cotaFor; $j++) {
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

	/*AplicarAlgoritmo recibe los vectores iniciales, los operadores iniciales (letras), el resultado inicial
	(letras) y el vector de inicio arreglado con los elementos sin repetir */
	public function aplicarAlgoritmo($luciernagas, $op1, $op2, $resul, $vecInicio, $vecCompleto, $atractividad,$pos_uno,$pos_izq_op1, $pos_izq_op2)
	{
		
		$brilloMayor = -100;
		$vector = "vector";
		$n = sizeof($luciernagas);
		$i = 1;
		while (($i <= 200)and($brilloMayor<count($resul))) { //while iteraciones
			//echo "</br><b> iteracion nro: ".$i."</b></br>";

			for ($j=1; $j <= $n; $j++) { 
				/*toma un vector y lo compara con todos los demas 
				Saca primero los valores de ese vector*/
				$valor_op1_A= $this->extraerValoresPorOperando($luciernagas[$j], $op1, $vecInicio);
				$valor_op2_A= $this->extraerValoresPorOperando($luciernagas[$j], $op2, $vecInicio);
				$valor_resul_A= $this->extraerValoresPorOperando($luciernagas[$j], $resul,$vecInicio);
				$sumaA = implode('', $valor_op1_A) + implode('', $valor_op2_A);
				$brilloA = $this->obtenerBrillo($valor_resul_A,  $sumaA);
					
				/*Tomo los demas vectores distintos al primero que tomo */				
				for ($k=1; $k <= $n ; $k++) { 
					if ($j <> $k)
					{
						$valor_op1_B= $this->extraerValoresPorOperando($luciernagas[$k], $op1,$vecInicio);
						$valor_op2_B= $this->extraerValoresPorOperando($luciernagas[$k], $op2,$vecInicio);
						$valor_resul_B= $this->extraerValoresPorOperando($luciernagas[$k], $resul,$vecInicio);
						$sumaB = implode('', $valor_op1_B) + implode('', $valor_op2_B);
						$brilloB = $this->obtenerBrillo($valor_resul_B,  $sumaB);

						//echo "<br>-------------------------------</br>";
						//echo "<i>Brillo de ".$vector.$j.": ".$brilloA ."  ";		
						//echo " - Brillo de ".$vector.$k.": ".$brilloB."  </i></br>";
						//echo $vector.$j.": ".implode(' ', $luciernagas[$j]);
						//echo " ".$vector.$k.": ".implode(' ', $luciernagas[$k])."<br>";
					
						if ($brilloA <= $brilloB)
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
							//echo "nuevo brillo de ".$vector.$j.": ".$brilloA."<br>";
							
							
						}else{
							//calcula la distancia entre ambos vectores
							$distancia = $this->distancia($valor_resul_A, $valor_resul_B);
							//busca la posicion a modificar
							$pos = rand(0,7);
							
							//mueve el de menor brillo
							$luciernagas[$j] = $this->movimiento($luciernagas[$j], $luciernagas[$k], $distancia, $pos, $atractividad, $brilloA,$pos_uno,$pos_izq_op1,$pos_izq_op2);				

							$valor_op1 = $this->extraerValoresPorOperando($luciernagas[$j], $op1, $vecInicio);
							$valor_op2 = $this->extraerValoresPorOperando($luciernagas[$j], $op2, $vecInicio);
							$valor_resul = $this->extraerValoresPorOperando($luciernagas[$j], $resul,$vecInicio);
							$suma = implode('',$valor_op1) + implode('',$valor_op2);
							//se recalcula el brillo del elemento que se movio.
							$brilloA = $this->obtenerBrillo($valor_resul,  $suma);
							//echo "nuevo brillo de ".$vector.$j.": ".$brilloA."<br>";
						}
						if ($brilloA >= $brilloMayor and $brilloA >$brilloB) 
							{
								//echo "brillo mayor: ".$brilloMayor."<br>";
								//echo "brillo del nuevo vector: ".$brilloA."<br>";
								$brilloMayor = $brilloA;
								//echo "brillo del nuevo vector: ".$brilloA."<br>";
								$vectorSolucion = $luciernagas[$j];
								//echo "vector de mayor brillo ".$vector.$j.": ".implode('', $vectorSolucion);
								//echo "<br> op1: ".implode('',$valor_op1);
								//echo " op2: ".implode('',$valor_op2)."-";
								$suma = implode('', $valor_op1) + implode('', $valor_op2);
								//echo "la suma es: ".$suma;
								//echo " el resultado: ".implode(' ', $valor_resul);
								//echo "<br> - brillo nuevo: ".$brilloA;
							}
					}
					
				}//Fin for
				
			}//Fin for
			$i = $i + 1;
			
		}//end while iteraciones
		//controlar si llego a la solucion;
		if ($brilloMayor == count($resul)) 
		{
			echo "<br><b>mayor brillo:  ".$brilloMayor."</b>";
			//echo "<bR> el mayor brillo deberia ser: " .count($resul);
			echo "<br> SOLUCIÓN: ";
			$this->acomodarArray($vectorSolucion);
			$operador1 = $this->extraerValoresPorOperando($vectorSolucion, $op1, $vecInicio);
			$operador2 = $this->extraerValoresPorOperando($vectorSolucion, $op2, $vecInicio);
			$resultado = $this->extraerValoresPorOperando($vectorSolucion, $resul, $vecInicio);
			echo "Operador 1: ";
			$this->acomodarArray(array_reverse($op1));
			$this->acomodarArray($operador1);
			echo "Operador 2: ";
			$this->acomodarArray(array_reverse($op2));
			$this->acomodarArray($operador2);
			echo "Resultado: ";
			$this->acomodarArray(array_reverse($resul));
			$this->acomodarArray($resultado);
			//var_dump($vectorSolucion);
			//extraerValoresPorOperando($vector, $operando, $vecInicio)
			//return $brilloMayor;
		}elseif ($brilloMayor < count($resul)) {
			
			//echo "Recalculando, iteraciones totales: ".$totalIteraciones." <br>";
			// echo "<br> op1: ";
			// $this->acomodarArray($op1);
			// echo "<br> op 2:";
			// $this->acomodarArray($op2);
			// echo "<br> resul:";
			// $this->acomodarArray($resul);
			// //var_dump($op1, $op2, $resul);
			// echo "<br> vector inicio";
			// $this->acomodarArray($vecInicio);
			// echo "<br> vector completo";
			// $this->acomodarArray($vecCompleto);
			// echo "<br> atractividad";
			// $this->acomodarArray($atractividad);
			 $this->crearMatrizInicial($op1, $op2, $resul,$vecInicio, $vecCompleto, $atractividad);

		}
	} //FIN APLICAR ALGORITMO


} // fin de controlador

/* End of file CI_Principal.php */
/* Location: ./application/controllers/CI_Principal.php */