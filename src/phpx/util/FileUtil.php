<?php

namespace phpx\util;

class FileUtil {

	/**
	*  Fun��o para remover um diret�rio sem ter que apagar manualmente cada arquivo e pasta dentro dele
	*
	*  ATEN��O!
	*
	*  Muito cuidado ao utilizar esta fun��o! Ela apagar� todo o conte�do dentro do diret�rio
	*  especificado sem pedir qualquer confirma��o. Os arquivos n�o poder�o ser recuperados.
	*  Portanto, s� utilize-a se tiver certeza de que deseja apagar o diret�rio.
	*
	*/
	public static function removeTree($rootDir) {
		if (!is_dir($rootDir)) {
			return false;
		}

		if (!preg_match("/\\/$/", $rootDir)) {
			$rootDir .= '/';
		}

		$stack = array($rootDir);

		while (count($stack) > 0) {
			$hasDir = false;
			$dir    = end($stack);
			$dh     = opendir($dir);

			while (($file = readdir($dh)) !== false) {
				if ($file == '.'  ||  $file == '..') {
					continue;
				}
				if (is_dir($dir . $file)) {
					$hasDir = true;
					array_push($stack, $dir . $file . '/');
				}
				else if (is_file($dir . $file)) {
					unlink($dir . $file);
				}
			}
			closedir($dh);
			if ($hasDir == false) {
				array_pop($stack);
				rmdir($dir);
			}
		}
		return true;
	}

	
	public static function uploadArquivo($nomeCampo, $destino){
		if(!$_FILES){
			//$this->adicionarMensagem("INFO", 'Nenhum arquivo enviado!');
		}else{
			$file_name = $_FILES[$nomeCampo]['name'];
			$file_type = $_FILES[$nomeCampo]['type'];
			$file_size = $_FILES[$nomeCampo]['size'];
			$file_tmp_name = $_FILES[$nomeCampo]['tmp_name'];
			$error = $_FILES[$nomeCampo]['error'];
		}
		switch ($error){
			case 0:
				break;
			case 1:
				//$this->adicionarMensagem("INFO", 'O tamanho do arquivo � maior que o definido nas configura��es do PHP!');
				break;
			case 2:
				//$this->adicionarMensagem("INFO", 'O tamanho do arquivo � maior do que o permitido!');
				break;
			case 3:
				//$this->adicionarMensagem("INFO", 'O upload n�o foi conclu�do!');
				break;
			case 4:
				//$this->adicionarMensagem("INFO", 'O upload n�o foi feito!');
				break;
		}
		if($error == 0){
			if(!is_uploaded_file($file_tmp_name)){
				//$this->adicionarMensagem("INFO", 'Erro ao processar arquivo!');
			}else{
				if (!self::makeDirs($destino, 0777)) {
					//$this->adicionarMensagem("INFO", 'N�o foi possivel criar o diret�rio!');
				}else{
					if(!move_uploaded_file($file_tmp_name, $destino. $file_name)){
						//$this->adicionarMensagem("INFO", 'N�o foi poss�vel salvar o arquivo!');
					}else{
						chmod($destino. $file_name, 0777);
						//$this->adicionarMensagem("INFO", 'Arquivo gravado com sucesso! Nome: ' . $file_name . ' Tipo: ' .$file_type. ' Tamanho em byte: ' .$file_size);
						return $file_name;
					}
				}
			}
		}
		return "";
	}
	
	public static function makeDirs($strPath, $mode = 0777) {
		return is_dir($strPath) or ( self::makeDirs(dirname($strPath), $mode) and mkdir($strPath, $mode) );
	}
	
}

?>