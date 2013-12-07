<?php
/**
 * @file HttpClientInterface.php
 */
namespace Wesnick\RingCentral\Http;

interface HttpClientInterface
{
    /**
     * @param string $host
     * @param string $resource
     * @return string
     *   Return the response body from the HTTP request
     */
    public function doRequest($host, $resource);
}
