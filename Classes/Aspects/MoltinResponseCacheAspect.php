<?php
namespace Ttree\Moltin\Aspects;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;
use TYPO3\Flow\Cache\Frontend\VariableFrontend;

/**
 * Cache Moltin Request Result
 *
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class MoltinResponseCacheAspect {

	/**
	 * @var VariableFrontend
	 */
	protected $cache;

	/**
	 * @param JoinPointInterface $joinPoint
	 * @return mixed
	 * @Flow\Around("methodAnnotatedWith(Ttree\Moltin\Annotations\Cache)")
	 */
	public function cacheResponse(JoinPointInterface $joinPoint) {
		$cacheIdentifier = md5(json_encode([
			$joinPoint->getClassName(),
			$joinPoint->getMethodName(),
			$joinPoint->getMethodArguments(),
		]));
		if ($this->cache->has($cacheIdentifier)) {
			return $this->cache->get($cacheIdentifier);
		}
		$result = $joinPoint->getAdviceChain()->proceed($joinPoint);
		$this->cache->set($cacheIdentifier, $result, [
			$joinPoint->getClassName(),
			sprintf('%s::%s', $joinPoint->getClassName(), $joinPoint->getMethodName()),
		], 7200);
		return $result;
	}

}
