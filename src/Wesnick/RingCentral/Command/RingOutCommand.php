<?php
/**
 * @file
 * RingOutCommand.php
 */

namespace Wesnick\RingCentral\Command;


use Buzz\Client\FileGetContents;
use Buzz\Util\CookieJar;
use Doctrine\Common\Cache\FilesystemCache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Wesnick\RingCentral\Http\HttpClient;
use Wesnick\RingCentral\Model\User;
use Wesnick\RingCentral\RingOut;

class RingOutCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ringcentral:list')
            ->setDescription('List Number(s) Available to call out from for a given account')
            ->addOption("cache-dir", null, InputOption::VALUE_REQUIRED, "Cache Directory")
            ->addOption("num", null, InputOption::VALUE_REQUIRED, "Number")
            ->addOption("pass", null, InputOption::VALUE_REQUIRED, "Password")
            ->addOption("ext", null, InputOption::VALUE_OPTIONAL, "Extension")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $cacheDir = $input->getOption('cache-dir');
        $number = $input->getOption('num');
        $password = $input->getOption('pass');
        $extension = $input->getOption('ext');

        $user = new User($number, $password, $extension);
        $cache = new FilesystemCache($cacheDir);
        $client = new HttpClient($cache);
        $ringout = new RingOut($client);

        $numbers = $ringout->getNumbersList($user);

        if ($numbers) {
            foreach ($numbers as $number) {
                $rows[] = array($number->getName(), $number->getNumber());
            }

            $table = $this->getHelperSet()->get('table');
            $table
                ->setHeaders(array('Location', 'Number'))
                ->setRows($rows)
            ;
            $table->render($output);
        }
        else {
            $output->writeln("User does not appear to have any available numbers.");
        }
    }

}
