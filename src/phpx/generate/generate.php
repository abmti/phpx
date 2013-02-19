<?php 

ini_set("display_errors", true );
ini_set("html_errors", true);

// Include ClassLoaders
require_once("../util/ClassLoader.php");

// Autoloader (App)
$appClassLoader = new \util\ClassLoader(realpath(".."));
$appClassLoader->register();

new \generate\GenerateEntities();

echo "<br /><br />Gerado com sucesso...";

?>
<br />
<br />
<a href="generateForm.php">Voltar</a>