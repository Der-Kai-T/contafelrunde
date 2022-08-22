<?php

	if(isset($db_result)){

		if($db_result['result'] == "ok"){			
			echo"
				<div class='row dontprint'>
					<div class='col-12'>
						<div class='card'>
							<div class='card-header bg-success''>
								<h3 class='card-title'>Die Anfrage <i>$query</i> wurde erfolgreich vom Datenbank-Server entgegengenommen</h3>

							  
							</div>
							
							
						</div>
					</div>
				</div>
			";
		}else{
			
			if(isset($db_result['error_string'])){
				$error_string = $db_result['error_string'];
			}else{
				$error_string = "";
			}

			if(isset($db_result['errorinfo'])){
				$errorinfo = $db_result['errorinfo'];
			}else{
				$errorinfo	= "";
			}
			
			//TODO: Add all Error-Handling according to https://docstore.mik.ua/orelly/java-ent/jenut/ch08_06.htm
			
			$error_code[23000] = "Verletzung der Integritätsbeschränkung. Der Eintrag für das Feld ist bereits vorhanden";

			if(isset($db_result['pdo_error'])){
				
				$pdo_error = (array)$db_result['pdo_error'];
				$prefix = chr(0).'*'.chr(0);
				// echo"<pre>";
				// print_r($pdo_error);
				// echo "</pre>";
				$error_code = $pdo_error[$prefix.'code'];

				if(isset($error_code[$error_code])){
					$errorinfo = $error_code[$error_code];
				}else{
					$errorinfo = $pdo_error[$prefix.'message'];
				}
			}
			echo"
				<div class='row dontprint'>
					<div class='col-12'>
						<div class='card'>
							<div class='card-header bg-warning' >
								<h3 class='card-title'>Die Anfrage <i>$query</i> konnte vom Datenbank-Server nicht verarbeitet werden:</h3>

							  
							</div>
							
							<div class='card-body' style=''>
							<b>Fehlermeldung</b>:<br>
							$error_string<br>
							 <pre>$errorinfo</pre>
							 <br>
								Bei Fragen bitte an die Entwickler wenden (E-Mail siehe Fußzeile)

								
							 </div>
						</div>
					</div>
				</div>
			";
		}
	}

?>