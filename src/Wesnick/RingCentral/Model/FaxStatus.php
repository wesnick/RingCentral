<?php
/**
 * @file
 * FaxStatus.php
 */

namespace Wesnick\RingCentral\Model;


class FaxStatus
{

    const SUCCESSFUL = 0;
    const AUTHORIZATION_FAILED = 1;
    const FAXING_PROHIBITED = 2;
    const NO_RECIPIENT_SPECIFIED = 3;
    const NO_FAX_DATA = 4;
    const GENERIC_ERROR = 5;


    public static function getStatusMessage($statusCode)
    {

        switch ($statusCode) {
            case self::SUCCESSFUL:
                return 'Successful';
            case self::AUTHORIZATION_FAILED:
                return 'Authorization failed';
            case self::FAXING_PROHIBITED:
                return 'Faxing is prohibited for the account';
            case self::NO_RECIPIENT_SPECIFIED:
                return 'No recipients specified';
            case self::NO_FAX_DATA:
                return 'No fax data specified';
            case self::GENERIC_ERROR:
                return 'Generic error';
            default:
                return "Unknown Status";
        }
    }

}
