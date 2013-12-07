<?php
/**
 * @file
 * FaxOut.php
 */

namespace Wesnick\RingCentral;


use Buzz\Browser;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Form\FormUpload;
use Wesnick\RingCentral\Model\NamedNumberInterface;
use Wesnick\RingCentral\Model\UserInterface;

class FaxOut
{

    const FAX_OUT_ENDPOINT = 'https://service.ringcentral.com/faxapi.asp';

    /**
     * @var Browser
     */
    protected $browser;

    function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }


    /**
     * @param UserInterface             $user
     * @param NamedNumberInterface[]    $recipient
     * @param string                    $coverPage
     * @param string                    $coverPageText
     * @param string                    $resolution
     * @param \DateTime                 $sendTime
     * @param array                     $attachments
     * @return string
     */
    public function sendFax(
        UserInterface $user,
        array $recipient,
        $coverPage,
        $coverPageText,
        $resolution,
        \DateTime $sendTime,
        array $attachments
    )
    {

        $form = new FormRequest();
        $form->setResource(self::FAX_OUT_ENDPOINT);

        $recipients = array();
        foreach ($recipient as $rec) {
            $recipients[] = $rec->getNumber() . ($rec->getName() ? '|' . $rec->getName() : '');
        }

        $uploads = array();
        foreach ($attachments as $attachment) {
            $uploads[] = new FormUpload($attachment);
        }

        $fields = array(
            'Username' => $user->getUserNumber(),
            'Password' => $user->getPassword(),
            'Extension' => $user->getExtension(),
            'Recipient' => $recipients,
            'Coverpage' => $coverPage,
            'Coverpagetext' => $coverPageText,
            'Resolution' => $resolution,
            'Sendtime' => $sendTime->format('d:m:y h:i'),
            'Attachment' => $uploads,
        );

        $form->addFields($fields);

        return $this->browser->post(self::FAX_OUT_ENDPOINT, $form->getHeaders(), $form->getContent());

    }

}
