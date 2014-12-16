<?php

/**
 * Returns the required translation for a given key. This method removes any call to
 * a namespace (such as shift::). The reason for this is to provide a level of anonymity
 * to the system when storing and caching keys across packages.
 *
 * @param string $key
 * @return string mixed
 */
function lang($key)
{
    $key = preg_replace('/^.+::/U', '', $key);

    return Translator::get($key);
}
