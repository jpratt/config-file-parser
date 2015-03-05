<?php
/**
 * Class parses specified config file and returns specific value
 * User: Justin Pratt
 * Date: 3/5/15
 */

class Parser {
    //file to read config from
    const CONFIG_FILE = 'config.cfg';

    //where we store values to be retrieved
    public $return = array();

    function __construct()
    {
        $this->parseValues();
    }

    /**
     * @return $this
     */
    protected function parseValues()
    {
        $handle = fopen(self::CONFIG_FILE, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                // process the line read.

                //ignore blank lines or comments
                if (substr(trim($line), 0, 1) !== "#" && trim($line) != '') {
                    //explode the line into a 2 part array, name and value
                    $configLine = explode('=', $line);
                    //make sure we only have two parts to validate its correct syntax
                    if (sizeof($configLine) == 2) {
                        //set value on class array
                        $this->return[trim($configLine[0])] = $this->getRealValue(trim($configLine[1]));
                    }
                }
            }
            fclose($handle);
        }
        return $this;
    }

    /**
     * @param string $value
     * @return bool|string
     */
    protected function getRealValue($value = '')
    {
        //return boolean types
        if ($value == 'yes' || $value == 'on' || $value == '1' || $value == 'true') {
            return true;
        }
        if ($value == 'no' || $value == 'off' || $value == '0' || $value == 'false') {
            return false;
        }

        //return number types (int, float)
        if (is_numeric($value)) {
            if (ctype_digit($value)) {
                return (int) $value;
            } else {
                return (float) $value;
            }
        }
        //all other should return strings
        return $value;
    }

    public function getConfigValue($configName)
    {
        return $this->return[$configName];
    }
}