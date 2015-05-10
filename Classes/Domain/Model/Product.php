<?php
namespace Ttree\Moltin\Domain\Model;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Utility\Arrays;

/**
 * A product domain model
 *
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Product {

	/**
	 * @var array
	 */
	protected $properties = array();

	/**
	 * @param array $properties
	 */
	public function __construct(array $properties) {
		$this->properties = $properties;
	}

	/**
	 * @return integer
	 */
	public function getIdentifier() {
		return $this->getProperty('id');
	}

	/**
	 * @return array
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * @param array $properties
	 * @param boolean $merge
	 */
	public function setProperties($properties, $merge = TRUE) {
		$this->properties = $merge ? Arrays::arrayMergeRecursiveOverrule($this->properties, $properties) : $properties;
	}

	/**
	 * @param string $propertyName
	 * @return mixed
	 */
	public function getProperty($propertyName) {
		return isset($this->properties[$propertyName]) ? $this->properties[$propertyName] : NULL;
	}

	/**
	 * @param string $propertyName
	 * @param mixed $propertyValue
	 */
	public function setProperty($propertyName, $propertyValue) {
		$this->properties[$propertyName] = $propertyValue;
	}

}
