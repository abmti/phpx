<?php
namespace phpx\generate;

class Template {

	public $templateRepository = 
'<?php

namespace ##NameProjeto##\infrastructure\persistence;

/**
 * @Repository("##NameEntityLower##Repository")
 */
class ##NameEntityUpper##Repository extends Repository {
	
}

?>
';

	
	public $templateMediator =
'<?php

namespace ##NameProjeto##\domain\service;

use phpx\seam\domain\service\Mediator;
use Exception;

/**
 * @Service("##NameEntityLower##Mediator")
 */
class ##NameEntityUpper##Mediator extends Mediator {

	/**
	 * @phpx\seam\util\annotation\In(targetClass="##NameProjeto##\infrastructure\persistence\##NameEntityUpper##Repository")
	 */
	private $##NameEntityLower##Repository;

	
	/*
	 * Métodos getters and setters
	 */
	
	
	public function get##NameEntityUpper##Repository() {
		return $this->##NameEntityLower##Repository;
	}

	public function set##NameEntityUpper##Repository($value) {
		$this->##NameEntityLower##Repository = $value;
	}
	
	public function getRepository() {
		return $this->##NameEntityLower##Repository;
	}
	
}

?>
';	
	
	
	public $templateHome = 
'<?php

namespace ##NameProjeto##\application;

use ##NameProjeto##\domain\entity\##NameEntityUpper##;
use phpx\seam\application\EntityHome;

/**
 * @Home("##NameEntityLower##Home")
 * @Scope("session") 
 */
class ##NameEntityUpper##Home extends EntityHome { 
    
    private $##NameEntityLower##s;
    
    /**
	 * @phpx\seam\util\annotation\In(targetClass="##NameProjeto##\domain\service\##NameEntityUpper##Mediator")
	 */
    private $##NameEntityLower##Mediator;

    public function initInstance($obj){
		if($obj != null){
			$this->setInstance($this->getMediator()->capturar($obj));
		}else{
			$this->setInstance(new ##NameEntityUpper##());
		}
		$this->inicializarCombos();
    	return "##NameEntityLower##Edit";
	}
    
	public function inicializarCombos() {
		// Implementar...
	}
	
	public function consultar() {
    	$lista = $this->getMediator()->consultar();
    	$this->set##NameEntityUpper##s($lista);
    	return "##NameEntityLower##List";
    }
	

    /*
     * Getters and setters
     */
    
    public function get##NameEntityUpper##s() {
      return $this->##NameEntityLower##s;
    }
    
    public function set##NameEntityUpper##s($value) {
      $this->##NameEntityLower##s = $value;
    }
    
	public function getTituloEdit(){
    	if($this->getInstance()->getCodigo() == null){
    		return "Cadastrar ##NameEntityLower##";
    	}else {
    		return "Alterar ##NameEntityLower##";
		}
	}
	
	public function get##NameEntityUpper##Mediator() {
		return $this->##NameEntityLower##Mediator;
	}
	
	public function set##NameEntityUpper##Mediator($value) {
		$this->##NameEntityLower##Mediator = $value;
	}
	
	public function getMediator() {
		return $this->##NameEntityLower##Mediator;
    }

}

?>
';	
	
	
	public $templateEntity = 
'<?php

namespace ##NameProjeto##\domain\entity;

/**
 * @Entity
 * @Table(name = "##NameEntityLower##")
 */
class ##NameEntityUpper## {

	##Fields##
	
	/*
	 * Métodos getters and setters
	 */
	
	##MetodosGettersAndSetters##
	
}

?>
';	
	
	public $templateEntityField = 
'	/**
	 * @Column(name="##FieldDB##", type="##FieldType##")
	 */
	private $##Field##;
';	
	
	
	public $templateEntityGettersAndSetters = 
'	public function get##FieldUpper##() {
		return $this->##Field##;
	}

	public function set##FieldUpper##($##Field##) {
		$this->##Field## = $##Field##;
	}
';	
	
	
	public $templateXhtmlList = 
'<?xml version="1.0" encoding="ISO-8859-1"?>
<ui:composition xmlns="http://www.w3.org/1999/xhtml"
	xmlns:ui="http://php.net/faces/facelets"
	xmlns:f="http://php.net/faces/core"
	xmlns:h="http://php.net/faces/html"
	template="/layout/template.xhtml">


	<ui:define name="body">

		<div id="conteudo" style="width: 95%;">
		
			<div class="content"> 
			
				<div class="inner" style="width: 99%;">
					<b>Administrar ##NameEntityUpper##</b>
					<br />
					<br />
					<div style="width: 100px; text-align: center;">
						<a href="index.php?faces.action=##NameEntityLower##Home.edit">
							<img src="./imagens/novo.png" border="0" /><br />
							Novo ##NameEntityUpper##
						</a>
					</div>
					<fieldset class="caixa" style="display: none;">
						<legend>Pesquisa</legend>
						<form name="pesquisarForm" method="post" action="##NameEntityLower##List.php">
							<table cellspacing="2" cellpadding="2" border="0" width="100%;">
								<tr>
									<td>
										<span class="fonteTextoNegrito">Palavra:</span>
										<input type="text" name="keyword" value="" class="campo" />
										<input type="submit" name="btnPesquisar" value="Pesquisar" class="btn" />
									</td>
								</tr>
							</table>
						</form>
					</fieldset>
					<br />
					<h:form id="inputTableForm">
						<h:dataTable id="table##NameEntityUpper##" value="#{##NameEntityLower##Home.##NameEntityLower##s}" var="_##NameEntityLower##" cellspacing="2" cellpadding="2" border="0" styleClass="simple">
							##Fields##
							<h:column>
								<f:facet name="header">
									Ação
								</f:facet>
								<h:commandLink id="linkEdit" action="#{##NameEntityLower##Home.edit(_##NameEntityLower##.codigo)}" value="Alterar" />
								<h:commandLink id="linkRemove" action="#{##NameEntityLower##Home.remove(_##NameEntityLower##)}" value="Remover" onclick="javascript:return confirm(\'Deseja realmente excluir?\');" />
							</h:column>
						</h:dataTable>
					</h:form>
				</div>
			</div>
			<div class="footer">
				<img height="1" width="1" border="0" alt="" src="./imagens/spacer.gif" />		
			</div>
		</div>
		
	</ui:define>

</ui:composition>	
';	
	
	public $templateXhtmlListField = 
'							<h:column>
								<f:facet name="header">
									##FieldUpper##
								</f:facet>
								<h:outputText value="#{_##NameEntityLower##.##Field##}" />
							</h:column>
';	
	
	
	public $templateXhtmlEdit = 
'<?xml version="1.0" encoding="ISO-8859-1"?>
<ui:composition xmlns="http://www.w3.org/1999/xhtml"
	xmlns:ui="http://php.net/faces/facelets"
	xmlns:f="http://php.net/faces/core"
	xmlns:h="http://php.net/faces/html"
	template="/layout/template.xhtml">


	<ui:define name="body">

		<div id="conteudo" style="width: 95%;">
		
			<div class="content">
			
				<div class="inner" style="width: 97%;">
					<b><h:outputText value="#{##NameEntityLower##Home.tituloEdit}" /></b>
					<br />	
					<br />
					<h:form id="##NameEntityLower##Form">
						
						##Fields##

						<div class="field" style="text-align: center;">
							<br />	
							<h:commandButton id="gravar" action="#{##NameEntityLower##Home.persist}" value="Gravar" />
							<h:commandButton id="cancelar" action="##NameEntityLower##List" value="Cancelar" immediate="true" />
						</div>
					
						<div style="clear:both">
							<img src="./imagens/required.gif" /> Campos obrigatórios.
            			</div>
							
					</h:form>
					
				</div>
			</div>
			<div class="footer">
				<img height="1" width="1" border="0" alt="" src="./imagens/spacer.gif" />		
			</div>
		</div>
		
	</ui:define>

</ui:composition>
';	
	
	public $templateXhtmlEditField = 
'						<div class="field">
							<span class="name">##FieldUpper##: <img src="./imagens/required.gif" /></span>
					        <span class="value">
								<h:inputText id="##Field##" value="#{##NameEntityLower##Home.instance.##Field##}" label="##FieldUpper##" required="true" size="20" styleClass="campo" />
							</span>
						</div>
';	
	
	
	public $templateFacesConfig =
'	<managed-bean>
		<managed-bean-name>##NameEntityLower##Home</managed-bean-name>
		<managed-bean-class>##NameProjeto##\application\##NameEntityUpper##Home</managed-bean-class>
		<managed-bean-scope>session</managed-bean-scope>
	</managed-bean>
	
	
	<navigation-rule>
		<navigation-case>
			<from-outcome>##NameEntityLower##List</from-outcome>
			<to-view-id>/pages/##NameEntityLower##List.xhtml</to-view-id>
		</navigation-case>
	</navigation-rule>
	
	<navigation-rule>
		<navigation-case>
			<from-outcome>##NameEntityLower##Edit</from-outcome>
			<to-view-id>/pages/##NameEntityLower##Edit.xhtml</to-view-id>
		</navigation-case>
	</navigation-rule>
';	
	
	
}

?>