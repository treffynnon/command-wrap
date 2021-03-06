<?php

use Treffynnon\CommandWrap\Builder;
use Treffynnon\CommandWrap\Combinators\Semicolon;

class SemicolonTest extends PHPUnit_Framework_TestCase
{
    public function testCanBuildSemicolonCommandUp()
    {
        $x = new Builder();
        $x->addEnvVar('JAVA_BIN', '/usr/bin/java')
            ->addCommand('java')
            ->addArgument('jar')
            ->addFlag('t', 'xml')
            ->addCommand('src/');
        $y = new Builder();
        $y->addEnvVar('TMP_DIR', '/tmp')
            ->addCommand('foo')
            ->addArgument('verbose')
            ->addArgument('results-log', '/tmp/results.log')
            ->addFlag('f');

        $c = new Semicolon($x, $y);

        $this->assertSame(
            "JAVA_BIN='/usr/bin/java' java --jar -t='xml' src/ ; TMP_DIR='/tmp' foo --verbose --results-log='/tmp/results.log' -f",
            (string) $c
        );
    }
}
