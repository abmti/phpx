<?php

namespace phpx\generate;

class GenerateEntities {

	public function __construct() {
		$template = new Template();
	 	
		$projeto = $_POST['projeto'];
		$entity = $_POST['entity'];
		
		$nomeEntityUpper = ucfirst($entity);
		
		$values = array("##NameProjeto##", "##NameEntityLower##", "##NameEntityUpper##");
		$newValues = array($projeto, $entity, $nomeEntityUpper);
		
		$conteudoRepository = str_replace($values, $newValues, $template->templateRepository);
		$fileRepository = realpath(".")."/files/".$nomeEntityUpper."Repository.php";
		file_put_contents($fileRepository, $conteudoRepository, LOCK_EX);
		chmod($fileRepository, 0777);
		
		$conteudoMediator = str_replace($values, $newValues, $template->templateMediator);
		$fileMediator = realpath(".")."/files/".$nomeEntityUpper."Mediator.php";
		file_put_contents($fileMediator, $conteudoMediator, LOCK_EX);
		chmod($fileMediator, 0777);
		
		$conteudoHome = str_replace($values, $newValues, $template->templateHome);
		$fileHome = realpath(".")."/files/".$nomeEntityUpper."Home.php";
		file_put_contents($fileHome, $conteudoHome, LOCK_EX);
		chmod($fileHome, 0777);
		
		$fields = "";
		$gettesAndSetters = "";
		$fieldsXhtmlList = "";
		$fieldsXhtmlEdit = "";
		for($i = 0; $i < count($_POST['field']); $i++) {
			$valuesFields = array("##Field##", "##FieldDB##", "##FieldType##");
			$newValuesFields = array($_POST['field'][$i], $_POST['fieldBanco'][$i], $_POST['fieldType'][$i]);
			$fields .= "\n" . str_replace($valuesFields, $newValuesFields, $template->templateEntityField);
				
			$valuesFields = array("##Field##", "##FieldUpper##");
			$newValuesFields = array($_POST['field'][$i], ucfirst($_POST['field'][$i]));
			$gettesAndSetters .= "\n" . str_replace($valuesFields, $newValuesFields, $template->templateEntityGettersAndSetters);
			
			$valuesFields = array("##NameEntityLower##", "##Field##", "##FieldUpper##");
			$newValuesFields = array($entity, $_POST['field'][$i], ucfirst($_POST['field'][$i]));
			$fieldsXhtmlList .= "\n" . str_replace($valuesFields, $newValuesFields, $template->templateXhtmlListField);
			
			$valuesFields = array("##NameEntityLower##", "##Field##", "##FieldUpper##");
			$newValuesFields = array($entity, $_POST['field'][$i], ucfirst($_POST['field'][$i]));
			$fieldsXhtmlEdit .= "\n" . str_replace($valuesFields, $newValuesFields, $template->templateXhtmlEditField);
		}
		
		
		$conteudoEntity = str_replace($values, $newValues, $template->templateEntity);
		$conteudoEntity = str_replace("##Fields##", $fields, $conteudoEntity);
		$conteudoEntity = str_replace("##MetodosGettersAndSetters##", $gettesAndSetters, $conteudoEntity);
		$fileEntity = realpath(".")."/files/".$nomeEntityUpper.".php";
		file_put_contents($fileEntity, $conteudoEntity, LOCK_EX);
		chmod($fileEntity, 0777);
		
		$conteudoXhtmlList = str_replace($values, $newValues, $template->templateXhtmlList);
		$conteudoXhtmlList = str_replace("##Fields##", $fieldsXhtmlList, $conteudoXhtmlList);
		$fileXhtmlList = realpath(".")."/files/".$entity."List.xhtml";
		file_put_contents($fileXhtmlList, $conteudoXhtmlList, LOCK_EX);
		chmod($fileXhtmlList, 0777);
		
		$conteudoXhtmlEdit = str_replace($values, $newValues, $template->templateXhtmlEdit);
		$conteudoXhtmlEdit = str_replace("##Fields##", $fieldsXhtmlEdit, $conteudoXhtmlEdit);
		$fileXhtmlEdit = realpath(".")."/files/".$entity."Edit.xhtml";
		file_put_contents($fileXhtmlEdit, $conteudoXhtmlEdit, LOCK_EX);
		chmod($fileXhtmlEdit, 0777);
		
		$valuesFaces = array("##NameProjeto##", "##NameEntityLower##", "##NameEntityUpper##");
		$newValuesFaces = array($projeto, $entity, $nomeEntityUpper);
		$conteudoFacesConfig = str_replace($valuesFaces, $newValuesFaces, $template->templateFacesConfig);
		
		
		$str = "Os seguintes arquivos foram gerados:<br />" .
				"<br />" . $fileRepository .
				"<br />" . $fileMediator .
				"<br />" . $fileHome .
				"<br />" . $fileEntity .
				"<br />" . $fileXhtmlList .
				"<br />" . $fileXhtmlEdit .
				"<br /><br />".
				"Cole o trecho abaixo no faces-config.xml".
				"<form><textarea rows='22' cols='100'>" . $conteudoFacesConfig . "</textarea></form>";
		
		echo $str;
				
	}
	
	
}

?>