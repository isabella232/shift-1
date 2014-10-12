(function(){
    'use strict';
	
	/**
	 * Initialise the module.
	 */
    angular
	    .module('Shift.Library.Defaults', ['$ngResource', 'Shift.Library.Router'])
	    .provider('DefaultRoute', DefaultRouter)
	    .provider('DefaultResolver', DefaultResolver);

	/**
	 * The DefaultRoutes factory object provides routes for the the most common application requests. These include
	 * the index view (list view), create, and update. These routes also point to the most common resource views
	 * based on the package they represent. As a result, every time the Router is called, it must also be provided
	 * with the package it is currently representing.
	 */
	DefaultRouter.$inject = ['ShiftRouteProvider'];

    function DefaultRouter(Router) {
	    return function(resource, packageName) {
		    // Register the main list route
		    Router.register(resource, {
			    templateUrl: resource+'/index.html',
			    controller: resource,
			    package: packageName
		    });

		    // Register the create resource route
		    Router.register(resource+'/new', {
			    templateUrl: resource+'/form.html',
			    controller: resource+'.new',
			    package: packageName
		    });

		    // Register the update resource route
		    Router.register(resource+'/:id', {
			    templateUrl: resource+'/form.html',
			    controller: resource+'.edit',
			    package: packageName
		    });
	    };
    }

	/**
	 * The DefaultResolver does the heavy lifting of resolving most resource calls to the the API. This provides
	 * a defacto standard and approach to setting up resolution objects.
	 *
	 * @returns {{$get: Array}}
	 * @constructor
	 */
	function DefaultResolver() {
		return {
			$get: []
		}
	}
})();
