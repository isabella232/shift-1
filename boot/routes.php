<?php
/**
 * Shift-specific routing rules and filter definitions.
 */

Route::whenRegex('/^(?!install)/i', 'shift.account');
