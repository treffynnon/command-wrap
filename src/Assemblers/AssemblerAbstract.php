<?php

namespace Treffynnon\CommandWrap\Assemblers;

use Treffynnon\CommandWrap\Types\CommandCollectionInterface;

abstract class AssemblerAbstract implements AssemblerInterface
{
    /**
     * @var CommandCollectionInterface
     */
    protected $commandLine;

    public function setCommandLine(CommandCollectionInterface $commandLine)
    {
        $this->commandLine = $commandLine;
    }

    public function getCommandLine(callable $filter = null)
    {
        return $this->commandLine->filter($filter);
    }
    
    public function __toString()
    {
        return $this->getCommandString();
    }
}
