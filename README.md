# Marvin Provider for OAuth 2.0 Client

This package provides 42 OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require bde42/oauth2-marvin
```

## Usage

Usage is the same as The League's OAuth client, using `\BDE42\OAuth2\Client\Provider\Marvin` as the provider.

### Authorization Code Flow

```php
if (session('current_user') == null)
{
    $provider = new \BDE42\OAuth2\Client\Provider\Marvin([
        'clientId'          => 'your_client_id',
        'clientSecret'      => 'your_secret',
        'redirectUri'       => 'https://uri/to/redirect'
    ]);
    
    // If we don't have an authorization code then get one
    if (!isset($_GET['code'])) {
        $authUrl = $provider->getAuthorizationUrl(/*options*/);
        session(['oauth2state' => $provider->getState()]);
        return redirect($authUrl);

    // Check given state against previously stored one to mitigate CSRF attack
    } else if (empty($_GET['state']) || $_GET['state'] !== session('oauth2state'))
    {
        session(['oauth2state' => null]);
        exit('Invalid state');
    }
    
    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    
    // Try to get an access token (using the authorization code grant)
    try {
        $user = $provider->getResourceOwner($token);
    } catch (Exception $e) {
        exit('Oh dear...');
    }

    session(['current_user' => $user->getUserInfos()]); //Basic informations (uid, email, name and login)
    //$user->toArray() //Get all user informations whose you have the access authorization
    
    print_r ("NEW USER : ".json_encode(session('current_user')));
} else {
    print_r ("REGISTERED USER : ".json_encode(session('current_user')));
}
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/bde42/oauth2-marvin/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Kalb Franck](https://github.com/bde42)
- [All Contributors](https://github.com/bde42/oauth2-marvin/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/bde42/oauth2-marvin/blob/master/LICENSE) for more information.
