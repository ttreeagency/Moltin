<?php
namespace Ttree\Moltin\Domain\Service;

use Moltin\SDK\Facade\Product;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\Flow\Log\SystemLoggerInterface;
use TYPO3\Flow\Property\PropertyMapper;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
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
	 * @var PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @Flow\Inject
	 * @var SystemLoggerInterface
	 */
	protected $logger;

	/**
	 * @param NodeInterface $node
	 * @throws \Exception
	 */
	public function createOrUpdate(NodeInterface $node) {
		if (!$node->getNodeType()->isOfType('Ttree.Moltin:ProductMixins')) {
			return;
		}
		$productIdentifier = NULL;
		$this->authenticateService->authenticate();
		$product = Product::Find(['slug' => $node->getIdentifier()]);
		if (isset($product['result'][0]['id'])) {
			$productIdentifier = $product['result'][0]['id'];
			Product::Update($productIdentifier, $this->getProductProperties($node));
			$message = sprintf('Moltin product "%s" updated, based on node "%s"', $productIdentifier, $node->getPath());
		} else {
			$product = Product::Create($product);
			$productIdentifier = $product['id'];
			$message = sprintf('Moltin product "%s" created, based on node "%s"', $productIdentifier, $node->getPath());
		}
		$this->logger->log($message, LOG_DEBUG);
	}

	/**
	 * @param NodeInterface $node
	 * @return array
	 */
	protected function getProductProperties(NodeInterface $node) {
		return $this->propertyMapper->convert($node, 'array');
	}

}
