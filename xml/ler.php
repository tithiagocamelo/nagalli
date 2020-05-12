<?php
set_time_limit(0);
ini_set("display_errors", "Off");
define('WP_MEMORY_LIMIT', '64M');
@header('Content-Type: text/html; charset=utf-8');

include './conecta.php';

$ip = "localhost";
$login = "metaf215_loris";
$senha = "f!7-ar8=60Bc";
$banco = "metaf215_lori";


//LER ZIP

$path = "./";
$diretorio = dir($path);

while ($arquivo = $diretorio->read()) {

    $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);

    if ($extensao == "zip") {

        $QUEBRA = explode(".", $arquivo);
        $NOMEARQUIVO = $QUEBRA[0];


        $filename = $NOMEARQUIVO . ".zip";



        $z = new ZipArchive();
        $abriu = $z->open($NOMEARQUIVO . '.zip');
        if ($abriu === true) {

            if ($NOMEARQUIVO == "fotos") {
                $z->extractTo("../image/data");
                $z->extractTo("../image/data");
            } else {
                $z->extractTo("./");
            }
            $z->close();

            //  echo $NOMEARQUIVO." (Extraido com sucesso) <br />";
            //unlink($NOMEARQUIVO . '.zip');
        } else {
            //  echo 'Erro: '.$abriu;
        }
    }
}


//FIM DO LER ZIP




if (is_dir("categorias")) {

    $path = "categorias/";
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read()) {


        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($extensao == "xml") {


            $QUEBRA = explode(".", $arquivo);
            $NOME = explode("_", $QUEBRA[0]);
            $IDPRODUTO = $NOME[0];
            $CTIPOVENDA = $NOME[1];





            if ($CTIPOVENDA <> '') {

                if ($CTIPOVENDA == "A") {
                    //echo 'Vai se conectar no banco de dados que é de Varejo <br />';

                    $conecta = mysql_connect($ip, $login, $senha);
                    mysql_select_db($banco, $conecta);
                    mysql_query('SET character_set_connection=utf8');
                    mysql_query('SET character_set_client=utf8');
                    mysql_query('SET character_set_results=utf8');
                }

                if ($CTIPOVENDA == "V") {
                    //   echo 'Vai se conectar no banco de dados que é de Atacado <br />'; 


                    $conecta = mysql_connect($ip, $login, $senha);
                    mysql_select_db($banco, $conecta);
                    mysql_query('SET character_set_connection=utf8');
                    mysql_query('SET character_set_client=utf8');
                    mysql_query('SET character_set_results=utf8');
                }




                if (file_exists("categorias/" . $arquivo)) {

                    $xml = simplexml_load_file("categorias/" . $arquivo);

                    foreach ($xml as $categoria) {

                        //LEITURA DO XML PARA ADICIONAR NA TABELA CATEGORY
                        $ICODCATEGORIA = $categoria->category->category_id;
                        $IMAGEMCATEGORIA = $categoria->category->image;
                        $PARENTECATEGORIA = $categoria->category->parent_id;
                        $TOPOCATEGORIA = $categoria->category->topo;
                        $COLUNACATEGORIA = $categoria->category->column;
                        $ORDEMCATEGORIA = $categoria->category->sort_order;
                        $STATUSCATEGORIA = $categoria->category->status;

                        //LEITURA DO XML PARA ADICIONAR NA TABELA CATEGORY_DESCRIPTION
                        $ICODCATEGORIADESC = $categoria->category_description->category_id;
                        $NOMECATEGORIADESC = $categoria->category_description->name;
                        $METADESCRICAOCATEGORIADESC = $categoria->category_description->meta_description;
                        $METAPALAVRACATEGORIADESC = $categoria->category_description->meta_keyword;
                        $MOBS = $categoria->category_description->description;
                        $LINGUACATEGORIADESC = $categoria->category_description->language_id;




                        $ver_url_amigavel_produto = mysql_query("SELECT COUNT(*) AS Total_url FROM oc_url_alias
                                         		 WHERE query = CONCAT('category_id=','$ICODCATEGORIA')  ");
                        $total_url = mysql_result($ver_url_amigavel_produto, 0, 'Total_url');
                        if ($total_url > 0) {
                            $query = "category_id=" . $ICODCATEGORIA;

                            $ncategoriadesc = str_replace('/', '-', $NOMECATEGORIADESC);
                            $model = removeAcentos($ncategoriadesc, '-');

                            $sql_url_amigavel_update = "UPDATE oc_url_alias SET keyword = '$model'
												WHERE `query` = '$query'  ";
                            $execulta_url_up = mysql_query($sql_url_amigavel_update, $conecta);
                        } else {

                            $query = "category_id=" . $ICODCATEGORIA;
                            $ncategoriadesc = str_replace('/', '-', $NOMECATEGORIADESC);
                            $model = removeAcentos($ncategoriadesc, '-');

                            $sql_url_amigavel_inserir = "INSERT INTO oc_url_alias 
                                                           (query,
                                                            keyword
                                                            )VALUES(
                                                           '$query',
                                                           '$model')";
                            $execulta_url = mysql_query($sql_url_amigavel_inserir, $conecta);
                        }









                        //VERIFICA SE JÁ TEM A CATEGORIA ADICIONADA 
                        $conta_cat = mysql_query("SELECT COUNT(*) AS TotalCat
                                  FROM oc_category
                                  WHERE category_id = '$ICODCATEGORIA'  ");
                        $total_cat = mysql_result($conta_cat, 0, 'TotalCat');


                        // SE NÃO TIVER CADASTRADO VAI SER ADICIONADO
                        if ($total_cat < 1) {

                            $categoria_cad = "INSERT INTO oc_category 
		              (oc_category.category_id,
                               oc_category.image,
                               oc_category.parent_id,
                               oc_category.top,
                               oc_category.column,
                               oc_category.sort_order,
                               oc_category.status,
                               oc_category.date_added,
                               oc_category.date_modified
			       )VALUES(
                               '$ICODCATEGORIA',
                               '$IMAGEMCATEGORIA',
                               '$PARENTECATEGORIA',
                               '$TOPOCATEGORIA',
                               '$COLUNACATEGORIA',
                               '$ORDEMCATEGORIA',
                               '$STATUSCATEGORIA',
                               NOW(),
                               NOW()
                               )";
                            $execulta = mysql_query($categoria_cad, $conecta);
                        } else { //CASO A CATEGORIA JÁ TEM, VAI SER ALTERADO DE ACORDO COM A ID
                            $categoria_cad = "UPDATE oc_category SET 
				                oc_category.image = '$IMAGEMCATEGORIA',
                                oc_category.parent_id = '$PARENTECATEGORIA',
                                oc_category.top = '$TOPOCATEGORIA',
                                oc_category.column = '$COLUNACATEGORIA',
                                oc_category.sort_order = '$ORDEMCATEGORIA',
                                oc_category.status = '$STATUSCATEGORIA',
                                oc_category.date_modified = NOW()
                                WHERE oc_category.category_id = '$ICODCATEGORIA'
                                ";
                            $execulta = mysql_query($categoria_cad, $conecta);
                        }
                        //FINAL DA INSERÇÃO OU ALTRAÇÃO DA TABELA CATEGORY  
                        //INICIO DA INSERÇÃO OU ALTERAÇÃO DA TABELA CATEGORY_DESCRIPTION
                        $conta_catdesc = mysql_query("SELECT COUNT(*) AS Total
                                      FROM oc_category_description
                                      WHERE category_id = '$ICODCATEGORIA'  ");
                        $total_catdesc = mysql_result($conta_catdesc, 0, 'Total');

                        // SE NÃO EXISTIR CADASTRADO DE ACORDO COM A ID ELE VAI ADICIONAR
                        if ($total_catdesc < 1) {

                            $categoria_desc = "INSERT INTO oc_category_description 
			       (oc_category_description.category_id,
				oc_category_description.name,
				oc_category_description.meta_title,
				oc_category_description.meta_description,
				oc_category_description.description,
                                oc_category_description.meta_keyword,
                                oc_category_description.language_id
				)VALUES(
                                '$ICODCATEGORIADESC',
                                '$NOMECATEGORIADESC',
                                '$NOMECATEGORIADESC',
                                '$METADESCRICAOCATEGORIADESC',
                                '$MOBS',
                                '$METAPALAVRACATEGORIADESC',
                                '$LINGUACATEGORIADESC'
				)";
                            $execulta = mysql_query($categoria_desc, $conecta);
                        } else {



                            //SE EXISTIR ELE VAI ALTERAR DE ACORDO COM A ID

                            $categoria_desc = "UPDATE oc_category_description  SET
			    oc_category_description.name = '$NOMECATEGORIADESC',
                            oc_category_description.meta_description = '$METADESCRICAOCATEGORIADESC',
                            oc_category_description.description = '',
                            oc_category_description.meta_title = '$NOMECATEGORIADESC',
                            oc_category_description.meta_keyword = '$METAPALAVRACATEGORIADESC',
                            oc_category_description.language_id = '$LINGUACATEGORIADESC',
                            oc_category_description.description = '$MOBS'
                            WHERE oc_category_description.category_id = '$ICODCATEGORIADESC'
                           ";
                            $execulta = mysql_query($categoria_desc, $conecta);
                        }
                        //FINAL DA INSERÇÃO OU ALTRAÇÃO DA TABELA CATEGORY_DESCRIPTION  
                        //VAI ADICIONAR A CATEGORIA A LOJA.... DEIXAR ELA COMO ATIVA
                        $conta_store = mysql_query("SELECT COUNT(*) AS Total 
                                                    FROM oc_category_to_store
                                                    WHERE category_id = '$ICODCATEGORIA'  ");
                        $total_store = mysql_result($conta_store, 0, 'Total');
                        if ($total_store < 1) {
                            $categoria_store = "INSERT INTO oc_category_to_store 
			        (oc_category_to_store.category_id,
                                 oc_category_to_store.store_id
				 )VALUES(
				'$ICODCATEGORIA',
				 0
				 )";
                            $execulta = mysql_query($categoria_store, $conecta);
                        }
                    }
                }
            }
        }
    }


    //AQUI VAI ATUALIZAR A CATEGORIA DESABILITANDO AS OUTRAS 
    if ($CTIPOVENDA <> '') {

        if ($CTIPOVENDA == "A") {

            $conecta = mysql_connect($ip, $login, $senha);
            mysql_select_db($banco, $conecta);
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');


            $ver_produto_cadastrado = mysql_query("SELECT COUNT(category_id) AS Total_Pro FROM oc_category
                                         		 WHERE category_id =  '$IDPRODUTO'  ");
            $total_produto = mysql_result($ver_produto_cadastrado, 0, 'Total_Pro');
            if ($total_produto > 0) {

                $ver_up = mysql_query("UPDATE oc_category SET status = 0
                                         		 WHERE category_id =  '$IDPRODUTO'  ");


                //		echo "Categoria existe mais é do Varejo, fazer o Update de deixar o Status como desativado<br />";
            }
        }

        if ($CTIPOVENDA == "V") {

            $conecta = mysql_connect($ip, $login, $senha);
            mysql_select_db($banco, $conecta);
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');

            $ver_produto_cadastrado = mysql_query("SELECT COUNT(category_id) AS Total_Pro FROM oc_category
                                         		 WHERE category_id =  '$IDPRODUTO'  ");
            $total_produto = mysql_result($ver_produto_cadastrado, 0, 'Total_Pro');
            if ($total_produto > 0) {
                //	echo "Categoria existe mais é do Atacado, fazer o Update de deixar o Status como desativado<br />";

                $ver_up = mysql_query("UPDATE oc_category SET status = 0
                                         		 WHERE category_id =  '$IDPRODUTO'  ");
            }
        }
    }




    $path = "categorias/";
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read()) {
        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($extensao == "xml") {
            ////unlink("categorias/" . $arquivo);
        }
    }
} else {
    
}


//FIM DO CATEGORIAS
//INICIO FABRICANTES
if (is_dir("cadfab")) {


    if (file_exists("cadfab/cadfab.xml")) {

        foreach ($conn as $c => $y) {

            $arr = $y;
            foreach ($arr as $z => $y) {
                if ($z == "IP")
                    $ip = $y;
                if ($z == "LOGIN")
                    $login = $y;
                if ($z == "SENHA")
                    $senha = $y;
                if ($z == "BANCO")
                    $banco = $y;
            }

            $conecta = mysql_connect($ip, $login, $senha);
            mysql_select_db($banco, $conecta);
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');



            $xml_cadfab = simplexml_load_file("cadfab/cadfab.xml");
            foreach ($xml_cadfab as $cadfab) {
                $CODFABRINCANTE = $cadfab->manufacturer_id;
                $NOMEFABRICANTE = $cadfab->name;



                $cadfabrincante = mysql_query("SELECT COUNT(*) AS Total_Fab
                                       FROM oc_manufacturer 
                                       WHERE manufacturer_id = '$CODFABRINCANTE' ");
                $total_fab = mysql_result($cadfabrincante, 0, 'Total_Fab');

                if ($total_fab < 1) {
                    $sql_cadfab = "INSERT INTO oc_manufacturer
                                      (manufacturer_id,
                                       name,
                                       sort_order
                                       )VALUES(
                                      '$CODFABRINCANTE',
                                      '$NOMEFABRICANTE',
                                       0) ";
                    $execulta = mysql_query($sql_cadfab, $conecta);

                    $manufacturer_to_store = mysql_query("INSERT INTO oc_manufacturer_to_store 
                                                      (manufacturer_id,
                                                       store_id
                                                       )VALUES('$CODFABRINCANTE',
                                                       0 )");
                } else {

                    $sql_cadfab = "UPDATE oc_manufacturer SET
                                       name = '$NOMEFABRICANTE',
                                       sort_order = '0'
                                       WHERE
                                       manufacturer_id =  '$CODFABRINCANTE'
                                       ";

                    $execulta = mysql_query($sql_cadfab, $conecta);
                }
            }
        }
    }
} else {
    
}


//FIM DO FABRICANTES
//INICIO DE OPÇOES



if (is_dir("opcoes")) {



    if (file_exists("opcoes/opcoes.xml")) {

        foreach ($conn as $c => $y) {

            $arr = $y;
            foreach ($arr as $z => $y) {
                if ($z == "IP")
                    $ip = $y;
                if ($z == "LOGIN")
                    $login = $y;
                if ($z == "SENHA")
                    $senha = $y;
                if ($z == "BANCO")
                    $banco = $y;
            }

            $conecta = mysql_connect($ip, $login, $senha);
            mysql_select_db($banco, $conecta);
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');


            $xml = simplexml_load_file("opcoes/opcoes.xml");

            foreach ($xml as $categoria) {
                //tabela option
                $id_option = $categoria->option->option_id;
                $type = $categoria->option->type;
                $sort_order = $categoria->option->sort_order;
                //fim tabela option

                $conta_opt = mysql_query("SELECT COUNT(*) AS TotalOpt
                                  FROM `oc_option`
                                  WHERE option_id = '$id_option'  ");
                $total_opt = mysql_result($conta_opt, 0, 'TotalOpt');

                if ($total_opt < 1) {

                    //     echo "inserir opcao<br />";



                    $categoria_cad = "INSERT INTO `oc_option` 
		               (`oc_option`.option_id,
                                `oc_option`.type,
                                `oc_option`.sort_order
				)VALUES(
                                '$id_option',
                                '$type',
                                '$sort_order'    
                                 )";
                    $execulta = mysql_query($categoria_cad, $conecta);



                    //tabela option_description
                    $id_option = $categoria->option_description->option_id;
                    $name = $categoria->option_description->name;
                    $language_id = $categoria->option_description->language_id;
                    //fim tabela option_description

                    $option_description = "INSERT INTO `oc_option_description` 
                                    (`oc_option_description`.option_id,
                                     `oc_option_description`.name,
                                     `oc_option_description`.language_id
                                     )VALUES(
                                     '$id_option',
                                     '$name',
                                     '$language_id'    
                                      )";
                    $execulta = mysql_query($option_description, $conecta);



                    foreach ($categoria->option_value as $item) {

                        //tabela option_value
                        $id_option = $item->option_id;
                        $image = $item->image;
                        $sort_order = $item->sort_order;
                        $icodintopcoes = $item->icodintopcoes;
                        //fim option_value

                        $option_value = "INSERT INTO `oc_option_value` 
		               (`oc_option_value`.option_value_id,
                                `oc_option_value`.option_id,
                                `oc_option_value`.image,
                                `oc_option_value`.sort_order
				)VALUES(
                                '$icodintopcoes',
                                '$id_option',
                                '$image',
                                '$sort_order'
                                 )";
                        $execulta = mysql_query($option_value, $conecta);
                    }

                    foreach ($categoria->option_value_description as $item1) {

                        $id_option = $item1->option_id;
                        $name = $item1->name;
                        $language_id = $item1->language_id;
                        $icodintopcoes = $item1->icodintopcoes;

                        $option_value_description = "INSERT INTO `oc_option_value_description` 
                                        (`oc_option_value_description`.option_value_id,
                                         `oc_option_value_description`.option_id,
                                         `oc_option_value_description`.name,
                                         `oc_option_value_description`.language_id
                                         )VALUES(
                                         '$icodintopcoes',
                                         '$id_option',
                                         '$name',
                                         '$language_id'
                                          )";
                        $execulta = mysql_query($option_value_description, $conecta);
                    }
                } else {

                    //  echo "update opcao<br />";
                    if (file_exists("opcoes.xml")) {

                        $xml = simplexml_load_file("opcoes.xml");

                        foreach ($xml as $categoria) {
                            //tabela option
                            $id_option = $categoria->option->option_id;
                            $type = $categoria->option->type;
                            $sort_order = $categoria->option->sort_order;

                            $categoria_cad = "UPDATE `oc_option` SET
		                 `oc_option`.type = '$type',
                                 `oc_option`.sort_order = '$sort_order'
				  WHERE `oc_option`.option_id = '$id_option'
				  ";

                            $execulta = mysql_query($categoria_cad, $conecta);


                            $id_option = $categoria->option_description->option_id;
                            $name = $categoria->option_description->name;
                            $language_id = $categoria->option_description->language_id;


                            $conta_opt_des = mysql_query("SELECT COUNT(*) AS TotalOptDesc
                                  FROM `oc_option_description`
                                  where
                                  `oc_option_description`.name = '$name'
                                  and
                                  `oc_option_description`.language_id = '$language_id'
                                  and
                                  `oc_option_description`.option_id = '$id_option'
                                    ");
                            $total_opt_desc = mysql_result($conta_opt_des, 0, 'TotalOptDesc');

                            if ($total_opt_desc < 1) {

                                $option_description = "INSERT INTO `oc_option_description` 
                                    (`oc_option_description`.option_id,
                                     `oc_option_description`.name,
                                     `oc_option_description`.language_id
                                     )VALUES(
                                     '$id_option',
                                     '$name',
                                     '$language_id'    
                                      )";
                                $execulta = mysql_query($option_description, $conecta);

                                //    echo "insert option_description<br /> ";
                            } else {
                                //     echo "update option_description<br /> ";

                                $option_description = "UPDATE `oc_option_description` SET 
                                                        `oc_option_description`.name = '$name',
                                                        `oc_option_description`.language_id = '$language_id'
                                                         WHERE `oc_option_description`.option_id = '$id_option'
                                      ";
                                $execulta = mysql_query($option_description, $conecta);
                            }









                            foreach ($categoria->option_value as $item) {


                                $id_option = $item->option_id;
                                $image = $item->image;
                                $sort_order = $item->sort_order;
                                $icodintopcoes = $item->icodintopcoes;


                                $conta_opt_val = mysql_query("SELECT COUNT(*) AS TotalOptVal
                                  FROM `oc_option_value`
                                  where
                                 `oc_option_value`.option_id = '$id_option'
                                     and
                                 `oc_option_value`.image = '$image'
                                     and
                                 `oc_option_value`.sort_order = '$sort_order'
                                     and
                                 `oc_option_value`.option_value_id = '$icodintopcoes'
                                    ");
                                $total_opt_val = mysql_result($conta_opt_val, 0, 'TotalOptVal');

                                if ($total_opt_val < 1) {

                                    $option_value = "INSERT INTO `oc_option_value` 
		               (`oc_option_value`.option_value_id,
                                `oc_option_value`.option_id,
                                `oc_option_value`.image,
                                `oc_option_value`.sort_order
				)VALUES(
                                '$icodintopcoes',
                                '$id_option',
                                '$image',
                                '$sort_order'
                                 )";
                                    $execulta = mysql_query($option_value, $conecta);

                                    //   echo "insert option_value<br /> ";
                                } else {
                                    //       echo "update option_value<br /> ";

                                    $option_value = "UPDATE `oc_option_value` SET
                                `oc_option_value`.option_id = '$id_option',
                                `oc_option_value`.image = '$image',
                                `oc_option_value`.sort_order = '$sort_order'
                                 WHERE `oc_option_value`.option_value_id = '$icodintopcoes'
								  ";
                                    $execulta = mysql_query($option_value, $conecta);
                                }
                            }



                            foreach ($categoria->option_value_description as $item1) {

                                $id_option = $item1->option_id;
                                $name = $item1->name;
                                $language_id = $item1->language_id;
                                $icodintopcoes = $item1->icodintopcoes;




                                $conta_opt_val_desc = mysql_query("SELECT COUNT(*) AS TotalOptValDesc
                                  FROM `oc_option_value_description`
                                  where
                                  `oc_option_value_description`.option_id = '$id_option'
                                      and
                                  `oc_option_value_description`.name = '$name'
                                      and
                                  `oc_option_value_description`.language_id = '$language_id'
                                      and
                                  `oc_option_value_description`.option_value_id  = '$icodintopcoes'
                                    ");
                                $total_opt_val_desc = mysql_result($conta_opt_val_desc, 0, 'TotalOptValDesc');

                                if ($total_opt_val_desc < 1) {

                                    $option_value_description = "INSERT INTO `oc_option_value_description` 
                                        (`oc_option_value_description`.option_value_id,
                                         `oc_option_value_description`.option_id,
                                         `oc_option_value_description`.name,
                                         `oc_option_value_description`.language_id
                                         )VALUES(
                                         '$icodintopcoes',
                                         '$id_option',
                                         '$name',
                                         '$language_id'
                                          )";
                                    $execulta = mysql_query($option_value_description, $conecta);

                                    //    echo "insert option_value_description<br /> ";
                                } else {
                                    //   echo "update option_value_description<br /> ";

                                    $option_value_description = "UPDATE `oc_option_value_description` SET 
                                         `oc_option_value_description`.option_id = '$id_option',
                                         `oc_option_value_description`.name = '$name',
                                         `oc_option_value_description`.language_id = '$language_id'
                                          WHERE `oc_option_value_description`.option_value_id  = '$icodintopcoes'
					 ";
                                    $execulta = mysql_query($option_value_description, $conecta);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    
}

//FIM DO OPÇÕES
//INICIO UNIDADE DE MEDIDA




if (is_dir("unimedida")) {

    foreach ($conn as $c => $y) {

        $arr = $y;
        foreach ($arr as $z => $y) {
            if ($z == "IP")
                $ip = $y;
            if ($z == "LOGIN")
                $login = $y;
            if ($z == "SENHA")
                $senha = $y;
            if ($z == "BANCO")
                $banco = $y;
        }

        $conecta = mysql_connect($ip, $login, $senha);
        mysql_select_db($banco, $conecta);
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');






        if (file_exists("unimedida/unimedida.xml")) {
            $xml = simplexml_load_file("unimedida/unimedida.xml");
            foreach ($xml as $categoria) {

                $language_id = $categoria->language_id;
                $title = $categoria->title;
                $unit = $categoria->unit;
                $value = $categoria->value;

                $conta_uni = mysql_query("SELECT COUNT(*) AS TotalUni
                                  FROM oc_length_class_description
                                  WHERE unit = '$unit'  ");
                $total_uni = mysql_result($conta_uni, 0, 'TotalUni');


                //CASO AINDA NÃO TENHA A UNIDADE DE MEDIDA CADASTRADA VAI SER FEITA A INSERÇÃO
                if ($total_uni < 1) {

                    $cad_undidade = "INSERT INTO oc_length_class_description 
                              (language_id,
                              title,
                              unit
                              )VALUES(
                              '$language_id',
                              '$title',
                              '$unit'
                              ) ";
                    $execulta = mysql_query($cad_undidade, $conecta);
                    $ultimo_id_unidade = mysql_insert_id($conecta);

                    //VAI INSERIR DE ACORDO COM A ULTIMA INSERÇÃO 
                    $length_class_insert = mysql_query("INSERT INTO oc_length_class 
                                                (length_class.length_class_id,
                                                 length_class.value
                                                 )VALUES(
                                                 '$ultimo_id_unidade',
                                                 '$value' )");
                } else {
                    //SE EXISTIR VAI FAZER O UPDATE SOMENTE EM UMA TABELA 
                    $categoria_cad = "UPDATE oc_length_class_description SET 
                              language_id = '$language_id',
                              title = '$title'
                              WHERE 
                              unit = '$unit'
                            ";
                    $execulta = mysql_query($categoria_cad, $conecta);
                }
            }
        }
    }
} else {
    
}



//FIM UNIDADE DE MEDIDA
// CADASTRO DE PRODUTOS




if (is_dir("cadpro")) {




    $path = "cadpro/";
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read()) {


        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($extensao == "xml") {

            $QUEBRA = explode(".", $arquivo);
            $NOME = explode("_", $QUEBRA[0]);
            $IDPRODUTO = $NOME[0];
            $CTIPOVENDA = $NOME[1];



            if ($CTIPOVENDA <> '') {

                if ($CTIPOVENDA == "A") {
                    //   echo 'Vai se conectar no banco de dados que é de Varejo <br />';
                    $conecta = mysql_connect($ip, $login, $senha);
                    mysql_select_db($banco, $conecta);
                    mysql_query('SET character_set_connection=utf8');
                    mysql_query('SET character_set_client=utf8');
                    mysql_query('SET character_set_results=utf8');
                }

                if ($CTIPOVENDA == "V") {
                    //   echo 'Vai se conectar no banco de dados que é de Atacado <br />'; 
                    $conecta = mysql_connect($ip, $login, $senha);
                    mysql_select_db($banco, $conecta);
                    mysql_query('SET character_set_connection=utf8');
                    mysql_query('SET character_set_client=utf8');
                    mysql_query('SET character_set_results=utf8');
                }


                if (file_exists("cadpro/" . $arquivo)) { //SE O ARQUIVO EXISTIR ABRIR ELE
                    $xml = simplexml_load_file("cadpro/" . $arquivo); //LÊ O ARQUIVO

                    $ver_registo_product = mysql_query("SELECT COUNT(*) AS Total FROM oc_product WHERE product_id ='$IDPRODUTO' ");
                    $total = mysql_result($ver_registo_product, 0, 'Total');
                    //VERIFICA SE O PRODUTO EXISTE OU NÃO

                    //  echo $total."<br />";

                    if ($total < 1) {
                        //    echo 'O produto ainda não foi cadastrado na base <br />'; 

                        foreach ($xml as $produto) {


                            $product_id     = $produto->product->product_id; //id do produto
                            $model = $produto->product->model; //referencia do produto que vai ser mostrado na loja
                            $sku = $produto->product->sku; //não é utlizado mais deve ser vazio
                            $upc = $produto->product->upc; //não é utlizado mais deve ser vazio
                            $ean = $produto->product->ean; //não é utlizado mais deve ser vazio
                            $jan = $produto->product->jan; //não é utlizado mais deve ser vazio
                            $isbn = $produto->product->isbn; //não é utlizado mais deve ser vazio
                            $mpn = $produto->product->mpn; //não é utlizado mais deve ser vazio
                            $location = $produto->product->location; //não é utlizado mais deve ser vazio         
                            $quantity = $produto->product->quantity; //quantidade de produto para o estoque que será apresentado na loja         
                            $stock_status_id = $produto->product->stock_status_id; //define a situação do estoque
                            $image = $produto->product->image; //imagem principal do produto
                            $manufacturer_id = $produto->product->manufacturer_id; //passar 1
                            $shipping = $produto->product->shipping; //passar 1
                            $price = $produto->product->price; //preço de venda do produto
                            $points = $produto->product->points; //pontos que ganha quando compra o produto para proxima compra, passar sempre 0
                            $tax_class_id = $produto->product->tax_class_id; //passar sempre 0 
                            $date_available = $produto->product->date_available; //está gerando a data atual quando gera o xml
                            $weight = $produto->product->weight; //peso
                            $weight_class_id = $produto->product->weight_class_id; //passar 1
                            $lenght = $produto->product->lenght; //comprimento
                            $width = $produto->product->width; //largura
                            $height = $produto->product->height; //altura
                            $lenght_class_id = $produto->product->lenght_class_id; //passar 1
                            $subtract = $produto->product->subtract; //passar 1
                            $minimum = $produto->product->minimum; //minimo de produtos pode ser comprado por produto
                            $sort_order = $produto->product->sort_order; //ordem que vai aparecer o produto
                            $status = $produto->product->status; //produto ativo ou não
                            //$status = 1; //produto ativo ou não
                            $date_added = $produto->product->date_added; //data que foi adicionado o produto
                            $date_modified = $produto->product->date_modified; //data que foi modificado o produto
                            $icodintprosis = $produto->product->icodintprosis;
                            $ccodprosis = $produto->product->ccodprosis;
                            $prodrel = $produto->product->prodrel;



                            //PRIMEIRA COISA É VERIFICAR SE EXISTE URL_AMIGAVEL E APLICAR SE NÃO OUVER
                            $ver_url_amigavel_produto = mysql_query("SELECT COUNT(*) AS Total_url
                                   				      FROM oc_url_alias 
                                                                      WHERE query = CONCAT('product_id=','$product_id')  ");
                            $total_url = mysql_result($ver_url_amigavel_produto, 0, 'Total_url');
                            if ($total_url > 0) {

                                $nproduto = str_replace('/', '-', $model);
                                $modelproduto = removeAcentos($nproduto, '-');
                                $query = "product_id=" . $product_id;

                                $sql_url_amigavel_update = "UPDATE oc_url_alias 
							    SET keyword = '$modelproduto'
							    WHERE `query` = '$query'  ";
                                $execulta_url_up = mysql_query($sql_url_amigavel_update, $conecta);
                                //  echo "O produto $product_id foi alterado a URL AMIGAVEL com êxito <br />";
                            } else {

                                $nproduto = str_replace('/', '-', $model);
                                $modelproduto = removeAcentos($nproduto, '-');
                                $query = "product_id=" . $product_id;

                                $sql_url_amigavel_inserir = "INSERT INTO oc_url_alias 
							    (query,
							     keyword
							     )VALUES(
							    '$query',
							    '$modelproduto')";
                                $execulta_url = mysql_query($sql_url_amigavel_inserir, $conecta);
                               // echo "O produto $product_id foi adicionado a URL AMIGAVEL com êxito <br />";
                            }
                            //FIM DA VERIFICAÇÃO E APLICAÇÃO DE URL_AMIGAVEL


                            $inserir_product = "INSERT INTO oc_product 
                                 (
                                    product_id,        
                                    model,             
                                    sku,               
                                    upc,               
                                    ean,               
                                    jan,              
                                    isbn,              
                                    mpn,               
                                    location,          
                                    quantity,          
                                    stock_status_id,   
                                    image,            
                                    manufacturer_id,   
                                    shipping,          
                                    price,             
                                    points,            
                                    tax_class_id,      
                                    date_available,    
                                    weight,            
                                    weight_class_id,   
                                    length,            
                                    width,             
                                    height,            
                                    length_class_id,   
                                    subtract,          
                                    minimum,           
                                    sort_order,        
                                    status,            
                                    date_added,        
                                    date_modified,
                                    icodintprosis,
                                    ccodprosis,
                                    prodrel
                                     )VALUES(
                                    '$product_id',        
                                    '$model',             
                                    '$sku',              
                                    '$upc',               
                                    '$ean',               
                                    '$jan',              
                                    '$isbn',              
                                    '$mpn',               
                                    '$location',          
                                    '$quantity',          
                                    '$stock_status_id',   
                                    '$image',             
                                    '$manufacturer_id',   
                                    '$shipping',          
                                    '$price',             
                                    '$points',            
                                    '$tax_class_id',      
                                     NOW(),    
                                    '$weight',            
                                    '$weight_class_id',   
                                    '$lenght',            
                                    '$width',            
                                    '$height',            
                                    '$lenght_class_id',   
                                    '$subtract',          
                                    '$minimum',           
                                    '$sort_order',        
                                    '$status',           
                                    '$date_added',        
                                    '$date_modified',
                                    '$icodintprosis',
                                    '$ccodprosis',
                                    '$prodrel'
                                  )";
                            //echo $inserir_product . "<br />";
                            //está inserindo normalmente
                            if (mysql_query($inserir_product, $conecta)) {
                                $ultimo_id_produtc = mysql_insert_id($conecta);


                                $inserir_product_to_store = "INSERT INTO oc_product_to_store(
                                               product_id,
                                               store_id
                                               )VALUES(
                                               '$product_id',
                                               '0')
                                               
                                               ";
                                $execulta_inserir_product_to_store = mysql_query($inserir_product_to_store, $conecta);





                                $product_id = $produto->product_description->product_id; //id do produto     
                                $language_id = $produto->product_description->language_id; //passar 2 para lingua em portugues     
                                $name = $produto->product_description->name; //nome do produto para aparecer na loja   
                                $description = $produto->product_description->description; //hmtl mostrado para aparesentar o que o produto é um texto para detalhar o produto  
                                $meta_title = $produto->product_description->name; //nome do produto para aparecer na loja   
                                $meta_description = $produto->product_description->meta_description; //ajuda nos buscadores
                                $meta_keyword = $produto->product_description->meta_keyword; //ajuda nos buscadores
                                $tag = $produto->product_description->tag; //passar vazio não existe no mult-win

                                $inserir_product_description = "INSERT INTO oc_product_description(              
                                               product_id,
                                               language_id,
                                               name,
                                               description,
											   meta_title,
                                               meta_description,
                                               meta_keyword,
                                               tag
                                               )VALUES(
                                               '$product_id',
                                               '$language_id',
                                               '$name',
                                               '$description',
                                               '$meta_title',
                                               '$meta_description',
                                               '$meta_keyword',
                                               '$tag'
                                               )
                                               ";
                                $execulta_product_description = mysql_query($inserir_product_description, $conecta);
                                // echo $inserir_product_description;




                                foreach ($produto->imagens->product_image as $fotos) {

                                    $produto1 = $fotos->product_id;
                                    $image1 = $fotos->image;
                                    $sort_order1 = $fotos->sort_order;
                                    $cimagem = $fotos->cimagem;

                                    $inserir_product_image1 = "INSERT INTO oc_product_image(
                                               product_id,
                                               image,
                                               sort_order,
					       cimagem
                                               )VALUES(
                                               '$produto1',
                                               '$image1',
                                               '$sort_order1',
											   '$cimagem'
                                               )
                                               ";
                                    $execulta_product_image1 = mysql_query($inserir_product_image1, $conecta);
                                }

                                /* ****************************
                                 * 
                                 * 
                                 * SE EXISTIR PRODUTOS RELACIONADOS
                                 * 
                                 * 
                                 * **************************** */
                                if (isset($produto->produtos_relacionados->product_option)) {

                                    foreach ($produto->produtos_relacionados->product_option as $item) {

                                        $PRODUCT_ID = $item->product_id;
                                        $OPTION_ID = $item->option_id;
                                        $OPTION_VALUE = $item->option_value;
                                        $REQUIRED = $item->required;

                                        $sql_option = "INSERT INTO  oc_product_option
                                            (product_id,
                                             option_id,
                                             option_value,
                                             required
                                             )VALUES(
                                             '$PRODUCT_ID',
                                             '$OPTION_ID',
                                             '$OPTION_VALUE',
                                             '$REQUIRED')    
                                             ";


                                        if (mysql_query($sql_option, $conecta)) {
                                            $ultimo_id_option = mysql_insert_id($conecta);


                                            foreach ($item->product_option_value as $item1) {


                                                $PRODUCT_ID = $item1->product_id;
                                                $OPTION_ID = $item1->option_id;
                                                $OPTION_VALUE_ID = $item1->option_value_id;
                                                $QUANTITY = $item1->quantity;
                                                $SUBTRACT = $item1->subtract;
                                                if ($SUBTRACT == "S") {
                                                    $SUBTRACT = 1;
                                                } else {
                                                    $SUBTRACT = 0;
                                                }
                                                $PRICE = $item1->price;
                                                $PRICE_PREFIX = $item1->price_prefix;
                                                $POINTS = $item1->points;
                                                $POINTS_PREFIX = $item1->points_prefix;
                                                $WEIGHT = $item1->weight;
                                                $WEIGHT_PREFIX = $item1->weight_prefix;
                                                $ICODINTPROSIS = $item1->icodintprosis;
                                                $CCODPROSIS = $item1->ccodprosis;



                                                $sql_option_value = "INSERT INTO oc_product_option_value 
                                                           (
                                                            product_option_id,
                                                            product_id,
                                                            option_id,
                                                            option_value_id,
                                                            quantity,
                                                            subtract,
                                                            price,
                                                            price_prefix,
                                                            points,
                                                            points_prefix,
                                                            weight,
                                                            weight_prefix,
                                                            icodintprosis,
                                                            ccodprosis)
                                                            VALUES
                                                           (
                                                            '$ultimo_id_option',
                                                            '$PRODUCT_ID',
                                                            '$OPTION_ID',
                                                            '$OPTION_VALUE_ID',
                                                            '$QUANTITY',
                                                            '$SUBTRACT',
                                                            '$PRICE',
                                                            '$PRICE_PREFIX',
                                                            '$POINTS',
                                                            '$POINTS_PREFIX',
                                                            '$WEIGHT',
                                                            '$WEIGHT_PREFIX',
                                                            '$ICODINTPROSIS',
                                                            '$CCODPROSIS'    
                                                            )
                                                            ";

                                                $execulta = mysql_query($sql_option_value, $conecta);
                                            }
                                        }//fim da inclusão do option
                                    }
                                }

                                /******************************
                                 * 
                                 * 
                                 * FIM EXISTIR PRODUTOS RELACIONADOS
                                 * 
                                 * 
                                 ***************************** */






                                /* ****************************
                                 * 
                                 * 
                                 * INICIO SE TIVER PROMOÇÃO
                                 * 
                                 * 
                                 * **************************** */


                                $product_id = $produto->product_special->product_id; //id do produto
                                $customer_group_id = $produto->product_special->customer_group_id; //vai passar sempre 1
                                $price = $produto->product_special->price; //preço de venda da promoção
                                $date_start = $produto->product_special->date_start; //preço de venda da promoção
                                $date_end = $produto->product_special->date_end; //preço de venda da promoção



                                $sql_product_special = "INSERT INTO oc_product_special 
                                                           (product_id,
                                                           customer_group_id,
                                                           priority,
                                                           price,
                                                           date_start,
                                                           date_end
                                                            )
                                                            VALUES
                                                           (
                                                           '$product_id',
                                                           '$customer_group_id',
                                                           '1',
                                                           '$price',
                                                           '$date_start',
                                                           '$date_end'
                                                            )
                                                            ";

                                $execulta = mysql_query($sql_product_special, $conecta);
                            }

                            foreach ($produto->product_to_category as $item) {

                                $PRODUCT_ID = $item->product_id;
                                $CATEGORY_ID = $item->category_id;

                                $sql_product_to_category = "INSERT INTO oc_product_to_category 
                                                           (product_id,
                                                           category_id
                                                            )
                                                            VALUES
                                                           (
                                                           '$PRODUCT_ID',
                                                           '$CATEGORY_ID'
                                                            )
                                                            ";

                                $execulta = mysql_query($sql_product_to_category, $conecta);
                            }
                        }
                    } else {
						
						
                    //     echo 'O produto ainda já foi cadastrado na base, necessita fazer o update <br />';


                        foreach ($xml as $produto) {

                            $product_id = $produto->product->product_id; //id do produto
                            $model = $produto->product->model; //referencia do produto que vai ser mostrado na loja
                            $sku = $produto->product->sku; //não é utlizado mais deve ser vazio
                            $upc = $produto->product->upc; //não é utlizado mais deve ser vazio
                            $ean = $produto->product->ean; //não é utlizado mais deve ser vazio
                            $jan = $produto->product->jan; //não é utlizado mais deve ser vazio
                            $isbn = $produto->product->isbn; //não é utlizado mais deve ser vazio
                            $mpn = $produto->product->mpn; //não é utlizado mais deve ser vazio
                            $location = $produto->product->location; //não é utlizado mais deve ser vazio         
                            $quantity = $produto->product->quantity; //quantidade de produto para o estoque que será apresentado na loja         
                            $stock_status_id = $produto->product->stock_status_id; //define a situação do estoque
                            $image = $produto->product->image; //imagem principal do produto
                            $manufacturer_id = $produto->product->manufacturer_id; //passar 1
                            $shipping = $produto->product->shipping; //passar 1
                            $price = $produto->product->price; //preço de venda do produto
                            $points = $produto->product->points; //pontos que ganha quando compra o produto para proxima compra, passar sempre 0
                            $tax_class_id = $produto->product->tax_class_id; //passar sempre 0 
                            $date_available = $produto->product->date_available; //está gerando a data atual quando gera o xml
                            $weight = $produto->product->weight; //peso
                            $weight_class_id = $produto->product->weight_class_id; //passar 1
                            $lenght = $produto->product->lenght; //comprimento
                            $width = $produto->product->width; //largura
                            $height = $produto->product->height; //altura
                            $lenght_class_id = $produto->product->lenght_class_id; //passar 1
                            $subtract = $produto->product->subtract; //passar 1
                            $minimum = $produto->product->minimum; //minimo de produtos pode ser comprado por produto
                            $sort_order = $produto->product->sort_order; //ordem que vai aparecer o produto
                            $status = $produto->product->status; //produto ativo ou não
                            //$status = 1; //produto ativo ou não
                            $date_added = $produto->product->date_added; //data que foi adicionado o produto
                            $date_modified = $produto->product->date_modified; //data que foi modificado o produto
                            $icodintprosis = $produto->product->icodintprosis;
                            $ccodprosis = $produto->product->ccodprosis;
                            $prodrel = $produto->product->prodrel;



                            //PRIMEIRA COISA É VERIFICAR SE EXISTE URL_AMIGAVEL E APLICAR SE NÃO OUVER
                            $ver_url_amigavel_produto = mysql_query("SELECT COUNT(*) AS Total_url 
																	 FROM oc_url_alias 
																	 WHERE query = CONCAT('product_id=','$product_id')  ");
                            $total_url = mysql_result($ver_url_amigavel_produto, 0, 'Total_url');
                            if ($total_url > 0) {

                                $nproduto = str_replace('/', '-', $model);
                                $modelproduto = removeAcentos($nproduto, '-');
                                $query = "product_id=" . $product_id;

                                $sql_url_amigavel_update = "UPDATE oc_url_alias 
							    SET keyword = '$modelproduto'
							    WHERE `query` = '$query'  ";
                                $execulta_url_up = mysql_query($sql_url_amigavel_update, $conecta);
                                //   echo "O produto $product_id foi alterado a URL AMIGAVEL com êxito <br />";
                            } else {

                                $nproduto = str_replace('/', '-', $model);
                                $modelproduto = removeAcentos($nproduto, '-');
                                $query = "product_id=" . $product_id;

                                $sql_url_amigavel_inserir = "INSERT INTO oc_url_alias 
							    (query,
							     keyword
								)VALUES(
							     '$query',
							     '$modelproduto')";
                                $execulta_url = mysql_query($sql_url_amigavel_inserir, $conecta);
                              //  echo "O produto $product_id foi adicionado a URL AMIGAVEL com êxito <br />";
                            }
                            //FIM DA VERIFICAÇÃO E APLICAÇÃO DE URL_AMIGAVEL






                            $inserir_product = "UPDATE oc_product SET 
                                    model = '$model',            
                                    sku = '$sku',            
                                    upc = '$upc',              
                                    ean = '$ean',          
                                    jan = '$jan',                
                                    isbn = '$isbn',              
                                    mpn = '$mpn',               
                                    location = '$location',         
                                    quantity = '$quantity',           
                                    stock_status_id = '$stock_status_id',    
                                    image = '$image',            
                                    manufacturer_id = '$manufacturer_id',  
                                    shipping = '$shipping',          
                                    price = '$price',             
                                    points = '$points',            
                                    tax_class_id = '$tax_class_id',       
                                    date_available ='$date_available',    
                                    weight = '$weight',            
                                    weight_class_id = '$weight_class_id',   
                                    length = '$lenght',            
                                    width = '$width',             
                                    height = '$height',              
                                    length_class_id = '$lenght_class_id',   
                                    subtract = '$subtract',           
                                    minimum = '$minimum',           
                                    sort_order = '$sort_order',       
                                    status = '$status',            
                                    date_modified = '$date_modified',
									date_added = '$date_added', 
                                    icodintprosis = '$icodintprosis',
                                    ccodprosis = '$ccodprosis',
                                    prodrel = '$prodrel'
                                    WHERE    product_id = '$product_id'    
                                    ";
                            $execulta = mysql_query($inserir_product, $conecta);


                            $inserir_product_to_store = "UPDATE  oc_product_to_store SET
                                                store_id = '0'
                                                WHERE
                                                product_id = '$product_id' ";
                            $execulta_inserir_product_to_store = mysql_query($inserir_product_to_store, $conecta);



                            $product_id = $produto->product_description->product_id; //id do produto     
                            $language_id = $produto->product_description->language_id; //passar 2 para lingua em portugues     
                            $name = $produto->product_description->name; //nome do produto para aparecer na loja   
                            $description = $produto->product_description->description; //hmtl mostrado para aparesentar o que o produto é um texto para detalhar o produto  
                            $meta_description = $produto->product_description->meta_description; //ajuda nos buscadores
                            $meta_keyword = $produto->product_description->meta_keyword; //ajuda nos buscadores
                            $tag = $produto->product_description->tag; //passar vazio não existe no mult-win


                            $inserir_product_description = "UPDATE oc_product_description SET              
                                            language_id = '$language_id',
                                            name = '$name',
                                            description = '$description',
                                            meta_title = '$name',
                                            meta_description = '$meta_description',
                                            meta_keyword = '$meta_keyword',
                                            tag = '$tag'
                                            WHERE product_id = '$product_id'
                                            ";
                            $execulta_product_description = mysql_query($inserir_product_description, $conecta);


                            foreach ($produto->imagens->product_image as $fotos) {

                                $produto1 = $fotos->product_id;
                                $image1 = $fotos->image;
                                $sort_order1 = $fotos->sort_order;
                                $cimagem = $fotos->cimagem;



                                $ver_img = mysql_query("SELECT COUNT(*) AS TotalIMG 
                                           FROM oc_product_image
                                           WHERE product_id = '$product_id'
                                           AND cimagem = '$cimagem' ");
                                $totalIMG = mysql_result($ver_img, 0, 'TotalIMG');

                                if ($totalIMG < 1) {


                                    $inserir_product_image1 = "INSERT INTO oc_product_image(
                                               product_id,
                                               image,
                                               sort_order,
											   cimagem
                                               )VALUES(
                                               '$produto1',
                                               '$image1',
                                               '$sort_order1',
											   '$cimagem'
                                               )
                                               ";
                                    $execulta_product_image1 = mysql_query($inserir_product_image1, $conecta);
                                } else {
                                    $inserir_product_image1 = "UPDATE oc_product_image SET
                                               image = '$image',
                                               sort_order = '$sort_order'
                                               WHERE product_id = '$product_id'
										       AND cimagem = '$cimagem'
                                               )
                                               ";
                                    $execulta_product_image1 = mysql_query($inserir_product_image1, $conecta);
                                }
                            }



                            /*                             * ****************************
                             * 
                             * 
                             * SE EXISTIR PRODUTOS RELACIONADOS
                             * 
                             * 
                             * **************************** */

                            if (isset($produto->produtos_relacionados->product_option)) {


                                foreach ($produto->produtos_relacionados->product_option as $item) {

                                    $PRODUCT_ID = $item->product_id;
                                    $OPTION_ID = $item->option_id;
                                    $OPTION_VALUE = $item->option_value;
                                    $REQUIRED = $item->required;


//                 echo "<pre>";
//                 print_r($item);
//                 echo "</pre>";

                                    $ver_product_option = mysql_query("SELECT COUNT(*) AS TotalOpt 
                                           FROM oc_product_option
                                           WHERE product_id = '$product_id'
                                           AND option_id = '$OPTION_ID' ");
                                    $totalOpt = mysql_result($ver_product_option, 0, 'TotalOpt');

                                    //  echo $ver_product_option;

                                    if ($totalOpt < 1) {

                                        $PRODUCT_ID = $item->product_id;
                                        $OPTION_ID = $item->option_id;
                                        $OPTION_VALUE = $item->option_value;
                                        $REQUIRED = $item->required;

                                        $sql_option = "INSERT INTO  oc_product_option
                                            (product_id,
                                             option_id,
                                             option_value,
                                             required
                                             )VALUES(
                                             '$PRODUCT_ID',
                                             '$OPTION_ID',
                                             '$OPTION_VALUE',
                                             '$REQUIRED')    
                                             ";


                                        if (mysql_query($sql_option, $conecta)) {
                                            $ultimo_id_option = mysql_insert_id($conecta);


                                            foreach ($item->product_option_value as $item1) {


                                                $PRODUCT_ID = $item1->product_id;
                                                $OPTION_ID = $item1->option_id;
                                                $OPTION_VALUE_ID = $item1->option_value_id;
                                                $QUANTITY = $item1->quantity;
                                                $SUBTRACT = $item1->subtract;
                                                if ($SUBTRACT == "S") {
                                                    $SUBTRACT = 1;
                                                } else {
                                                    $SUBTRACT = 0;
                                                }
                                                $PRICE = $item1->price;
                                                $PRICE_PREFIX = $item1->price_prefix;
                                                $POINTS = $item1->points;
                                                $POINTS_PREFIX = $item1->points_prefix;
                                                $WEIGHT = $item1->weight;
                                                $WEIGHT_PREFIX = $item1->weight_prefix;
                                                $ICODINTPROSIS = $item1->icodintprosis;
                                                $CCODPROSIS = $item1->ccodprosis;



                                                $sql_option_value = "INSERT INTO oc_product_option_value 
                                                           (
                                                            product_option_id,
                                                            product_id,
                                                            option_id,
                                                            option_value_id,
                                                            quantity,
                                                            subtract,
                                                            price,
                                                            price_prefix,
                                                            points,
                                                            points_prefix,
                                                            weight,
                                                            weight_prefix,
                                                            icodintprosis,
                                                            ccodprosis)
                                                            VALUES
                                                           (
                                                            '$ultimo_id_option',
                                                            '$PRODUCT_ID',
                                                            '$OPTION_ID',
                                                            '$OPTION_VALUE_ID',
                                                            '$QUANTITY',
                                                            '$SUBTRACT',
                                                            '$PRICE',
                                                            '$PRICE_PREFIX',
                                                            '$POINTS',
                                                            '$POINTS_PREFIX',
                                                            '$WEIGHT',
                                                            '$WEIGHT_PREFIX',
                                                            '$ICODINTPROSIS',
                                                            '$CCODPROSIS'    
                                                            )
                                                            ";

                                                $execulta = mysql_query($sql_option_value, $conecta);
                                            }
                                        }

                                        //   echo "não tem<br />"; 
                                    } else {
                                        //   echo "tem<br />"; 

                                        $sel = mysql_query("SELECT *
                                   FROM oc_product_option
                                   WHERE
                                   product_id = '$product_id'  AND
                                   option_id = '$OPTION_ID'
						  ");
                                        //    print_r($sel);
                                        while ($dados = mysql_fetch_array($sel)) {
                                            $product_option_id = $dados["product_option_id"];
                                        }

                                        foreach ($item->product_option_value as $item1) {


                                            $PRODUCT_ID = $item1->product_id;
                                            $OPTION_ID = $item1->option_id;
                                            $OPTION_VALUE_ID = $item1->option_value_id;
                                            $QUANTITY = $item1->quantity;
                                            $SUBTRACT = $item1->subtract;
                                            if ($SUBTRACT == "S") {
                                                $SUBTRACT = 1;
                                            } else {
                                                $SUBTRACT = 0;
                                            }
                                            $PRICE = $item1->price;
                                            $PRICE_PREFIX = $item1->price_prefix;
                                            $POINTS = $item1->points;
                                            $POINTS_PREFIX = $item1->points_prefix;
                                            $WEIGHT = $item1->weight;
                                            $WEIGHT_PREFIX = $item1->weight_prefix;
                                            $ICODINTPROSIS = $item1->icodintprosis;
                                            $CCODPROSIS = $item1->ccodprosis;

//                 echo "<pre>";
//                 print_r($item1);
//                 echo "</pre>";
//                  
                                            $ver_product_option_value = mysql_query("SELECT COUNT(*) AS TotalOptValue 
                                           FROM oc_product_option_value
                                           WHERE  
                                           product_id        = '$PRODUCT_ID' AND
                                           option_id         = '$OPTION_ID' AND
                                           option_value_id   = '$OPTION_VALUE_ID' AND
                                           product_option_id = '$product_option_id'    
                                           
                                           ");
										   
										   /*
										   echo "SELECT COUNT(*) AS TotalOptValue 
                                           FROM product_option_value
                                           WHERE  
                                           product_id        = '$PRODUCT_ID' AND
                                           option_id         = '$OPTION_ID' AND
                                           option_value_id   = '$OPTION_VALUE_ID' AND
                                           product_option_id = '$product_option_id'    
                                           <br /><br />
                                           ";
										   */
                                            $totalOptValue = mysql_result($ver_product_option_value, 0, 'TotalOptValue');



                                            if ($totalOptValue < 1) {
                                              //   echo "não tem o valor <br />";

                                                $sql_option_value = "INSERT INTO oc_product_option_value 
                                                           (
                                                            product_option_id,
                                                            product_id,
                                                            option_id,
                                                            option_value_id,
                                                            quantity,
                                                            subtract,
                                                            price,
                                                            price_prefix,
                                                            points,
                                                            points_prefix,
                                                            weight,
                                                            weight_prefix,
                                                            icodintprosis,
                                                            ccodprosis)
                                                            VALUES
                                                           (
                                                            '$product_option_id',
                                                            '$PRODUCT_ID',
                                                            '$OPTION_ID',
                                                            '$OPTION_VALUE_ID',
                                                            '$QUANTITY',
                                                            '$SUBTRACT',
                                                            '$PRICE',
                                                            '$PRICE_PREFIX',
                                                            '$POINTS',
                                                            '$POINTS_PREFIX',
                                                            '$WEIGHT',
                                                            '$WEIGHT_PREFIX',
                                                            '$ICODINTPROSIS',
                                                            '$CCODPROSIS'    
                                                            )
                                                            ";

                                                $execulta = mysql_query($sql_option_value, $conecta);
                                            } else {
                                           //      echo "tem o valor <br />";

                                                $sql_option_value = "UPDATE oc_product_option_value SET 
                                    quantity =' $QUANTITY',
                                    subtract = '$SUBTRACT', 
                                    price = '$PRICE',
                                    price_prefix = '$PRICE_PREFIX',
                                    points = '$POINTS',
                                    points_prefix = '$POINTS_PREFIX',
                                    weight = '$WEIGHT',
                                    weight_prefix = '$WEIGHT_PREFIX',
                                    icodintprosis = '$ICODINTPROSIS',
                                    ccodprosis = '$CCODPROSIS'
                                    WHERE
                                    product_id        = '$PRODUCT_ID' AND
                                    option_id         = '$OPTION_ID' AND
                                    option_value_id   = '$OPTION_VALUE_ID' AND
                                    product_option_id = '$product_option_id'
                                    ";
									
									/*
									echo "UPDATE product_option_value SET 
                                    quantity =' $QUANTITY',
                                    subtract = '$SUBTRACT', 
                                    price = '$PRICE',
                                    price_prefix = '$PRICE_PREFIX',
                                    points = '$POINTS',
                                    points_prefix = '$POINTS_PREFIX',
                                    weight = '$WEIGHT',
                                    weight_prefix = '$WEIGHT_PREFIX',
                                    icodintprosis = '$ICODINTPROSIS',
                                    ccodprosis = '$CCODPROSIS'
                                    WHERE
                                    product_id        = '$PRODUCT_ID' AND
                                    option_id         = '$OPTION_ID' AND
                                    option_value_id   = '$OPTION_VALUE_ID' AND
                                    product_option_id = '$product_option_id'
                                    <br />"; 
									*/
                                                $execulta = mysql_query($sql_option_value, $conecta);
                                            }//fim fo if
                                        }//fim do foreach
                                    }
                                }
                            }

                            /*                             * ****************************
                             * 
                             * 
                             * FIM EXISTIR PRODUTOS RELACIONADOS
                             * 
                             * 
                             * **************************** */

                            /*                             * ****************************
                             * 
                             * 
                             * INICIO SE TIVER PROMOÇÃO
                             * 
                             * 
                             * **************************** */
                            //  echo "aqui";

                            $product_id = $produto->product_special->product_id; //id do produto
                            $customer_group_id = $produto->product_special->customer_group_id; //vai passar sempre 1
                            $price = $produto->product_special->price; //preço de venda da promoção
                            $date_start = $produto->product_special->date_start; //preço de venda da promoção
                            $date_end = $produto->product_special->date_end; //preço de venda da promoção


                            $ver_product_special = mysql_query("SELECT COUNT(*) AS TotalSpecial 
                                           FROM oc_product_special
                                           WHERE  
                                           product_id  = '$product_id'
                                           ");
                            $totalEspecial = mysql_result($ver_product_special, 0, 'TotalSpecial');



                            if ($totalEspecial < 1) {

                                //     echo "não tem<br />";

                                $sql_product_special = "INSERT INTO oc_product_special 
                                                           (product_id,
                                                           customer_group_id,
                                                           priority,
                                                           price,
                                                           date_start,
                                                           date_end
                                                            )
                                                            VALUES
                                                           (
                                                           '$product_id',
                                                           '$customer_group_id',
                                                           '1',
                                                           '$price',
                                                           '$date_start',
                                                           '$date_end'
                                                            )
                                                            ";

                                $execulta = mysql_query($sql_product_special, $conecta);
                            } else {

                                //   echo "tem<br />";

                                $sql_product_special = "UPDATE oc_product_special SET 
                                    customer_group_id  = '$customer_group_id',
                                    priority = '1',
                                    price = '$price',
                                    date_start = '$date_start',
                                    date_end = '$date_end'
                                    WHERE product_id =  '$product_id'  ";
                                $execulta = mysql_query($sql_product_special, $conecta);
                            }









                            foreach ($produto->product_to_category as $item) {

                                $PRODUCT_ID = $item->product_id;
                                $CATEGORY_ID = $item->category_id;



                                $ver_product_cat = mysql_query("SELECT COUNT(*) AS TotalCat 
                                           FROM oc_product_to_category
                                           WHERE  
                                           product_id  = '$PRODUCT_ID'
                                           AND  category_id = '$CATEGORY_ID'
                                           ");
                                $TotalCat = mysql_result($ver_product_cat, 0, 'TotalCat');



                                if ($TotalCat < 1) {


                                    $sql_product_to_category = "INSERT INTO oc_product_to_category 
                                                           (product_id,
                                                           category_id
                                                            )
                                                            VALUES
                                                           (
                                                           '$PRODUCT_ID',
                                                           '$CATEGORY_ID'
                                                            )
                                                            ";

                                    $execulta = mysql_query($sql_product_to_category, $conecta);
                                } else {
                                    $sql_product_to_category = "UPDATE oc_product_to_category SET
                                     category_id = '$CATEGORY_ID'
                                     WHERE product_id = '$PRODUCT_ID'
                                     ";
                                    $execulta = mysql_query($sql_product_to_category, $conecta);
                                }
                            }
                        }
                    }
                }

                /*                 * **************************************************************************************************************
                 * 
                 *  FIM DA INSERÇÃO OU ALTERAÇÃO DO CADASTRO DE PRODUTOS
                 *  FINALIZADO DIA 10/01/2014
                 * 
                 * ************************************************************************************************************* */
            }
        
		
		
		
		/*

    if ($CTIPOVENDA <> '') {

        if ($CTIPOVENDA == "A") {


            $conecta = mysql_connect($ip, $login, $senha);
            mysql_select_db($banco, $conecta);
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');


            $ver_produto_cadastrado = mysql_query("SELECT COUNT(product_id) AS Total_Pro FROM oc_product
                                         		 WHERE product_id =  '$PRODUCT_ID'  ");
            $total_produto = mysql_result($ver_produto_cadastrado, 0, 'Total_Pro');
            if ($total_produto > 0) {

                $ver_up = mysql_query("UPDATE oc_product SET status = 0
                                         		 WHERE product_id =  '$PRODUCT_ID'  ");


                //	echo "Categoria existe mais é do Varejo, fazer o Update de deixar o Status como desativado<br />";
            }
        }

        if ($CTIPOVENDA == "V") {

            $conecta = mysql_connect($ip, $login, $senha);
            mysql_select_db($banco, $conecta);
            mysql_query('SET character_set_connection=utf8');
            mysql_query('SET character_set_client=utf8');
            mysql_query('SET character_set_results=utf8');

            $ver_produto_cadastrado = mysql_query("SELECT COUNT(product_id) AS Total_Pro FROM oc_product
                                         		 WHERE product_id =  '$PRODUCT_ID'  ");
            $total_produto = mysql_result($ver_produto_cadastrado, 0, 'Total_Pro');
            if ($total_produto > 0) {
                //	echo "Categoria existe mais é do Atacado, fazer o Update de deixar o Status como desativado<br />";

                $ver_up = mysql_query("UPDATE oc_product SET status = 0
                                         		 WHERE product_id =  '$PRODUCT_ID'  ");
            }
        }
    }
	*/
	
		
		
		
		}
    }




   
} else {
    
}


//FIM DO CADASTRO DE PRODUTOS
// RELAÇÃO DE PRODUTOS


 $path = "cadpro/";
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read()) {
        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($extensao == "xml") {
       //unlink("cadpro/" . $arquivo);
        }
    }



if (is_dir("relcategorias")) {

    $path = "relcategorias/";
    $diretorio = dir($path);
    while ($arquivo = $diretorio->read()) {





        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($extensao == "xml") {


            $QUEBRA = explode(".", $arquivo);
            $NOME = explode("_", $QUEBRA[0]);
            $IDPRODUTO = $NOME[0];
            $CTIPOVENDA = $NOME[1];


            if (file_exists("relcategorias/" . $arquivo)) { //SE O ARQUIVO EXISTIR ABRIR ELE
                $xml = simplexml_load_file("relcategorias/" . $arquivo); //LÊ O ARQUIVO
                // echo $IDPRODUTO."<br />";


                if ($CTIPOVENDA <> '') {


                    if ($CTIPOVENDA == "A") {




                        foreach ($xml as $destaque) {
                            for ($x = 0; $x < count($destaque->product_id); $x++) {
                                $array_atacado[] = "(" . $destaque->product_id . ", " . $destaque->related_id . ")";
                            }
                        }
                    }




                    if ($CTIPOVENDA == "V") {

                        foreach ($xml as $destaque) {
                            for ($x = 0; $x < count($destaque->product_id); $x++) {
                                $array_varejo[] = "(" . $destaque->product_id . ", " . $destaque->related_id . ")";
                            }
                        }
                    }
                }
            }
        }
    }



    if (empty($query_atacado)) {
        //  echo 'opa';

        $conecta = mysql_connect($ip, $login, $senha);
        mysql_select_db($banco, $conecta);
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');

        $result_atacado = mysql_query("TRUNCATE oc_product_related");
        $query_atacado = 'INSERT INTO oc_product_related (`product_id`, `related_id`) VALUES ';
        //$query_atacado .= implode(',', array_unique($array_atacado));
        $execulta_atacado = mysql_query($query_atacado, $conecta);
    }

    if (empty($query_varejo)) {


        $conecta = mysql_connect($ip, $login, $senha);
        mysql_select_db($banco, $conecta);
        mysql_query('SET character_set_connection=utf8');
        mysql_query('SET character_set_client=utf8');
        mysql_query('SET character_set_results=utf8');


        $result_varejo = mysql_query("TRUNCATE oc_product_related");
        $query_varejo = 'INSERT INTO oc_product_related (`product_id`, `related_id`) VALUES ';
        $query_varejo .= implode(',', array_unique($array_varejo));
        $execulta_varejo = mysql_query($query_varejo, $conecta);
    }
} else {
    
}
// FIM DA RELAÇÃ DE PRODUTOS
        $obj->message = 'ok';
        echo $_GET['callback']. '(' . json_encode($obj) . ');';


?>


