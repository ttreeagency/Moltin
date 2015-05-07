<?php
namespace Ttree\Moltin\Domain\Service;

use Moltin\SDK\Facade\Moltin;
use Moltin\SDK\Facade\Product;
use TYPO3\Flow\Annotations as Flow;

/**
 * A service for managing authentication
 *
 * @Flow\Scope("singleton")
 * @api
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 */
class AuthenticateService {

	/**
	 * @var boolean
	 */
	protected $isAuthenticated = FALSE;

	/**
	 * @Flow\InjectConfiguration(path="client.clientId")
	 * @var string
	 */
	protected $clientId;

	/**
	 * @Flow\InjectConfiguration(path="client.clientSecret")
	 * @var string
	 */
	protected $clientSecret;

	/**
	 * Authenticate Moltin API
	 */
	public function authenticate() {
		if ($this->isAuthenticated === TRUE) {
			return;
		}

		Moltin::Authenticate('ClientCredentials', [
			'client_id'     => $this->clientId,
			'client_secret' => $this->clientSecret
		]);
	}

}
