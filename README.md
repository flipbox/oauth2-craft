# Craft CMS / Guardian Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/flipbox/oauth2-craft.svg?style=flat-square)](https://github.com/flipbox/oauth2-craft/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/flipbox/oauth2-craft/master.svg?style=flat-square)](https://travis-ci.org/flipbox/oauth2-craft)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/flipbox/oauth2-craft.svg?style=flat-square)](https://scrutinizer-ci.com/g/flipbox/oauth2-craft/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/flipbox/oauth2-craft.svg?style=flat-square)](https://scrutinizer-ci.com/g/flipbox/oauth2-craft)
[![Total Downloads](https://img.shields.io/packagist/dt/flipboxdigital/oauth2-craft.svg?style=flat-square)](https://packagist.org/packages/flipboxdigital/oauth2-craft)

This package provides Craft OAuth 2.0 support for [Guardian](https://github.com/flipbox/guardian) and the PHP League's [OAuth 2.0 Client](https://github.com/flipbox/oauth2-client).

## Installation

To install, use composer:

```
composer require flipboxdigital/oauth2-craft
```

## Usage

Usage is the same as The League's OAuth client, using `\Flipbox\OAuth2\Client\Provider\Craft` as the provider.

### Authorization Code Flow

```php
$provider = new Flipbox\OAuth2\Client\Provider\Craft([
    'clientId'          => '{craft-client-id}',
    'clientSecret'      => '{craft-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getEmail());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

### Managing Scopes

When creating your Craft authorization URL, you can specify the state and scopes your application may authorize.

```php
$options = [
    'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
    'scope' => ['contacts','content'] // array or string
];

$authorizationUrl = $provider->getAuthorizationUrl($options);
```
If neither are defined, the provider will utilize internal defaults.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/flipbox/oauth2-craft/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Flipbox Digital](https://github.com/flipbox)


## License

The MIT License (MIT). Please see [License File](https://github.com/flipbox/oauth2-craft/blob/master/LICENSE) for more information.
