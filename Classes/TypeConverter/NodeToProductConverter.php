<?php
namespace Ttree\Moltin\TypeConverter;

use Ttree\Moltin\Domain\Model\Product;
use Ttree\Moltin\Domain\Model\Sku;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Property\PropertyMapper;
use TYPO3\Flow\Property\PropertyMappingConfigurationInterface;
use TYPO3\Flow\Property\TypeConverter\AbstractTypeConverter;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * This Processor to convert a Node to a Moltin Product Properties
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class NodeToProductConverter extends AbstractTypeConverter {

	/**
	 * @Flow\Inject
	 * @var PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @var array
	 */
	protected $sourceTypes = array('TYPO3\TYPO3CR\Domain\Model\NodeInterface');

	/**
	 * @var string
	 */
	protected $targetType = 'Ttree\Moltin\Domain\Model\Product';

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
		/** @var Sku $sku */
		$sku = $this->propertyMapper->convert($source, 'Ttree\Moltin\Domain\Model\Sku');
		/** @var NodeInterface $source */
		return new Product([
			'title' => $source->getProperty('title'),
			'slug' => $source->getIdentifier(),
			'sku' => (string)$sku,
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
		]);
	}

}
