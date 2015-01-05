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

/**
 * Manages the creation and management of the permissions matrix for a role.
 */
HTML::macro('permissionsMatrix', function($role) {
    $resources = \PermissionResources::get();
    $formatted = [];

    foreach ($resources as $resource) {
        $resourceName = str_replace(['Owner', 'All'], [' (own)', ' (others)'], $resource);

        $formatted[$resource] = $resourceName;
    }

    // Now sort the formatted array and set the value
    $resources = $formatted;

    return View::make('shift::roles.matrix', compact('role', 'resources'));
});

/**
 * Renders a collection of input radio elements, that refer to the allow/deny/inherit options
 * for a given permission and action configuration.
 *
 * @param object $role
 * @param string $resource
 * @param string $action
 */
HTML::macro('permission', function($role, $resource, $action) {
    $mode = 'inherit';

    foreach ($role->permissions as $permission) {
        if ($permission->resource == $resource && $permission->action == $action) {
            $mode = $permission->mode;
        }
    }

    return View::make('shift::roles.permission', compact('role', 'resource', 'action', 'mode'));
});
