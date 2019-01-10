<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Command;

use DawBed\ComponentBundle\Model\EventListenerDebuger;
use DawBed\ConfirmationBundle\DependencyInjection\ConfirmationExtension;
use DawBed\ConfirmationBundle\Event\Events;
use DawBed\ConfirmationBundle\Repository\TokenRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventListenerDebugerCommand extends Command
{
    const NAME = 'dawbed-confirmation:debug:event-listener';

    private $tokenRepository;
    private $eventDispatcher;
    private $notRegisteredEventCount = 0;

    public function __construct($name = null, EventDispatcherInterface $eventDispatcher, TokenRepository $tokenRepository)
    {
        parent::__construct($name);
        $this->tokenRepository = $tokenRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function configure(): void
    {
        $this
            ->setName(self::NAME)
            ->setDescription(sprintf('Check if you have all registered listeners( only %s )', ConfirmationExtension::ALIAS));
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $this->checkTokenTypeListener($io);

        if (!$this->notRegisteredEventCount) {
            $io->success(ConfirmationExtension::ALIAS);
        }
    }

    private function checkTokenTypeListener(SymfonyStyle $io): void
    {
        $note = 'Remove it from table or add event listener in your service.yaml to handle it';
        foreach ($this->tokenRepository->getItterator() as $items) {
            foreach ($items as $item) {
                if (!$this->eventDispatcher->hasListeners(Events::ACCEPT_TOKEN . $item['type'])) {
                    $io->error(sprintf(EventListenerDebuger::REQUIRED_NOTICE, Events::ACCEPT_TOKEN . $item['type']));
                    $io->note($note);
                    $this->notRegisteredEventCount++;
                }
                if (!$this->eventDispatcher->hasListeners(Events::ERROR_ACCEPT_TOKEN . $item['type'])) {
                    $io->error(sprintf(EventListenerDebuger::REQUIRED_NOTICE, Events::ERROR_ACCEPT_TOKEN . $item['type']));
                    $io->note($note);
                    $this->notRegisteredEventCount++;
                }
            }
        }
    }
}