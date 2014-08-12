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
