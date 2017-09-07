<?php namespace League\OAuth2\Client\Test\Provider;

use Flipbox\OAuth2\Client\Provider\CraftResourceOwner;

class CraftResourceOwnerTest extends \PHPUnit_Framework_TestCase
{
    public function testEmailIsNullWithoutResponse()
    {
        $user = new CraftResourceOwner;

        $value = $user->getEmail();

        $this->assertNull($value);
    }

    public function testIdIsNullWithoutResponse()
    {
        $user = new CraftResourceOwner;

        $value = $user->getId();

        $this->assertNull($value);
    }


    public function testDomainIsNullWithoutResponse()
    {
        $user = new CraftResourceOwner;

        $value = $user->getDomain();

        $this->assertNull($value);
    }

    public function testResponsePropertyMapping()
    {
        $response = [
            'token' => uniqid() . uniqid(),
            'email' => uniqid() . '@' . uniqid() . '.com',
            'domain' => uniqid() . '.com',
            'scopes' => [
                'contacts',
                'content',
                'oauth'
            ],
            'expires_in' => rand(6, 10),
            'id' => rand(6, 10),
            'token_type' => 'access'
        ];
        $user = new CraftResourceOwner($response);

        $this->assertEquals($response['domain'], $user->getDomain());
        $this->assertEquals($response['email'], $user->getEmail());
        $this->assertEquals($response['id'], $user->getId());
        $this->assertEquals($response['scopes'], $user->getScopes());
        $this->assertEquals($response['expires_in'], $user->getExpires());
    }
}
