<?php

/* 
 * ARQUIVO DE CONEXÕES PARA ATUALIZAÇÃO E-COMMERCE
 */



    //CONEXÃO COM A LOJA DO ATACADO
    $conn[1]['IP']   = "192.168.0.112"; 
    $conn[1]['LOGIN'] = "root";
    $conn[1]['SENHA'] = "123@light";
    $conn[1]['BANCO'] = "loja_base";

    $conn[2]['IP']   = "192.168.0.112";
    $conn[2]['LOGIN'] = "root";
    $conn[2]['SENHA'] = "123@light";
    $conn[2]['BANCO'] = "loja_base";

    //print_r($conn);
    
//==============================================================================================================
function removeAcentos($string, $slug = false) {
	$string = strtolower($string);

	// Código ASCII das vogais
	$ascii['a'] = range(224, 230);
	$ascii['e'] = range(232, 235);
	$ascii['i'] = range(236, 239);
	$ascii['o'] = array_merge(range(242, 246), array(240, 248));
	$ascii['u'] = range(249, 252);

	// Código ASCII dos outros caracteres
	$ascii['b'] = array(223);
	$ascii['c'] = array(231);
	$ascii['d'] = array(208);
	$ascii['n'] = array(241);
	$ascii['y'] = array(253, 255);

	foreach ($ascii as $key=>$item) {
		$acentos = '';
		foreach ($item AS $codigo) $acentos .= chr($codigo);
		$troca[$key] = '/['.$acentos.']/i';
	}

	$string = preg_replace(array_values($troca), array_keys($troca), $string);

	// Slug?
	if ($slug) {
		// Troca tudo que não for letra ou número por um caractere ($slug)
		$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
		// Tira os caracteres ($slug) repetidos
		$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
		$string = trim($string, $slug);
	}

	return $string;
}
//===============================================================================================================