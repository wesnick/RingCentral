<?php
/**
 * @file
 * CallStatus.php
 */

namespace Wesnick\RingCentral\Model;


class CallStatus
{

    const SUCCESS = 0;
    const IN_PROGRESS = 1;
    const BUSY = 2;
    const NO_ANSWER = 3;
    const REJECTED = 4;
    const GENERIC_ERROR = 5;
    const FINISHED = 6;
    const INTERNATIONAL_DISABLED = 7;
    const DESTINATION_PROHIBITED = 8;

    /**
     * @var int
     */
    protected $generalStatus;

    /**
     * @var string
     */
    protected $destinationNumber;

    /**
     * @var int
     */
    protected $destinationStatus;

    /**
     * @var string
     */
    protected $callbackNumber;

    /**
     * @var int
     */
    protected $callbackStatus;


    function __construct($generalStatus, $destinationNumber, $destinationStatus, $callbackNumber, $callbackStatus)
    {
        $this->callbackNumber = $callbackNumber;
        $this->callbackStatus = (int) $callbackStatus;
        $this->destinationNumber = $destinationNumber;
        $this->destinationStatus = (int) $destinationStatus;
        $this->generalStatus = (int) $generalStatus;
    }

    public static function getStatusMessage($statusNumber)
    {
        switch ($statusNumber) {
            case self::SUCCESS:
                return 'Success';
            case self::IN_PROGRESS:
                return 'In Progress';
            case self::BUSY:
                return 'Busy';
            case self::NO_ANSWER:
                return 'No Answer';
            case self::REJECTED:
                return 'Rejected';
            case self::GENERIC_ERROR:
                return 'Generic Error';
            case self::FINISHED:
                return 'Finished';
            case self::INTERNATIONAL_DISABLED:
                return 'International calls disabled';
            case self::DESTINATION_PROHIBITED:
                return 'Destination number prohibited';
            default:
                return 'Unknown Status';
        }
    }

    /**
     * @return string
     */
    public function getCallbackNumber()
    {
        return $this->callbackNumber;
    }

    /**
     * @return int
     */
    public function getCallbackStatus()
    {
        return $this->callbackStatus;
    }

    /**
     * @return string
     */
    public function getDestinationNumber()
    {
        return $this->destinationNumber;
    }

    /**
     * @return int
     */
    public function getDestinationStatus()
    {
        return $this->destinationStatus;
    }

    /**
     * @return int
     */
    public function getGeneralStatus()
    {
        return $this->generalStatus;
    }


}
