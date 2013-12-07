<?php
/**
 * @file
 * NamedNumberInterface.php
 */
namespace Wesnick\RingCentral\Model;

interface NamedNumberInterface
{
    /**
     * @return string
     */
    public function getNumber();

    /**
     * @return string
     */
    public function getName();
}
