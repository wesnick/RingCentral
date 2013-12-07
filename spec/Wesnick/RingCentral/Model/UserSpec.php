<?php

namespace spec\Wesnick\RingCentral\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Wesnick\RingCentral\Model\User');
    }

    function it_returns_a_phone_number()
    {
        $this->getUserNumber()->shouldReturn('5555555555');
    }

    function let()
    {
        $this->beConstructedWith('5555555555', '123456', '1234');
    }

}
