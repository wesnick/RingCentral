<?php

namespace Wesnick\RingCentral;

use Wesnick\RingCentral\Exception\RingCentralException;
use Wesnick\RingCentral\Http\HttpClientInterface;
use Wesnick\RingCentral\Model\CallStatus;
use Wesnick\RingCentral\Model\NamedNumber;
use Wesnick\RingCentral\Model\NamedNumberInterface;
use Wesnick\RingCentral\Model\UserInterface;

class RingOut
{

    const RINGOUT_API_HOST = 'https://service.ringcentral.com';
    const RINGOUT_API_ENDPOINT = '/ringout.asp';
    const SUCCESS_STATUS = 'OK';

    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @param HttpClientInterface $client
     */
    function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * @param UserInterface $user
     * @return NamedNumberInterface[]
     * @throws Exception\RingCentralException
     */
    public function getNumbersList(UserInterface $user)
    {

        $uri = $this->getUserOperationUri('list', $user);

        list($status, $result) = $this->parseResponse($this->client->doRequest(self::RINGOUT_API_HOST, $uri));

        if ($status !== self::SUCCESS_STATUS) {
            throw new RingCentralException($result);
        }

        $numbers = explode(";", $result);
        $count = count($numbers);

        $output = array();

        for ($x = 0; $x < $count; $x = $x + 2) {
            $output[] = new NamedNumber($numbers[$x], $numbers[$x + 1]);
        }

        return $output;

    }

    /**
     * @param UserInterface $user
     * @param string $destination
     * @param string $source
     * @param string $callerIdSource
     * @param bool $prompt
     * @return array
     * @throws Exception\RingCentralException
     */
    public function placeCall(UserInterface $user, $destination, $source, $callerIdSource = null, $prompt = false)
    {

        $params = array(
            'to'        => $destination,
            'from'      => $source,
            'clid'      => (null === $callerIdSource) ? $source : $callerIdSource,
            'prompt'    => (int) $prompt,
        );

        $uri = $this->getUserOperationUri('call', $user, $params);

        list($status, $result) = $this->parseResponse($this->client->doRequest(self::RINGOUT_API_HOST, $uri));
        
        if ($status !== self::SUCCESS_STATUS) {
            throw new RingCentralException($result);
        }

        $numbers = explode(" ", $result);

        return array(
            (int) $numbers[0], (int) $numbers[1]
        );
    }

    /**
     * @param int $sessionId
     * @return CallStatus
     * @throws Exception\RingCentralException
     */
    public function getCallStatus($sessionId)
    {
        $uri = $this->getSessionOperationUri('status', $sessionId);
        list($status, $result) = $this->parseResponse($this->client->doRequest(self::RINGOUT_API_HOST, $uri));
        if ($status !== self::SUCCESS_STATUS) {
            throw new RingCentralException($result);
        }

        $result = str_replace(" ", ";", $result);
        $numbers = explode(";", $result);

        return new CallStatus($numbers[1],$numbers[2],$numbers[3],$numbers[4], $numbers[5]);
    }

    /**
     * @param int $sessionId
     * @return bool
     * @throws Exception\RingCentralException
     */
    public function cancelCall($sessionId)
    {
        $uri = $this->getSessionOperationUri('cancel', $sessionId);
        list($status, $result) = $this->parseResponse($this->client->doRequest(self::RINGOUT_API_HOST, $uri));

        if ($status !== self::SUCCESS_STATUS) {
            throw new RingCentralException($result);
        }

        return $status === self::SUCCESS_STATUS;
    }

    protected function getUserOperationUri($command, UserInterface $user, $params = array())
    {
        $query = array(
            'cmd'       => $command,
            'username'  => $user->getUserNumber(),
            'ext'       => $user->getExtension(),
            'password'  => $user->getPassword(),
        );

        $query += $params;

        return self::RINGOUT_API_ENDPOINT . '?' . http_build_query($query);
    }

    protected function getSessionOperationUri($command, $sessionId)
    {
        $query = array(
            'cmd'       => $command,
            'sessionid'  => $sessionId,
        );

        return self::RINGOUT_API_ENDPOINT . '?' . http_build_query($query);
    }

    protected function parseResponse($content)
    {
        // Response is in the format "<status> <message>"
        $responsePosition = strpos($content, " ");
        return array(
            substr($content, 0, $responsePosition),
            substr($content, $responsePosition + 1, strlen($content)),
        );
    }

}
