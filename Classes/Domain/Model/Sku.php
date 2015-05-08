<?php
namespace Ttree\Moltin\Domain\Model;

use TYPO3\Flow\Annotations as Flow;

/**
 * A SKU domain model
 *
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Sku {

	/**
	 * @var string
	 */
	protected $value;

	public function __construct($value) {
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->getValue();
	}

}
