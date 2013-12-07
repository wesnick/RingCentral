<?php
/**
 * @file
 * RingOutCommand.php
 */

namespace Wesnick\RingCentral\Command;


use Buzz\Browser;
use Buzz\Client\FileGetContents;
use Buzz\Util\CookieJar;
use Doctrine\Common\Cache\FilesystemCache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Wesnick\RingCentral\FaxOut;
use Wesnick\RingCentral\Model\NamedNumber;
use Wesnick\RingCentral\Model\User;
use Wesnick\RingCentral\RingOut;

class FaxOutCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ringcentral:fax')
            ->setDescription('Send a Fax')
            ->addOption("num", null, InputOption::VALUE_REQUIRED, "Number")
            ->addOption("pass", null, InputOption::VALUE_REQUIRED, "Password")
            ->addOption("ext", null, InputOption::VALUE_OPTIONAL, "Extension")
            ->addOption("recipient", null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, "Recipients in the format of <recipient number> or <recipient number>|<recipient name>")
            ->addOption("attach", null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, "Attachment(s)")
            ->addOption("coverpage", null, InputOption::VALUE_REQUIRED, "Coverpage", 'Default')
            ->addOption("coverpage-text", null, InputOption::VALUE_OPTIONAL, "Coverpage Text")
            ->addOption("resolution", null, InputOption::VALUE_OPTIONAL, "Resolution", "High")
            ->addOption("sendtime", null, InputOption::VALUE_OPTIONAL, "Schedule Time", "now")

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $number = $input->getOption('num');
        $password = $input->getOption('pass');
        $extension = $input->getOption('ext');

        $user = new User($number, $password, $extension);

        $recipients = $input->getOption('recipient');

        $recs = array();
        foreach ($recipients as $recipient) {
            $numbers = explod("|", $recipient);
            $name = isset($numbers[1]) ?: '';
            $recs[] = new NamedNumber($numbers[0], $name);
        }

        $coverPage = $input->getOption("coverpage");
        $coverPageText = $input->getOption("coverpage-text");
        $resolution = $input->getOption("resolution");
        $sendTime = new \DateTime();
        $sendTime->setTimezone(new \DateTimeZone('GMT'));
        $sendTime->setTimestamp(strtotime($input->getOption("sendtime")));
        $attachments = $input->getOption("attach");

        $browser = new Browser();
        $faxout = new FaxOut($browser);

        $res = $faxout->sendFax($user, $recs, $coverPage, $coverPageText, $resolution, $sendTime, $attachments);

        $output->writeln($res);





    }


} 
