(function(){
	var module = angular.module('Shift.Library.DefaultControllers', []);

	/**
	 * The Controller provider factory provides a method for standardising Angular controllers that
	 * follow a set pattern. This pattern is something we've (Tectonic) developed over time, reflecting
	 * index, creation, deletion, and update views, as well as its inherent functionality. It is very
	 * easy to include these default controllers and then extend them for your own use should you have
	 * specific requirements.
	 *
	 * Each element of the DefaultControllers service fires events at appropriate times that can be
	 * hooked into so as to provide custom requirements for any service or resource.
	 */
	module.provider('Controller', function() {
		/**
		 * The index method for the default controllers represents the list view when viewing a range of the resource's
		 * data. It's a reflection of not only the current data, but also at what point in the data set the user is viewing
		 * (pagination) but also any search filters they may have applied.
		 */
		this.index = function($rootScope, $scope, $filter, Seeker, Deletism, Filter, Resource) {
			Filter.registerFilters(resource.toLower(), [
				new Field.Text({
					name: 'keyword',
					description: 'Search by '+resourceLower+' name.'
				})
			]);

			Deletism($scope, resourcePlural, resourcePlural);
			Seeker($scope, Resource, resourcePlural);
		};

		/**
		 * The create method provides the controller for creating new resource entries. It implements some defaults
		 * and also provides a save method on the $scope object for ease of use. You can simply call save() on your forms
		 * when dealing with new records to ensure that that resource is saved to the database via the API.
		 */
		this.create = function($rootScope, $scope, $filter, Resource) {
			$scope[resourceLower] = new Resource;
			$scope[resourceLower].title = 'New ' + res;

			$scope.save = this.saveResource($scope);
		};

		/**
		 * The update property for DefaultControllers is for updating existing records. You should already have the
		 * record saved to the database on the server, and then call this method via the DefaultControllers api and
		 * pass the saved record via the resolver. See an example below.
		 *
		 * resolve: {
		 *     resource: DefaultControllers(User).update(user)
		 * }
		 */
		this.update = function($rootScope, $scope, $filter, resource) {
			return function() {
				$scope.resource = resource;
				$scope.save = this.saveResource($scope);
			};
		};

		/**
		 * Provides a standard way for saving a given resource. It will also fire an event that allows other packages
		 * to hook into for saving operations, should any extra properties be required.
		 */
		this.saveResource = function($scope) {
			return function() {
				var exists   = !!$scope[resourceLower].id;
				var preSave  = exists ? 'updating': 'creating';
				var postSave = exists ? 'updated' : 'created';

				$rootScope.$broadcast(resourceLower+'.'+preSave, $scope[resourceLower]);

				$scope[resourceLower].$save({}, function() {
					$rootScope.$broadcast(resourceLower+'.'+postSave, $scope[resourceLower]);

					$scope.go(resourcePlural);
				});
			};
		};
	});
})();

(function(){
    'use strict';

    var module = angular.module('Shift.Library.Defaults', ['$ngResource']);

    /**
     * The DefaultRoutes factory object provides routes for the the most common application requests. These include
     * the index view (list view), create, and update. These routes also point to the most common resource views
     * based on the package they represent. As a result, every time the Router is called, it must also be provided
     * with the package it is currently representing.
     */
    module.provider('DefaultRoute', ['ShiftRouteProvider', function(Router) {
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
    }]);

    module.provider('DefaultResolver', [function() {
        return {
            $get: []
        }
    }]);

    /**
     * The Resource service extends AngularJS's default $ngResource and makes it more susceptable to modern REST
     * standards and practises. What this means is, $save will call the appropriate method whether the records exists
     * or not (PUT for update and POST for create).
     */
    module.service('Resource', ['$resource', function($resource) {
        return function(url, params, methods) {
            var defaults = {
                update: {method: 'put', isArray: false},
                create: {method: 'post'}
            };

            methods = _.extend(defaults, methods);

            var resource = $resource(url, params, methods);

            resource.prototype.$save = function(data, callback) {
                if (!this.id) {
                    this.$create(data, callback);
                }
                else {
                    this.$update(data, callback);
                }
            };

            resource.lower = function() {
                return this.name.toLowerCase();
            };

            resource.lowerPlural = function() {
                return this.lower().pluralize();
            };

            return resource;
        };
    }]);
})();

(function() {
	'use strict';

	var module = angular.module('Shift.Library.Router', ['ngRoute', 'Shift.Library.Core.Services']);

	/**
	 * ShiftRouteProvider
	 *
	 * This is used by the Shift and other libraries to help register routes that are then later used
	 * by angular to match routes with controllers. Arguments provided should be identical to the routeProvider
	 * used in angularjs. This is simply a register to ensure we can define routes across modules, and have our
	 * main module (app) have them executed.
	 */
	module.provider('ShiftRoute', function() {
		return {
			$get: ['Config', function(Config) {
				var routes = [];
				var order = 0;
				
				/**
				 * Registers a route and stores it on the internal routes variable.
				 */
				return {
					register: function(route, options) {
						var thisOptions = angular.copy(options);
						var url = this.routeUrl(route);

						thisOptions.url = url;

						// push the templateurl option through our viewPath code
						if (thisOptions.templateUrl) thisOptions.templateUrl = this.viewPath(thisOptions);

						if (typeof thisOptions.order == 'undefined') {
							thisOptions.order = order;
							order = order + 10;
						}

						routes.push(thisOptions);
					},

					/**
					 * Returns the routes that have been registered.
					 */
					get: function() {
						return this.sortItems(routes);
					},

					/**
					 * Sorts routes based on their order property and returns the ordered routes.
					 *
					 * @return array
					 */
					sortItems: function(routes) {
						return _.sortBy(routes, function(route) {
							return route.order;
						});
					},

					/**
					 * Determines the actual URL (based on bootstrap pathing prefix) which is used for the route.
					 *
					 * @return string
					 */
					routeUrl: function(url, baseUrl) {
						baseUrl = (!baseUrl) ? Config.get('app.base') : Config.get('app.url');
						if (url.substr(-1, 1) == '/') url = url.substr(0, url.length-1);
						url = [Config.get('app.base'), url].join('/');

						return url;
					},

					/**
					 * Looks at the provided options (should contain the property: templateUrl) and determines where a
					 * view path may be found.
					 *
					 * @param object options
					 * @return string
					 */
					viewPath: function(options) {
						if (options.bundle) {
							return viewPath(options.templateUrl, options.bundle);
						}

						return viewPath(options.templateUrl);
					},

					/**
					 * Function: init
					 * Based on all registered routes, Router will now register them all with angular. This should be called once the app is ready.
					 */
					init: function($routeProvider) {
						angular.forEach(this.get() , function(route) {
							$routeProvider.when(route.url, route);
						});
					}
				};
			}]
		}
	});
})();

(function() {
	'use strict';

	var module = angular.module('Shift.Library.Core.Services', ['ngResource']);

	/**
	 * The Config service simply manages all configuration options for a given application,
	 * and the current account.
	 */
	module.service('Config', [function() {
		var config = {};

		// Hydrate the configuration service with the required options
		this.hydrate = function(configurationOptions) {
			angular.forEach(configurationOptions, function(value, key) {
				config[key] = value;
			});
		};

		// Register a new configuration option and its associated value
		this.add = function(key, value) {
			config[key] = value;
		};

		// Return a given configuration key's value
		this.get = function(key) {
			if (angular.isUndefined(config[key])) return null;

			return config[key];
		};
	}]);
})();

(function() {
	'use strict';

	var module = angular.module('Shift.Accounts.Controllers', ['Shift.Library.Defaults']);

	/*module.controller('shift.accounts', [
		'$rootScope',
		'$scope',
		'$filter',
		'Seeker',
		'Deletism',
		'Filter',
		'Account',
		DefaultControllers.index
	]);

	module.controller('shift.accounts.new', [
		'$rootScope',
		'$scope',
		'$filter',
		'Account',
		DefaultControllers.create
	]);

	module.controller('shift.accounts.edit', [
		'$rootScope',
		'$scope',
		'$filter',
		'install',
		DefaultControllers.update
	]);*/

})();

(function() {
	'use strict';

	var module = angular.module('Shift.Accounts.Setup', ['Shift.Library.Defaults']);

	module.config(['ShiftRouteProvider', function(ShiftRouteProvider) {
		ShiftRouteProvider('accounts', 'shift');
	}]);

})();

(function() {
    'use strict';

    var module = angular.module('Shift.Home.Controllers', ['Shift.Library.Defaults']);

    module.controller('shift.home', ['$scope', function($scope) {

    }]);

})();

(function() {
    'use strict';

    var module = angular.module('Shift.Home.Setup', ['Shift.Library.Defaults']);

    module.config(['ShiftRouteProvider', function(ShiftRouteProvider) {
        ShiftRouteProvider('home', {
            templateUrl: '/packages/tectonic/shift/views/home.html'
        });
    }]);

})();
(function() {
	'use strict';

	var module = angular.module('shift', [
        //'Shift.Library.Core.Services',
        //'Shift.Library.DefaultControllers',
        //'Shift.Library.Defaults',
        'Shift.Library.Router',
        'Shift.Home.Setup',
        'Shift.Home.Controllers'
    ]);

	module.config(['$locationProvider', 'ShiftRouteProvider', function($location, Router) {

        $location.html5Mode(true);

        Route.init();

	}]);

})();
