RingCentral
===========

RingCentral Call Out and Fax Out API client

## Usage

```php
<?php
    use Wesnick\RingCentral\Model\User;
    use Wesnick\RingCentral\Http\HttpClient;

    // Some implementation of UserInterface
    $user = new User("5555555555", "1234");
    // Some implementation of Doctrine Cache interface
    $cache = new FilesystemCache("/path/to/cache");
    // Some implementation of HttpInterface
    $client = new HttpClient($cache);

    $ringout = new RingOut($client);

    // Methods
    $numbers = $ring->getNumbersList($user);
    // Returns an array of NamedNumberInterface

    $ring->placeCall($user, $destNumber, $sourceNumber, $callerIdNumber, $voicePromptBeforeConnect);
    // Returns session Id of connected call

    $ring->getCallStatus($sessionId);
    // Returns CallStatus object

    $ring->cancelCall($sessionId);
    // Returns boolean



```

Fax out is minimally implemented and has not been tested yet.

## Installation

Use composer.

## Requirements

PHP 5.3

For use as a standalone library you need the following libraries:
Buzz
Symfony Console
Doctrine Cache (for caching cookies)

## Contributing

Fork and issue a Pull Request.

## Running the Tests

```
$ bin/phpspec
```

## License

Released under the MIT License. See the bundled LICENSE file for details.
