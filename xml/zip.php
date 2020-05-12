<?php

@session_start();
set_time_limit(0);
ini_set("display_errors", "Off");
@header('Content-Type: text/html; charset=utf-8');


$path = "./";
$diretorio = dir($path);
 
while($arquivo = $diretorio->read()){

	$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);

	if($extensao == "zip"){

		$QUEBRA 	    = explode(".",$arquivo);
		$NOMEARQUIVO 	= $QUEBRA[0]; 
		$filename 		= $NOMEARQUIVO.".zip";

		$z = new ZipArchive();
		
		$abriu = $z->open($NOMEARQUIVO.'.zip');

		if ($abriu === true) {

			if($NOMEARQUIVO == "fotos"){
				
				//$z->extractTo("../catalog/prod");
				//$z->extractTo("../catalog/prod/");
				$z->extractTo("../image/catalog");
				$z->extractTo("../image/catalog");

			}else{    			
    			$z->extractTo("./");
			}

    		$z->close();
	
			//  echo $NOMEARQUIVO." (Extraido com sucesso) <br />";
			//	unlink($NOMEARQUIVO.'.zip');
	
		} else {
		  //  echo 'Erro: '.$abriu;
		}

	} else {
		
	}

}

$obj['message'] = 'zip';
echo $_GET['callback']. '(' . json_encode($obj) . ');';