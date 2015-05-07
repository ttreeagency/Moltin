<?php
namespace Ttree\Moltin\Domain\Repository;

use Moltin\SDK\Facade\Product;
use Ttree\Moltin\Domain\Model\Product as MoltinProduct;
use Ttree\Moltin\Domain\Service\AuthenticateService;
use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for managing product
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class ProductRepository {

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

}
