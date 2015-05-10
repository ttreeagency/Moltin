<?php
namespace Ttree\Moltin\Domain\Repository;

use Moltin\SDK\Facade\Product;
use Ttree\Moltin\Domain\Model\Product as MoltinProduct;
use Ttree\Moltin\Domain\Service\AuthenticateService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;

/**
 * A repository for managing product
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class ProductRepository extends AbstractMoltinRepository {

	const ENTITY_CLASSNAME = 'Ttree\Moltin\Domain\Model\Product';

	/**
	 * @Flow\Inject
	 * @var AuthenticateService
	 */
	protected $authenticateService;

	/**
	 * @param string $slug
	 * @return MoltinProduct
	 * @api
	 */
	public function findBySlug($slug) {
		$this->authenticateService->authenticate();
		$product = Product::Find(['slug' => $slug]);
		if (!isset($product['result'][0]['id'])) {
			return NULL;
		}
		return new MoltinProduct($product['result'][0]);
	}

	/**
	 * @param string $sku
	 * @return MoltinProduct
	 * @api
	 */
	public function findBySku($sku) {
		$this->authenticateService->authenticate();
		$product = Product::Find(['slug' => $sku]);
		if (!isset($product['result'][0]['id'])) {
			return NULL;
		}
		return new MoltinProduct($product['result'][0]);
	}

	/**
	 * @param string $identifier
	 * @return MoltinProduct
	 * @api
	 */
	public function findByIdentifier($identifier) {
		$this->authenticateService->authenticate();
		$product = Product::Find(['id' => $identifier]);
		if (!isset($product['result'][0]['id'])) {
			return NULL;
		}
		return new MoltinProduct($product['result'][0]);
	}

	/**
	 * @param MoltinProduct $product
	 * @return void
	 */
	public function update($product) {
		Product::Update($product->getIdentifier(), $product->getProperties());
	}

	/**
	 * @param MoltinProduct $product
	 * @return void
	 */
	public function remove($product) {
		Product::Delete($product->getIdentifier());
	}

	/**
	 * @param MoltinProduct $product
	 * @return void
	 */
	public function add($product) {
		$rawProduct = Product::Create($product->getProperties());
		$product->setProperty('id', $rawProduct['result']['id']);
	}

}
