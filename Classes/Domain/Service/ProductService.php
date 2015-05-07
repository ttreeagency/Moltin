<?php
namespace Ttree\Moltin\Domain\Service;

use Moltin\SDK\Facade\Product;
use Ttree\Moltin\Domain\Model\Product as MoltinProduct;
use Ttree\Moltin\Domain\Repository\ProductRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\Flow\Log\SystemLoggerInterface;
use TYPO3\Flow\Property\PropertyMapper;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Workspace;
use TYPO3\TYPO3CR\Utility;

/**
 * A service for managing product
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class ProductService {

	/**
	 * @Flow\Inject
	 * @var AuthenticateService
	 */
	protected $authenticateService;

	/**
	 * @Flow\Inject
	 * @var ProductRepository
	 */
	protected $productRepository;

	/**
	 * @Flow\Inject
	 * @var PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @Flow\Inject
	 * @var SystemLoggerInterface
	 */
	protected $logger;

	/**
	 * @var array
	 * @see http://docs.moltin.com/1.0/product/php#params
	 */
	protected $requiredProperties = ['sku', 'title', 'slug', 'price', 'status', 'category', 'stock_level', 'stock_status', 'description', 'requires_shipping', 'tax_band', 'catalog_only'];

	/**
	 * @param NodeInterface $node
	 * @param Workspace $workspace
	 * @throws \Exception
	 * @api
	 */
	public function createOrUpdate(NodeInterface $node, Workspace $workspace) {
		if (!$node->getNodeType()->isOfType('Ttree.Moltin:ProductMixins') || $workspace->getName() !== 'live') {
			return;
		}
		$productIdentifier = NULL;
		$this->authenticateService->authenticate();
		/** @var MoltinProduct $productProperties */
		$productProperties = $this->propertyMapper->convert($node, 'Ttree\Moltin\Domain\Model\Product');
		foreach ($this->requiredProperties as $propertyName) {
			if (trim($productProperties->getProperty($propertyName)) === '') {
				throw new Exception(sprintf('The property "%s" is required', $propertyName), 1431033237);
			}
		}
		$product = $this->productRepository->findBySlug($node->getIdentifier());
		if ($product !== NULL) {
			Product::Update($product->getIdentifier(), $productProperties->getProperties());
			$message = sprintf('Moltin product "%s" updated, based on node "%s"', $product->getIdentifier(), $node->getPath());
		} else {
			$product = Product::Create($productProperties->getProperties());
			$message = sprintf('Moltin product "%s" created, based on node "%s"', $product->getIdentifier(), $node->getPath());
		}
		$this->logger->log($message, LOG_DEBUG);
	}

	/**
	 * @param NodeInterface $node
	 * @param Workspace $workspace
	 * @api
	 */
	public function delete(NodeInterface $node, Workspace $workspace) {
		if (!$node->getNodeType()->isOfType('Ttree.Moltin:ProductMixins') || $workspace->getName() !== 'live') {
			return;
		}
		$product = $this->productRepository->findBySlug($node->getIdentifier());
		if ($product !== NULL) {
			return;
		}
		Product::Delete($product->getIdentifier());
	}

}
