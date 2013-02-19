<?php

ini_set("display_errors", true );
ini_set("html_errors", true);

// Include ClassLoaders
require_once("../application/phpx/util/ClassLoader.php");
require_once("../library/Doctrine/Common/ClassLoader.php");

// Autoloader (App)
$appClassLoader = new \phpx\util\ClassLoader("../application");
$appClassLoader->register();

// Autoloader (Build)
$appClassLoader = new \phpx\util\ClassLoader("../build");
$appClassLoader->register();

// Autoloader (Doctrine)
$classLoader = new \Doctrine\Common\ClassLoader("Doctrine", "../library");
$classLoader->register();

// Autoloader (Library)
$facesClassLoader = new \phpx\util\ClassLoader("../library");
$facesClassLoader->register();

// Include Log4php
require_once("../library/log4php/Logger.php");
Logger::configure("../application/appender_file.properties");

// Include CuteEditor
require_once("../library/cuteeditor/CuteEditor.php");

$path = \phpx\util\Path::getInstance();
$path->addPath("PATH", realpath("../"));
$path->addPath("PATH_PUBLIC", realpath("."));
$path->addPath("PATH_APPLICATION", realpath("../")."/application");
$path->addPath("PATH_PHPX", realpath("../")."/application");
$path->addPath("CONTEXT_RESOURCES", "../application/phpx/resources");

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace("Ray", dirname(__DIR__) . '/library');
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace("phpx\\seam\\util\\annotation", \phpx\util\Path::getInstance()->getPath("PATH_PHPX"));

$facesServlet = new \phpx\faces\FacesServlet();
$facesServlet->init("phpseam");
$facesServlet->service();

?>