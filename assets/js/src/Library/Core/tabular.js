(function () {
    'use strict';


        angular
            .module('Shift.Library.Core.Tabular', ['Shift.Library.Core.Analytics'])
            .factory('Tabs', Tabs)
            .directive('tab', TabDirective)
            .directive('tabs', TabsDirective)
            .directive('nextTab', nextTabDirective)
            .directive('previousTab', previousTabDirective)
            .service('TabsManager', TabsManager)
            .controller('tabs.view', TabsViewController);

        /**
         * Simply manages the various registered tab instances. Tabs generally only work within certain controllers.etc, but
         * sometimes we want to access them. As a result, when a new Tabs instance is created, it registers itself with the TabsManager
         * so that other controllers or directives can access these objects.
         *
         * It is preferable that once controllers or any other method has used the tabs, once it is destroyed, should then release the
         * instance from the tabs manager. This way, the manager is kept only for those that are currently in use.
         */
        function TabsManager() {
            return {
                /**
                 * Container that manages the registered instances.
                 */
                instances: {},

                /**
                 * Register a new Tabs instance for a given resource.
                 *
                 * @param string resource name in lower case of the resource the tabs represent
                 * @param object tabs
                 */
                register: function( resource, tabs ) {
                    this.instances[ resource ] = tabs;
                },

                /**
                 * Retrieves a registered tabs instance.
                 *
                 * @param  string resource
                 */
                instance: function( resource ) {
                    if ( !this.instances[ resource ] ) {
                        throw "Resource " + resource + " has not been registered with the tabs manager.";
                    }

                    return this.instances[ resource ];
                },

                /**
                 * Removes a registered resource from the TabsManager
                 *
                 * @param  string resource
                 */
                clean: function( resource ) {
                    if ( this.instances[ resource ] ) {
                        delete this.instances[ resource ];
                    }
                },

                /**
                 * Determines whether a given resource has been registered before.
                 *
                 * @param string resource
                 * @return boolean
                 */
                registered: function( resource ) {
                    return !!this.instances[ resource ];
                },

                /**
                 * Converts a resource and converts to lowercase.
                 */
                _resource: function( name ) {
                    return name.toLowerCase();
                }
            };
        };

        /**
         * Manages tabs for various resources. The idea is that we have a central service for managing
         * the tabs data throughout the application, as well as doubling as a registry for added tabs.
         *
         * Both controllers and directives can therefore use this service to query for registered tabs.
         */
        Tabs.$inject = ['$rootScope', '$timeout', 'TabsManager'];
        function Tabs($rootScope, $timeout, TabsManager) {
            return function( resource, style ) {
                var self = this;

                /**
                 * The name of this resource that this tabs represents, eg. "users".
                 */
                this.resource = resource;

                /**
                 * The Tabs style. Could be normal, or wizard, for example.
                 */
                this.style = style || 'normal';

                /**
                 * Each tab setup is generally housed under an object, such as Users or
                 * Roles. As a result, there may be points where we need to deal with this
                 * record/object in question - that's what this is for. At any time, we can
                 * set the record that the tabs are representing.
                 */
                this.data = null;

                /**
                 * Handles the tabs that this resource will be managing.
                 *
                 * @var array
                 */
                this.tabs = [];

                /**
                 * Registers a new tab for the resource.
                 *
                 * @param object tab
                 */
                this.register = function( tab ) {
                    tab.resource = this; // direct link to the tab's resource that would be otherwise hard to discover externally.

                    // Set the default tab to active
                    if ( tab.init ) {
                        tab.active = true;
                    }

                    if ( !this.exists( tab.name ) ) {
                        this.tabs.push( tab );
                    }
                };

                this.exists = function( name ) {
                    var existing = _.findWhere( this.tabs , { name: name } );

                    return existing ? true : false;
                };

                /**
                 * Returns the current tab for the page.
                 *
                 * @return object
                 */
                this.current = function() {
                    for ( var i = 0, c = this.tabs.length; i < c; i++ ) {
                        if ( this.tabs[ i ].active ) {
                            return this.tabs[ i ];
                        }
                    }

                    return null;
                };

                /**
                 * Sets the current tab, and passes the tab's name.
                 *
                 * @param string tabName
                 * @return tab object
                 */
                this.setCurrent = function( tabName ) {
                    var oldTab = this.current();
                    var newTab = this.getTabs( tabName );

                    $timeout(function() {
                        if ( newTab.enabled ) {
                            if ( oldTab ) {
                                oldTab.active = false;
                            }

                            newTab.active = newTab.enabled ? true : false;

                            // Google Analytics event tracking - only for enabled tabs.
                            //Analytics.trackEvent( 'Tabs' , 'Tab changed on ' + self.resource , 'Tab changed to ' + tabName );
                        }
                    }, 50);

                    return newTab;
                };

                /**
                 * Returns the tab after the current tab. If there is no next
                 * tab (aka, at the end) - then null is returned.
                 *
                 * @return object
                 */
                this.next = function() {
                    var returnNext = false;

                    for ( var i = 0, c = this.tabs.length; i < c; i++ ) {
                        if ( returnNext ) {
                            return this.tabs[ i ];
                        }

                        if ( this.tabs[ i ].active ) {
                            returnNext = true;
                        }
                    }

                    return null;
                };

                /**
                 * Returns the tab previous to the current tab.
                 *
                 * @return object
                 */
                this.previous = function() {
                    var returnPrevious = false;

                    for ( var i = this.tabs.length - 1; i >= 0; i-- ) {
                        if ( returnPrevious ) {
                            return this.tabs[ i ];
                        }

                        if ( this.tabs[ i ].active ) {
                            returnPrevious = true;
                        }
                    }

                    return null;
                };

                /**
                 * Returns the default tab, which is defined by setting init: true when registering the tab.
                 *
                 * @return object
                 */
                this.getDefault = function() {
                    for ( var i = 0, c = this.tabs.length; i < c; i++ ) {
                        if ( this.tabs[ i ].init ) {
                            return this.tabs[ i ];
                        }
                    }

                    if ( this.tabs[ 0 ] ) {
                        return this.tabs[ 0 ];
                    }

                    return null;
                };

                /**
                 * Returns the tabs that have been registerd for the resource.
                 *
                 * @return array
                 */
                this.getTabs = function( name ) {
                    if ( name ) {
                        for ( var i = 0, c = this.tabs.length; i < c; i++ ) {
                            if ( this.tabs[ i ].name == name ) return this.tabs[ i ];
                        }

                        return null;
                    }

                    return this.tabs;
                };

                /**
                 * Fires an event to ensure that other modules and plugins can register new tabs.
                 */
                this.finalize = function() {
                    $rootScope.$broadcast( 'tabs.' + this.resource + '.register', this );
                };

                // Register this instance with the TabsManager
                TabsManager.register( resource, this );
            };
        };

        /**
         * Renders the tabs themselves, not the tab content. Just a short helper function
         * for dealing with a small template partial that will be rendered.
         */
        function TabsDirective() {
            return {
                restrict: 'A',
                templateUrl: '/packages/tectonic/shift/views/partials/tabs.html'
            };
        };

        /**
         * Handles easy navigation of moving through tabs.
         */
        nextTabDirective.$inject = ['TabsManager'];
        function nextTabDirective(TabsManager) {
            return {
                scope: { condition: '&nextTab' },
                link: function( scope, element, attributes ) {
                    element.bind( 'click', function() {

                        var resource = scope.tabsResource;
                        if ( !resource ) {
                            resource = scope.$parent.tabsResource;
                        }

                        var tabs   = TabsManager.instance( resource );
                        var oldTab = tabs.current();
                        var newTab = tabs.next();

                        if ( newTab ) {
                            tabs.setCurrent( newTab.name );
                        }
                    });
                }
            }
        };

        /**
         * Handles easy navigation of moving through tabs.
         */
        previousTabDirective.$inject = ['TabsManager'];
        function previousTabDirective(TabsManager) {
            return {
                scope: { condition: '&previousTab' },
                link: function( scope, element, attributes ) {
                    element.bind( 'click', function() {
                        var resource = scope.tabsResource;

                        if ( !resource ) {
                            resource = scope.$parent.tabsResource;
                        }

                        var tabs   = TabsManager.instance( resource );
                        var oldTab = tabs.current();
                        var previousTab = tabs.previous();

                        if ( previousTab ) {
                            tabs.setCurrent( previousTab.name );
                        }
                    });
                }
            }
        };

        /**
         * Manages the state of this individual tab.
         */
        TabDirective.$inject = ['$rootScope', 'Notify'];
        function TabDirective($rootScope, Notify) {
            return {
                link: function( scope, element, attributes ) {
                    var index = scope.$index;

                    scope.$watch( 'tab.active', function( newValue, oldValue ) {
                        if ( !newValue ) {
                            element.removeClass( 'active' );
                        }
                        else {
                            element.addClass( 'active' );
                        }
                    });

                    scope.$watch( 'tab.enabled', function( newValue ) {
                        if ( true == newValue ) {
                            element.removeClass( 'disabled' );
                        }
                        else {
                            element.addClass( 'disabled' );
                        }
                    });

                    //- Start invalid form tab highlighting
                    var form        = null;
                    var formElement = $( element ).closest( 'form' );
                    var formScope   = formElement.scope() || [];

                    // Get the actual form object from angular
                    for ( var i = 0, c = formScope.length; i < c; i++ ) {
                        if ( i == formElement.attr( 'name' ) ) {
                            form = formScope[ i ];
                        }
                    }

                    // Now watch for changes, mm'kay?
                    scope.$on( 'form.submitting', function( event, submitType, form ) {
                        scope.invalid = false;

                        if ( form.$invalid ) {
                            var tabsControllerElement = formElement.find( 'div[ng-controller="tabs.view"]' );
                            var divFind = tabsControllerElement.find( 'div.tab-content' ).eq( index );
                            var invalidInputs = $( divFind ).find( '.ng-invalid' ).length;

                            if ( invalidInputs ) {
                                // Define an error on the scope to pass using an event.
                                // That way we can customise the error message.
                                scope.tabErrorMessage = 'There appears to be an issue with your input on the ' + scope.tab.name + ' tab. Please try and correct this issue before trying to save.';

                                $rootScope.$broadcast( 'notify.tab.error.' + scope.tab.name.toLowerCase() , scope );
                                $rootScope.$broadcast( 'notify.tab.error' , scope );

                                Notify.Error( scope.tabErrorMessage );

                                scope.invalid = true;
                            }
                        }

                        scope.$apply();
                    });


                    //- End invalid form tab highlighting

                    // If the requirement property is available on the tab, it means that the tab
                    // itself is only available and enabled if the condition is true. If this is a
                    // property, then just check the property's value for true. If it is a callback
                    // then let's execute the callback and again, watch for true value.
                    if ( scope.tab.requirement ) {
                        if ( typeof scope.tab.requirement == 'function' ) {
                            scope.$watch( function() {
                                return scope.tab.requirement( scope.tab );
                            }, function( newValue ) {
                                scope.tab.enabled = newValue;
                            });
                        }
                    }
                    else {
                        scope.tab.enabled = true;
                    }
                }
            }
        };

        /**
         * Tabs controller for the view. Sets up some helper methods as well as helping
         * with active tab support.etc. This controller has an external dependency which MUST be defined
         * on a parent scope, that being: $scope.tabsResource. This must represent the resource you wish to render
         * at this point.
         */
        TabsViewController.$inject = ['$scope', '$routeParams', 'TabsManager'];
        function TabsViewController($scope, $routeParams, TabsManager) {
            // Assign the tabs
            var tabs = TabsManager.instance( $scope.tabsResource );

            // Once everything is good to go, we want to emit a new event. This allows last-minute
            // changes to the tabs registration, ordering, or anything else, should it be necessary - at all.
            $scope.$emit( 'tabs.' + $scope.tabsResource + '.render', tabs );

            // Set the required tabular "style"
            $scope.style = tabs.style;
            $scope.resource = $scope.tabsResource;
            $scope.tabs = tabs.getTabs();

            // Set the active tab
            $scope.$watch( function() {
                return tabs.current();
            }, function( newTab ) {
                if ( newTab ) {
                    $scope.activeTab = newTab.name;
                }
            });

            // Set active tab based on $location or defaults
            if ( $routeParams.tab ) {
                var tab = tabs.getTabs( $routeParams.tab );

                if ( tab ) {
                    tabs.setCurrent( tab.name );
                }
            }
            else {
                var defaultTab = tabs.getDefault();
                tabs.setCurrent( defaultTab.name );
            }

            // Active tab click
            $scope.setActiveTab = function( tabName ) {
                tabs.setCurrent( tabName );
            };

            // Clean up and remove the tabs registration from the tabs manager. Once the view
            // is destroyed, there's no reason to keep it in memory.
            $scope.$on( '$destroy', function() {
                TabsManager.clean( 'entry' );
            });
        };


})();