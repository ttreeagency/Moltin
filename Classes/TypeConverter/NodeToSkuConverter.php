<?php
namespace Ttree\Moltin\TypeConverter;

use Ttree\Moltin\Domain\Model\Product;
use Ttree\Moltin\Domain\Model\Sku;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Property\PropertyMappingConfigurationInterface;
use TYPO3\Flow\Property\TypeConverter\AbstractTypeConverter;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * This Processor to convert a Node to a Moltin Product SKU
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class NodeToSkuConverter extends AbstractTypeConverter {

	/**
	 * @var array
	 */
	protected $sourceTypes = array('TYPO3\TYPO3CR\Domain\Model\NodeInterface');

	/**
	 * @var string
	 */
	protected $targetType = 'Ttree\Moltin\Domain\Model\Sku';

	/**
	 * @var integer
	 */
	protected $priority = 1;

	/**
	 * {@inheritdoc}
	 */
	public function canConvertFrom($source, $targetType) {
		/** @var NodeInterface $source */
		return $source->getNodeType()->isOfType('Ttree.Moltin:ProductMixins');
	}

	/**
	 * {@inheritdoc}
	 */
	public function convertFrom($source, $targetType, array $convertedChildProperties = array(), PropertyMappingConfigurationInterface $configuration = NULL) {
		/** @var NodeInterface $source */
		return new Sku($source->getProperty('productSku'));
	}

}
