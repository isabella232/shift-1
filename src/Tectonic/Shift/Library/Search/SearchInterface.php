<?php

namespace Tectonic\Shift\Library\Search;

interface SearchInterface
{
	public function results();
	public function setParams(array $params);
	public function getParams();
}
