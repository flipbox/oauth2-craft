<?php

namespace Flipbox\OAuth2\Client\Provider;

use Flipbox\OAuth2\Client\Provider\Exception\GuardianIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

abstract class Guardian extends AbstractProvider
{
    use BearerAuthorizationTrait;

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
    protected function getAuthorizationParameters(array $options)
    {
        return array_merge(
            parent::getAuthorizationParameters($options),
            [
                'client_secret' => $this->clientSecret
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultHeaders()
    {
        return [
            'accept' => 'application/json'
        ];
    }

    /**
     * Returns the request body for requesting an access token.
     *
     * @param  array $params
     * @return string
     */
    protected function getAccessTokenBody(array $params)
    {
        return json_encode(array_filter($params));
    }

    /**
     * Builds request options used for requesting an access token.
     *
     * @param  array $params
     * @return array
     */
    protected function getAccessTokenOptions(array $params)
    {
        $option = array_merge(
            parent::getAccessTokenOptions($params),
            [
                'headers' => [
                    'content-type' => 'application/json'
                ]
            ]
        );

        return $option;
    }

    /**
     * @inheritdoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw GuardianIdentityProviderException::clientException($response, $data);
        } elseif (isset($data['error'])) {
            throw GuardianIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * @inheritdoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new GuardianResourceOwner($response);
    }
}
