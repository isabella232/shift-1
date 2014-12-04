<?php

namespace Tectonic\Shift\Library;

class Router extends \Illuminate\Routing\Router
{
	/**
	 * Helper method for registering entire route collections, following the Shift standard
	 * for routing. Creates the listing, creation, edit, delete and update routes for the
	 * requested resource.
	 *
	 * @param string $path The path (relative, without leading or trailing slashes) of the route collection, such as "users"
	 * @param string $class The resource of the request, such as "users"
	 * @param array $options You can exclude certain requests, by doing the following:
	 *
	 *  route_collection( "users", "users", "shift", [ "exclude" => [ "get" => "index" ] ] );
	 *
	 * This would register all routes, EXCEPT the GET "users" request.
	 */
	public function collection($path, $class, $options = [])
	{
		$defaults = [
			'get'    => ['index', 'new', 'view'],
			'post'   => ['store'],
			'put'    => ['update'],
			'delete' => ['destroy']
		];

		$allowed_methods = ['get', 'post', 'put', 'delete'];
		$include = array_get($options, 'include', $defaults);
		$exclude = array_get($options, 'exclude', []);
		$routes  = [];

		foreach ($include as $method => $actions) {
			if (!in_array($method, $allowed_methods)) continue;

			foreach ($actions as $action) {
				// make sure the items have not been excluded specifically
				if (!isset($exclude[$method]) or !in_array($action, (array) $exclude[$method])) {
					$routes[] = $method . '.' . $action;
				}
			}
		}

        if (array_search('get.new', $routes) !== false) {
            $this->get("{$path}/new", "{$class}@getNew");
        }

		if (array_search('get.view', $routes) !== false) {
			$this->get("{$path}/{id}", "{$class}@getShow");
		}

		if (array_search('put.update', $routes) !== false) {
			$this->put("{$path}/{id}", "{$class}@putUpdate");
		}

		if (array_search('get.index', $routes) !== false) {
			$this->get($path, "{$class}@getIndex");
		}

		if (array_search('post.store', $routes) !== false) {
			$this->post($path, "{$class}@postStore");
		}

		if (array_search('delete.destroy', $routes) !== false) {
			$this->delete("{$path}/{id}", "{$class}@deleteDestroy");
			$this->delete($path, "{$class}@deleteDestroy");
		}
	}
}