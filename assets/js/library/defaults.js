(function(){
	'use strict';

	var module = angular.module('shift.library.defaults', ['$ngResource']);

	/**
	 * The DefaultControllers factory provides a method for standardising Angular controllers that 
	 * follow a set pattern. This pattern is something we've (Tectonic) developed over time, reflecting 
	 * index, creation, deletion, and update views, as well as its inherent functionality. It is very 
	 * easy to include these default controllers and then extend them for your own use should you have 
	 * specific requirements.
	 *
	 * Each element of the DefaultControllers service fires events at appropriate times that can be
	 * hooked into so as to provide custom requirements for any service or resource.
	 */
	module.factory('DefaultControllers', function() {
		return function(Resource) {
			var resourceLower = Resource.name.toLowerCase();
			var resourcePlural = resourceLower.pluralize();

			/**
			 * The index method for the default controllers represents the list view when viewing a range of the resource's
			 * data. It's a reflection of not only the current data, but also at what point in the data set the user is viewing
			 * (pagination) but also any search filters they may have applied.
			 */
			this.index = ['$rootScope', '$scope', '$filter', 'Seeker', 'Deletism', 'Filter', function($rootScope, $scope, $filter, Seeker, Deletism, Filter) {
				Filter.registerFilters(resourceLower, [
					new Field.Text({
						name: 'keyword',
						description: 'Search by '+resourceLower+' name.'
					})
				]);

				Deletism($scope, resourcePlural, resourcePlural);
				Seeker($scope, Resource, resourcePlural);
			}];

			/**
			 * The create method provides the controller for creating new resource entries. It implements some defaults
			 * and also provides a save method on the $scope object for ease of use. You can simply call save() on your forms
			 * when dealing with new records to ensure that that resource is saved to the database via the API.
			 */
			this.create = ['$rootScope', '$scope', '$filter', function($rootScope, $scope, $filter) {
				$scope[resourceLower] = new Resource;
				$scope[resourceLower].title = 'New ' + res;

				$scope.save = this.saveResource($scope);
			}];

			/**
			 * The update property for DefaultControllers is for updating existing records. You should already have the
			 * record saved to the database on the server, and then call this method via the DefaultControllers api and
			 * pass the saved record via the resolver. See an example below.
			 *
			 * resolve: {
			 *     resource: DefaultControllers(User).update(user)
			 * }
			 */
			 }
			this.update = ['$rootScope', '$scope', '$filter', 'resource', function($rootScope, $scope, $filter, resource) {
				return function() {
					$scope.resource = resource;
					$scope.save = this.saveResource($scope);
				};
			}];

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
		};
	}]);
	
	/**
	 * The DefaultRoutes factory object provides routes for the the most common application requests. These include
	 * the index view (list view), create, and update. These routes also point to the most common resource views
	 * based on the package they represent. As a result, every time the Router is called, it must also be provided
	 * with the package it is currently representing.
	 */
	module.provider('DefaultRoute', ['ShiftRouteProvider', function(Router) {
		return function(Resource, package) {
			var resourcePlural = Resource.name.pluralize();

			// Register the main list route
			Router.register(resourcePlural, {
				templateUrl: resourcePlural+'/index.html',
				controller: resourcePlural,
				package: package
			});
			
			// Register the create resource route
			Router.register(resourcePlural+'/new', {
				templateUrl: resourcePlural+'/form.html',
				controller: resourcePlural+'.new',
				package: package
			});
			
			// Register the update resource route
			Router.register(resourcePlural+'/:id', {
				templateUrl: resourcePlural+'/form.html',
				controller: resourcePlural+'.edit',
				package: package
			});
		};
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
			
			methods = _.extend( defaults, methods );

			var resource = $resource( url, params, methods );

			resource.prototype.$save = function( data, callback ) {
				if ( !this.id ) {
					this.$create( data, callback );
				}
				else {
					this.$update( data, callback );
				}
			};

			return resource;
		};
	}]);
})();

