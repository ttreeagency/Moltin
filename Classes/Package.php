<?php
namespace Ttree\Moltin;

use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Cache\CacheManager;
use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Package\Package as BasePackage;
use TYPO3\TYPO3CR\Domain\Model\NodeData;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * The ttree moltin Package
 *
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Package extends BasePackage {

	/**
	 * @param Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(Bootstrap $bootstrap) {
		$dispatcher = $bootstrap->getSignalSlotDispatcher();
		$dispatcher->connect('TYPO3\Neos\Service\PublishingService', 'nodePublished', 'Ttree\Moltin\Domain\Service\ProductService', 'createOrUpdate');
	}
}
