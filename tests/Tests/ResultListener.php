<?php

namespace Tests;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestSuite;

class ResultListener implements \PHPUnit_Framework_TestListener
{
	protected $suites = array();

	public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		$this->output("Error: %s", $e->getMessage());
	}

	public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
	{
		$this->output("Failed: %s", $e->getMessage());
	}

	public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		$this->output("Incomplete: %s", $e->getMessage());
	}

	public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		$this->output("Skipped: %s", $e->getMessage());
	}

	public function startTest(PHPUnit_Framework_Test $test)
	{
		$this->output($test->getName());
	}

	public function endTest(PHPUnit_Framework_Test $test, $time)
	{
		$this->output("");
	}

	public function startTestSuite(PHPUnit_Framework_TestSuite $suite) {}

	public function endTestSuite(PHPUnit_Framework_TestSuite $suite) {}

	/**
	 * Sends output to the console.
	 *
	 * @param array $arguments
	 */
	private function output()
	{
		echo call_user_func_array('sprintf', func_get_args())."\n";
	}
}
