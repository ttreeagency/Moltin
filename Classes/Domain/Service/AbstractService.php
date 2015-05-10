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
 * Abstract Moltin Service
 *
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
abstract class AbstractService {

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

}
