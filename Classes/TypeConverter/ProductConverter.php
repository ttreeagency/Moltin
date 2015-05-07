<?php
namespace Ttree\Moltin\TypeConverter;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Property\PropertyMappingConfigurationInterface;
use TYPO3\Flow\Property\TypeConverter\AbstractTypeConverter;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * This Processor updates the Product NodeType with the existing
 * Categories from the Moltin API
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class ProductConverter extends AbstractTypeConverter {

	/**
	 * @var array
	 */
	protected $sourceTypes = array('TYPO3\TYPO3CR\Domain\Model\NodeInterface');

	/**
	 * @var string
	 */
	protected $targetType = 'array';

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
		return [
			'title' => $source->getProperty('title'),
			'slug' => $source->getIdentifier(),
			'sku' => $source->getProperty('productSku'),
			'price' => $source->getProperty('productPrice'),
			'sale_price' => $source->getProperty('productSalePrice'),
			'status' => $source->getProperty('productStatus'),
			'category' => $source->getProperty('productCategory'),
			'stock_level' => (integer)$source->getProperty('productStockLevel'),
			'stock_status' => $source->getProperty('productStockStatus'),
			'requires_shipping' => $source->getProperty('productRequiresShipping') ? 1 : 0,
			'catalog_only' => $source->getProperty('productCatalogOnly') ? 1 : 0,
			'tax_band' => (integer)$source->getProperty('productTaxband'),
			// todo use content dimensions to edit product description
			'description' => $source->getProperty('title')
		];
	}

}
