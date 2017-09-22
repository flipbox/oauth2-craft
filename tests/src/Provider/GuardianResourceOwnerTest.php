<?php namespace League\OAuth2\Client\Test\Provider;

use Flipbox\OAuth2\Client\Provider\GuardianResourceOwner;

class GuardianResourceOwnerTest extends \PHPUnit_Framework_TestCase
{
    public function testEmailIsNullWithoutResponse()
    {
        $user = new GuardianResourceOwner;

        $value = $user->getEmail();

        $this->assertNull($value);
    }

    public function testIdIsNullWithoutResponse()
    {
        $user = new GuardianResourceOwner;

        $value = $user->getId();

        $this->assertNull($value);
    }


    public function testDomainIsNullWithoutResponse()
    {
        $user = new GuardianResourceOwner;

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
            'expires' => rand(6, 10),
            'id' => rand(6, 10),
            'token_type' => 'access'
        ];
        $user = new GuardianResourceOwner($response);

        $this->assertEquals($response['domain'], $user->getDomain());
        $this->assertEquals($response['email'], $user->getEmail());
        $this->assertEquals($response['id'], $user->getId());
        $this->assertEquals($response['scopes'], $user->getScopes());
        $this->assertEquals($response['expires'], $user->getExpires());
    }
}
