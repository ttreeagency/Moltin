<?php
namespace Ttree\Moltin\Domain\Repository;

use Moltin\SDK\Facade\Product;
use Ttree\Moltin\Domain\Model\Product as MoltinProduct;
use Ttree\Moltin\Domain\Service\AuthenticateService;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Exception;
use TYPO3\Flow\Persistence\RepositoryInterface;

/**
 * Abstract Moltin Repository
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
abstract class AbstractMoltinRepository implements RepositoryInterface {

	/**
	 * Classname of the entities this repository is managing
	 */
	const ENTITY_CLASSNAME = NULL;

	/**
	 * @Flow\Inject
	 * @var AuthenticateService
	 */
	protected $authenticateService;

	/**
	 * Returns the classname of the entities this repository is managing.
	 *
	 * @return string
	 * @throws Exception
	 * @api
	 */
	public function getEntityClassName() {
		if (static::ENTITY_CLASSNAME === NULL) {
			throw new Exception('ENTITY_CLASSNAME is not defined', 1431251417);
		}
		return static::ENTITY_CLASSNAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function findAll() {
		throw new Exception('Not implemented', 1431251623);
	}

	/**
	 * {@inheritdoc}
	 */
	public function createQuery() {
		throw new Exception('Not implemented', 1431251624);
	}

	/**
	 * {@inheritdoc}
	 */
	public function countAll() {
		throw new Exception('Not implemented', 1431251625);
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeAll() {
		throw new Exception('Not implemented', 1431251626);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOrderings(array $defaultOrderings) {
		throw new Exception('Not implemented', 1431251627);
	}

	/**
	 * {@inheritdoc}
	 */
	public function __call($method, $arguments) {
		throw new Exception('Not implemented', 1431251628);
	}
}
