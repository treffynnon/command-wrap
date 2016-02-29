<?php

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Runners\SymfonyProcess;

class SymfonyProcessTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithSymfonyProcess()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $r = new SymfonyProcess();
        $r->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(date('d-m-Y'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandWithSymfonyProcessCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $r = new SymfonyProcess();
        $r->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedSymfonyProcessCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $r = new SymfonyProcess();
        $r->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame('', trim($r->getOutput()));
        $this->assertSame(127, $r->getStatus());
    }
}