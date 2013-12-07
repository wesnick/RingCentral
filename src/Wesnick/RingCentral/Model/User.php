<?php

namespace Wesnick\RingCentral\Model;

class User implements UserInterface
{

    /**
     * @var string
     */
    protected $userNumber;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var string
     */
    protected $password;

    function __construct($userNumber, $password, $extension = null)
    {

        if (empty($userNumber) || empty($password)) {
            throw new \InvalidArgumentException("Both User Number and Password are Required");
        }

        $this->userNumber = (string) $userNumber;
        $this->password = $password;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUserNumber()
    {
        return $this->userNumber;
    }

    /**
     * @return string
     */
    public function getIdentifierString()
    {
        return $this->userNumber . (isset($this->extension) ? "*" . $this->extension : '');
    }


}
