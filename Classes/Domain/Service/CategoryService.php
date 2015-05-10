<?php
namespace Ttree\Moltin\Domain\Service;

use Moltin\SDK\Facade\Category;
use TYPO3\Flow\Annotations as Flow;
use Ttree\Moltin\Annotations as Moltin;

/**
 * A service for managing category
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class CategoryService extends AbstractService {

	/**
	 * @return array
	 * @Moltin\Cache
	 */
	public function tree() {
		return Category::Tree();
	}

}
