<?php

namespace spec\Treffynnon\CommandWrap\Combinators;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Treffynnon\CommandWrap\Builder;
use Treffynnon\CommandWrap\Combinators\AndAnd;

class AndAndSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Combinators\AndAnd');
    }

    function it_can_combine_two_builders(Builder $builder, Builder $builder2)
    {
        $this->set($builder, $builder2);
        $r = $this->get();
        $r->shouldHaveCount(2);
        $r[0]->shouldHaveType('Treffynnon\CommandWrap\BuilderInterface');
        $r[1]->shouldHaveType('Treffynnon\CommandWrap\BuilderInterface');
    }

    function it_can_combine_builders_and_its_self($envVar, $commandLine, $assembler, $builder, $builder2)
    {
        $assembler->beADoubleOf('Treffynnon\CommandWrap\Assemblers\AssemblerInterface');
        $assembler->getCommandString(null)->willReturn('command');

        $builder->beADoubleOf('Treffynnon\CommandWrap\BuilderInterface');
        $builder->implement('Treffynnon\CommandWrap\Combinators\CombinableInterface');
        $builder->getCommandLine()->willReturn('first command');
        $builder->getCommandAssembler()->willReturn($assembler);

        $builder2->beADoubleOf('Treffynnon\CommandWrap\BuilderInterface');
        $builder2->implement('Treffynnon\CommandWrap\Combinators\CombinableInterface');
        $builder2->getCommandLine()->willReturn('second command');
        $builder2->getCommandAssembler()->willReturn($assembler);

        $combinator = new AndAnd(
            $builder->getWrappedObject(),
            $builder2->getWrappedObject()
        );
        $this->set($combinator, $builder, $combinator, $builder2, $combinator);
        $r = $this->get();
        $r->shouldHaveCount(5);
        $r[0]->shouldHaveType('Treffynnon\CommandWrap\Combinators\CombinatorInterface');
        $r[1]->shouldHaveType('Treffynnon\CommandWrap\BuilderInterface');
        $r[2]->shouldHaveType('Treffynnon\CommandWrap\Combinators\CombinatorInterface');
        $r[3]->shouldHaveType('Treffynnon\CommandWrap\BuilderInterface');
        $r[4]->shouldHaveType('Treffynnon\CommandWrap\Combinators\CombinatorInterface');

        $this->getCommandAssembler()->getCommandString()->shouldBeLike('command && command && command && command && command && command && command && command');
    }
}
