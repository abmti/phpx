<?php

namespace phpx\util;

class FileUtil {

	/**
	*  Função para remover um diretório sem ter que apagar manualmente cada arquivo e pasta dentro dele
	*
	*  ATENÇÃO!
	*
	*  Muito cuidado ao utilizar esta função! Ela apagará todo o conteúdo dentro do diretório
	*  especificado sem pedir qualquer confirmação. Os arquivos não poderão ser recuperados.
	*  Portanto, só utilize-a se tiver certeza de que deseja apagar o diretório.
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
				//$this->adicionarMensagem("INFO", 'O tamanho do arquivo é maior que o definido nas configurações do PHP!');
				break;
			case 2:
				//$this->adicionarMensagem("INFO", 'O tamanho do arquivo é maior do que o permitido!');
				break;
			case 3:
				//$this->adicionarMensagem("INFO", 'O upload não foi concluído!');
				break;
			case 4:
				//$this->adicionarMensagem("INFO", 'O upload não foi feito!');
				break;
		}
		if($error == 0){
			if(!is_uploaded_file($file_tmp_name)){
				//$this->adicionarMensagem("INFO", 'Erro ao processar arquivo!');
			}else{
				if (!self::makeDirs($destino, 0777)) {
					//$this->adicionarMensagem("INFO", 'Não foi possivel criar o diretório!');
				}else{
					if(!move_uploaded_file($file_tmp_name, $destino. $file_name)){
						//$this->adicionarMensagem("INFO", 'Não foi possível salvar o arquivo!');
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