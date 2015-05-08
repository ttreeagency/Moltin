<?php
namespace Ttree\Moltin\NodeTypePostprocessor;

use Moltin\SDK\Facade\Category;
use Moltin\SDK\Facade\Tax;
use Ttree\Moltin\Domain\Service\AuthenticateService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Utility\Algorithms;
use TYPO3\Flow\Utility\Arrays;
use TYPO3\TYPO3CR\Domain\Model\NodeType;
use TYPO3\TYPO3CR\NodeTypePostprocessor\NodeTypePostprocessorInterface;

/**
 * This Processor updates the Product NodeType with the existing
 * Categories from the Moltin API
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class ProductNodeTypePostprocessor implements NodeTypePostprocessorInterface {

	/**
	 * @Flow\Inject
	 * @var AuthenticateService
	 */
	protected $authenticateService;

	/**
	 * Returns the processed Configuration
	 *
	 * @param NodeType $nodeType (uninitialized) The node type to process
	 * @param array $configuration input configuration
	 * @param array $options The processor options
	 * @return void
	 */
	public function process(NodeType $nodeType, array &$configuration, array $options) {
		if (!$nodeType->isOfType('Ttree.Moltin:ProductMixins')) {
			return;
		}
		$this->authenticateService->authenticate();
		$this->processCategories($configuration);
		$this->processTaxes($configuration);
	}

	/**
	 * @param array $configuration
	 */
	protected function processTaxes(array &$configuration) {
		$taxes = Tax::Listing(['limit' => '10']);
		$processedTaxes = ['' => [ 'label' => '' ]];
		foreach ($taxes['result'] as $tax) {
			$processedTaxes[$tax['id']] = [
				'label' => sprintf('%s', $tax['title'])
			];
		}
		$configuration = Arrays::setValueByPath($configuration, 'properties.productTaxBand.ui.inspector.editorOptions.values', $processedTaxes);
	}

	/**
	 * @param array $configuration
	 */
	protected function processCategories(array &$configuration) {
		$categoryTree = Category::Tree();
		$processedCategories = ['' => [ 'label' => '' ]];
		$this->processCategoryTree($processedCategories, $categoryTree['result']);
		$configuration = Arrays::setValueByPath($configuration, 'properties.productCategory.ui.inspector.editorOptions.values', $processedCategories);
	}

	/**
	 * @param array $categories
	 * @param array $tree
	 * @param integer $level
	 */
	protected function processCategoryTree(&$categories, $tree, $level = 0) {
		foreach ($tree as $category) {
			$prefix = $level > 0 ? str_repeat('  ', $level) : NULL;
			$categories[$category['id']] = [
				'label' => trim(sprintf('%s %s', $prefix, $category['title']))
			];
			if (!empty($category['children'])) {
				$nextLevel = $level + 1;
				$this->processCategoryTree($categories, $category['children'], $nextLevel);
			}
		}
	}

}
