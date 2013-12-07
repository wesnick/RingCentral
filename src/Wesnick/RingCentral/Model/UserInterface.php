<?php
/**
 * @file
 * UserInterface.php
 */
namespace Wesnick\RingCentral\Model;

interface UserInterface
{
    /**
     * @return string
     */
    public function getPassword();

    /**
     * @return string
     */
    public function getIdentifierString();

    /**
     * @return string
     */
    public function getUserNumber();

    /**
     * @return string
     */
    public function getExtension();
}
