<?php
/**
 * @file
 * NamedNumber.php
 */

namespace Wesnick\RingCentral\Model;


class NamedNumber implements NamedNumberInterface
{

    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $name;

    function __construct($number, $name = null)
    {
        $this->number = (string) $number;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

} 
