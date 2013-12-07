<?php

namespace spec\Wesnick\RingCentral;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Wesnick\RingCentral\Model\User;

class RingOutSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Wesnick\RingCentral\RingOut');
    }

    function it_gets_a_list_all_the_numbers_you_can_use_to_place_the_call(User $user, $client)
    {

        $client->doRequest(Argument::any(), Argument::any())->willReturn("OK 6505553711;Home;6505551550;Business;6505551233;Mobile");

        $namedNumberArray = $this->getNumbersList($user);
        $namedNumberArray->shouldBeArray();
        $namedNumberArray->shouldHaveCount(3);

        $namedNumber = $namedNumberArray[0];
        $namedNumber->shouldHaveType("Wesnick\RingCentral\Model\NamedNumberInterface");
        $namedNumber->getName()->shouldReturn("Home");
        $namedNumber->getNumber()->shouldReturn('6505553711');

        $namedNumber = $namedNumberArray[1];
        $namedNumber->shouldHaveType("Wesnick\RingCentral\Model\NamedNumberInterface");
        $namedNumber->getName()->shouldReturn("Business");
        $namedNumber->getNumber()->shouldReturn('6505551550');

        $namedNumber = $namedNumberArray[2];
        $namedNumber->shouldHaveType("Wesnick\RingCentral\Model\NamedNumberInterface");
        $namedNumber->getName()->shouldReturn("Mobile");
        $namedNumber->getNumber()->shouldReturn('6505551233');

    }

    function it_places_a_call(User $user, $client)
    {
        $client->doRequest(Argument::any(), Argument::any())->willReturn("OK 18 3");
        $this->placeCall($user, '5555555555', '5555555556', '5555555557', true)->shouldReturn(array(18, 3));
    }

    function it_gets_the_call_status($response, $client)
    {

        $client->doRequest(Argument::any(), Argument::any())->willReturn("OK 18 4;6505551230;5;6505551231;5");
        $status = $this->getCallStatus(18);
        $status->shouldHaveType("Wesnick\RingCentral\Model\CallStatus");
        $status->getCallbackNumber()->shouldReturn("6505551231");
        $status->getCallbackStatus()->shouldReturn(5);
        $status->getDestinationNumber()->shouldReturn("6505551230");
        $status->getDestinationStatus()->shouldReturn(5);
        $status->getGeneralStatus()->shouldReturn(4);

    }

    function it_cancels_the_call($client)
    {
        $client->doRequest(Argument::any(),Argument::any())->willReturn("OK 18");
        $this->cancelCall(18)->shouldReturn(true);
    }

    function it_throws_an_error_if_failure_response(User $user, $client)
    {
        $client->doRequest(Argument::any(), Argument::any())->willReturn("FAILED Invalid User or Password");
        $this->shouldThrow("Wesnick\RingCentral\Exception\RingCentralException")->duringPlaceCall($user, '5555555555', '5555555556', '5555555557', true);
    }

    function let($client)
    {
        $client->beADoubleOf('Wesnick\RingCentral\Http\HttpClient');
        $this->beConstructedWith($client);

    }

}
