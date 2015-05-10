<?php
namespace Ttree\Moltin\NodeTypePostprocessor;

use Moltin\SDK\Exception\InvalidRequestException;
use Moltin\SDK\Facade\Category;
use Moltin\SDK\Facade\Tax;
use Ttree\Moltin\Domain\Service\AuthenticateService;
use Ttree\Moltin\Domain\Service\CategoryService;
use Ttree\Moltin\Domain\Service\TaxService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Log\SystemLoggerInterface;
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
	 * @Flow\Inject
	 * @var CategoryService
	 */
	protected $categoryService;

	/**
	 * @Flow\Inject
	 * @var TaxService
	 */
	protected $taxService;

	/**
	 * @Flow\Inject
	 * @var SystemLoggerInterface
	 */
	protected $logger;

	/**
	 * Returns the processed Configuration
	 *
	 * @param NodeType $nodeType (uninitialized) The node type to process
	 * @param array $configuration input configuration
	 * @param array $options The processor options
	 * @return void
	 */
	public function process(NodeType $nodeType, array &$configuration, array $options) {
		try {
			if (!$nodeType->isOfType('Ttree.Moltin:ProductMixins')) {
				return;
			}
			$this->authenticateService->authenticate();
			$this->processCategories($configuration);
			$this->processTaxes($configuration);
		} catch (InvalidRequestException $exception) {
			$this->logger->logException($exception);
		}
	}

	/**
	 * @param array $configuration
	 */
	protected function processTaxes(array &$configuration) {
		$taxes = $this->taxService->tree();
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
		$tree = $this->categoryService->tree();
		$processedCategories = ['' => [ 'label' => '' ]];
		$this->processCategoryTree($processedCategories, $tree['result']);
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
