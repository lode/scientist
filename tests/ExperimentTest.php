<?php

use Scientist\Experiment;
use Scientist\Matchers\StandardMatcher;

class ExperimentTest extends PHPUnit_Framework_TestCase
{
    public function test_that_a_new_experiment_can_be_created()
    {
        $e = new Experiment('test experiment');
        $this->assertInstanceOf(Experiment::class, $e);
    }

    public function test_that_experiment_name_is_set()
    {
        $e = new Experiment('test experiment');
        $this->assertEquals('test experiment', $e->getName());
    }

    public function test_that_a_control_callback_can_be_defined()
    {
        $e = new Experiment('test experiment');
        $control = function () {
            return true;
        };
        $e->control($control);
        $this->assertSame($control, $e->getControl());
    }

    public function test_that_a_trial_callback_can_be_defined()
    {
        $e = new Experiment('test experiment');
        $trial = function () {
            return true;
        };
        $e->trial('trial', $trial);
        $this->assertSame($trial, $e->getTrial('trial'));
    }

    public function test_that_multiple_trial_callbacks_can_be_defined()
    {
        $e = new Experiment('test experiment');
        $first = function () {
            return 'first';
        };
        $second = function () {
            return 'second';
        };
        $third = function () {
            return 'third';
        };
        $e->trial('first', $first);
        $e->trial('second', $second);
        $e->trial('third', $third);
        $expected = [
            'first'  => $first,
            'second' => $second,
            'third'  => $third
        ];
        $this->assertSame($expected, $e->getTrials());
    }

    public function test_that_a_chance_variable_can_be_set()
    {
        $e = new Experiment('test experiment');
        $e->chance(50);
        $this->assertEquals(50, $e->getChance());
    }

    public function test_that_an_experiment_matcher_can_be_set()
    {
        $e = new Experiment('test experiment');
        $e->matcher(new StandardMatcher);
        $this->assertInstanceOf(StandardMatcher::class, $e->getMatcher());
    }
}
