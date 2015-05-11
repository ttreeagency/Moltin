<?php
namespace Ttree\Moltin\Domain\Service;

use Ttree\Moltin\Domain\Model\Product as MoltinProduct;
use Ttree\Moltin\Domain\Repository\ProductRepository;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Workspace;

/**
 * A service for managing product
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class ProductService extends AbstractService {

	/**
	 * @Flow\Inject
	 * @var ProductRepository
	 */
	protected $productRepository;

	/**
	 * @param NodeInterface $node
	 * @param Workspace $workspace
	 * @api
	 */
	public function createOrUpdate(NodeInterface $node, Workspace $workspace) {
		if (!$node->getNodeType()->isOfType('Ttree.Moltin:ProductMixins') || $workspace->getName() !== 'live') {
			return;
		}
		$productIdentifier = NULL;
		$this->authenticateService->authenticate();

		/** @var MoltinProduct $product */
		$product = $this->propertyMapper->convert($node, 'Ttree\Moltin\Domain\Model\Product');
		if (!$product->isComplete()) {
			$this->logger->log(sprintf('Missing property in the current product "%s", based on node "%s"', $product->getIdentifier(), $node->getPath()), LOG_WARNING);
			return;
		}
		
		$existingProduct = $this->productRepository->findBySlug($node->getIdentifier());
		if ($existingProduct !== NULL) {
			$existingProduct->setProperties($product->getProperties());
			$this->productRepository->update($existingProduct);
			$message = sprintf('Moltin product "%s" updated, based on node "%s"', $existingProduct->getIdentifier(), $node->getPath());
		} else {
			$this->productRepository->add($product);
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
		$this->productRepository->remove($product);
	}

}
