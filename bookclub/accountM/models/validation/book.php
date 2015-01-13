<?php


namespace bookObject;

use InvalidArgumentException;

/** Custom class defined by Alex Weissman to extend default value capabilities
 *
 */
class DefaultBook extends Book {

    public function setDefault($field, $defaultValue) {
        if (!isset($this->_fields[$field])){
            $this->_fields[$field] = $defaultValue;
        }
        return true;
    }

}


class Book
{
    /**
     * @var string
     */
    const ERROR_DEFAULT = 'Invalid';

    /**
     * @var array
     */
    protected $_fields = array();

    /**
     * @var array
     */
    protected $_errors = array();

    /**
     * @var array
     */
    protected $_labels = array();

    /**
     * Setup book object
     *
     * @param array $data
     * @param array $fields
     * @param string $lang
     * @param string $langDir
     * @throws \InvalidArgumentException
     */
    public function __construct($data, $fields = array())
    {
        // Allows filtering of used input fields against optional second array of field names allowed
        // This is useful for limiting raw $_POST or $_GET data to only known fields
        foreach ($data as $field => $value) {
            if (empty($fields) || (!empty($fields) && in_array($field, $fields))) {
                $this->_fields[$field] = $value;
            }
        }
    }

    /**
     *  Get array of fields and data
     *
     * @return array
     */
    public function data()
    {
        return $this->_fields;
    }

    /**
     * Get array of error messages
     *
     * @param null|string $field
     * @return array|bool
     */
    public function errors($field = null)
    {
        if ($field !== null) {
            return isset($this->_errors[$field]) ? $this->_errors[$field] : false;
        }
        return $this->_errors;
    }
}
