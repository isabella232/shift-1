<?php

namespace Tectonic\Shift\Library\Contracts;

interface SearchInterface
{
	public function results();
	public function setParams(array $params);
	public function getParams();
}
