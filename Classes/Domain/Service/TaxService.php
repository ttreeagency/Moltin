<?php
namespace Ttree\Moltin\Domain\Service;

use Moltin\SDK\Facade\Category;
use Moltin\SDK\Facade\Tax;
use TYPO3\Flow\Annotations as Flow;
use Ttree\Moltin\Annotations as Moltin;

/**
 * A service for managing tax
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class TaxService extends AbstractService {

	/**
	 * @param integer $limit
	 * @return array
	 * @Moltin\Cache
	 */
	public function tree($limit = 10) {
		return Tax::Listing(['limit' => (integer)$limit]);
	}

}
