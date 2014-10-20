<?php

namespace Tectonic\Shift\Library\Search;

interface SearchInterface
{
    /**
     * All search implementations need to have a fromInput method. This is a method that executes
     * the criteria registered based on the input array provided. This will usually come from
     * an end user.
     *
     * @param array $input
     * @return mixed
     */
    public function fromInput(array $input = []);
}
