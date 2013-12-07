<?php
/**
 * @file HttpClient.php
 */

namespace Wesnick\RingCentral\Http;


use Buzz\Client\FileGetContents;
use Buzz\Message\Request;
use Buzz\Message\Response;
use Buzz\Util\CookieJar;
use Doctrine\Common\Cache\Cache;

class HttpClient implements HttpClientInterface
{

    /**
     * @var Cache
     */
    protected $cache;

    function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $host
     * @param string $resource
     * @return string
     *   Return the response body from the HTTP request
     */
    public function doRequest($host, $resource)
    {
        if (!$cookieJar = $this->cache->fetch('wesnick.ringcentral.cookies')) {
            $cookieJar = new CookieJar();
        }

        $client = new FileGetContents($cookieJar);
        $request = new Request(Request::METHOD_GET, $resource, $host);
        $response = new Response;

        $client->setVerifyPeer(false);
        $client->send($request, $response);

        $this->cache->save('wesnick.ringcentral.cookies', $client->getCookieJar());

        return $response->getContent();
    }

} 
