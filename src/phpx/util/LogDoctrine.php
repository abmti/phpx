<?php

namespace phpx\util;

use Doctrine\DBAL\Logging\SQLLogger;
use Logger;

/**
 * A SQL logger that logs to the standard output using echo/var_dump.
 * 
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @since   2.0
 * @version $Revision$
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
class LogDoctrine implements SQLLogger
{
	
	private $logger = null;
	
	public function __construct() {
		$this->logger = Logger::getLogger(__CLASS__);	
	}
	
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null) {
    	
    	$str  = "\n==========================\n";
    	$str .= "Sql: " . $sql . "\n";
    	$str .= "Params: " . print_r($params, true) . "\n"; 
    	$str .= "Types: " . print_r($types, true) . "\n";
    	$str .= "==========================\n";
    	$this->logger->debug($str);
    	
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {

    }
    
}

?>