<?php
/**
 * User: Justin Pratt
 * Date: 3/5/15
 */
require_once('Parser.php');
$config = New Parser();
//get config value by name
echo $config->getConfigValue('host');