<?php

ini_set("display_errors", true );
ini_set("html_errors", true);

require_once("../vendor/autoload.php");

// Autoloader (Build)
$appClassLoader = new \phpx\util\ClassLoader("../build");
$appClassLoader->register();

Logger::configure("../src/appender_file.properties");

$path = \phpx\util\Path::getInstance();
$path->addPath("PATH", realpath("../"));
$path->addPath("PATH_PUBLIC", realpath("."));
$path->addPath("PATH_APPLICATION", realpath("../")."/src");
$path->addPath("PATH_PHPX", realpath("../")."/src");
$path->addPath("CONTEXT_RESOURCES", "../src/phpx/resources");

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace("Ray", dirname(__DIR__) . '/vendor/others');
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace("phpx\\seam\\util\\annotation", \phpx\util\Path::getInstance()->getPath("PATH_PHPX"));

$facesServlet = new \phpx\faces\FacesServlet();
$facesServlet->init("phpx");
$facesServlet->service();

?>