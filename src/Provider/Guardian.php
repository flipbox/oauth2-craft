<?php

namespace Flipbox\OAuth2\Client\Provider;

use League\OAuth2\Client\Token\AccessToken;

class Guardian extends AbstractGuardian
{
    /**
     * Access token URI
     *
     * @var string
     */
    protected $baseAuthorizationUrl = 'https://www.yourdomain.com/oauth/authorize';

    /**
     * Access token URI
     *
     * @var string
     */
    protected $baseAccessTokenUrl = 'https://www.yourdomain.com/oauth/v1/token';

    /**
     * Access token URI
     *
     * @var string
     */
    protected $baseResourceOwnerDetailsUrl = 'https://www.yourdomain.com/oauth/v1/access-tokens';

    /**
     * @var array
     */
    protected $defaultScopes = [];

    /**
     * @inheritdoc
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->baseAuthorizationUrl;
    }

    /**
     * @inheritdoc
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->baseAccessTokenUrl;
    }

    /**
     * @inheritdoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->baseResourceOwnerDetailsUrl . '/' . $token->getToken();
    }
    /**
     * @inheritdoc
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }
}
