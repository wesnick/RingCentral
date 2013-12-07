<?php

namespace spec\Wesnick\RingCentral;

use Buzz\Browser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FaxOutSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Wesnick\RingCentral\FaxOut');
    }

    function let($browser)
    {
        $browser->beADoubleOf('Buzz\Browser');
        $this->beConstructedWith($browser);
    }

}
