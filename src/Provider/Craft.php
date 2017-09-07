<?php

namespace Flipbox\OAuth2\Client\Provider;

use Flipbox\OAuth2\Client\Provider\Exception\CraftIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Craft extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://www.yourdomain.com';

    /**
     * Api domain
     *
     * @var string
     */
    public $apiDomain = 'https://api.yourdomain.com';

    /**
     * Access token URI
     *
     * @var string
     */
    public $authorizationUri = '/oauth/authorize';

    /**
     * Access token URI
     *
     * @var string
     */
    public $accessTokenUri = '/oauth/v1/token';

    /**
     * Access token URI
     *
     * @var string
     */
    public $resourceOwnerDetailsUri = '/oauth/v1/access-tokens';

    /**
     * @var array
     */
    protected $defaultScopes = [];

    /**
     * @inheritdoc
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->domain . '/' . $this->cleanUri($this->authorizationUri);
    }

    /**
     * @inheritdoc
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->apiDomain . '/' . $this->cleanUri($this->accessTokenUri);
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->apiDomain . '/' . $this->cleanUri($this->resourceOwnerDetailsUri) . '/' . $token->getToken();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }

    /**
     * @inheritdoc
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * @inheritdoc
     */
    protected function getAuthorizationHeaders($token = null)
    {
        if ($token === null) {
            return [];
        }
        return [
            'Authorization' => sprintf("Bearer %s", $token)
        ];
    }

    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw CraftIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw CraftIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new CraftResourceOwner($response);
    }

    /**
     * @param $uri
     * @return string
     */
    private function cleanUri($uri)
    {
        return trim($uri, '/');
    }
}
