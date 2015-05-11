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
	 * @var array
	 * @see http://docs.moltin.com/1.0/product/php#params
	 */
	protected $requiredProperties = ['sku', 'title', 'slug', 'price', 'status', 'category', 'stock_level', 'stock_status', 'description', 'requires_shipping', 'tax_band', 'catalog_only'];

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
	 * @return boolean
	 */
	public function isComplete() {
		foreach ($this->requiredProperties as $propertyName) {
			if (trim($this->getProperty($propertyName)) === '') {
				return FALSE;
			}
		}

		return TRUE;
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
