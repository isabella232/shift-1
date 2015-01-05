<?php
/**
 * Returns the relative time for a given mysql timestamp.
 *
 * @param string $timestamp
 * @return string
 */
HTML::macro('relativeTime', function($timestamp) {
    return (new \Carbon\Carbon($timestamp))->diffForHumans();
});
