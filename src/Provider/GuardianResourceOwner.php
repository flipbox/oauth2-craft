<?php namespace Flipbox\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class GuardianResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Get resource expires
     *
     * @return int|null
     */
    public function getExpires()
    {
        return $this->getValueByKey($this->response, 'expires');
    }

    /**
     * Get resource owner email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getValueByKey($this->response, 'email');
    }

    /**
     * Get resource owner id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'id');
    }

    /**
     * Get resource owner domain
     *
     * @return int|null
     */
    public function getDomain()
    {
        return $this->getValueByKey($this->response, 'domain');
    }

    /**
     * Get resource owner scopes
     *
     * @return array|null
     */
    public function getScopes()
    {
        return $this->getValueByKey($this->response, 'scopes');
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
