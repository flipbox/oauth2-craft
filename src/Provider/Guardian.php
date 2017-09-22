<?php

namespace Flipbox\OAuth2\Client\Provider;

use League\OAuth2\Client\Token\AccessToken;

class Guardian extends AbstractGuardian
{
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
        return $this->getDomain() . '/' . $this->cleanUri($this->authorizationUri);
    }

    /**
     * @inheritdoc
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->getApiDomain() . '/' . $this->cleanUri($this->accessTokenUri);
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->getApiDomain() . '/' . $this->cleanUri($this->resourceOwnerDetailsUri) . '/' . $token->getToken();
    }

    /**
     * @return string
     */
    protected function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    protected function getApiDomain()
    {
        return $this->apiDomain;
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }

    /**
     * @param $uri
     * @return string
     */
    protected function cleanUri($uri)
    {
        return trim($uri, '/');
    }
}
