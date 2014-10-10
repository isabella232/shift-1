(function () {
    'use strict';

    /**
     * The following module helps to handle modal popups within the project. It's rather
     * light-weight, simply providing the means to easily popup a modal window. The HTML,
     * CSS and any other visuals is handled completely separately. Modalize cares not
     * for its implementation, only that it can be used.
     *
     * Usage:
     * First configure Modalize to use a template you've creatd, for instantiating the modal window:
     *
     * App.value('modalize.config', {
 *  template: '/views/partials/modal.html'
 * });
     *
     * Now, in your HTML, execute like so:
     *
     * <element mg-modal="/path/to/child/template.html" />
     *
     * @author Kirk Bushell
     * @date 11th February 2013
     */
    var module = angular.module('Shift.Library.Core.Modalize', []);

    module.service( 'Modalize' , [ '$rootScope' , function( $rootScope ) {
        var service = {

            /**
             * Defines the URL of the modal.
             *
             * @type {mixed}
             */
            url: null,

            /**
             * Defines if the modal is open or not.
             *
             * @type {boolean}
             */
            visible: false,

            /**
             * Size of the modal in pixels.
             *
             * @type {string}
             */
            size: null,

            /**
             * Closes the modal.
             *
             * @param {object} scope If a scope is provided, we'll call the scope.$apply() method.
             *
             * @return {void}
             */
            close: function( scope ) {
                service.visible = false;
                service.url = '';
                service['size'] = null;

                if ( !angular.isUndefined( scope ) && !scope.$$phase ) {
                    scope.$apply();
                }

                // Throw an event to let the app know that the modal is closed.
                $rootScope.$broadcast( 'modal.closed' );
            },

            /**
             * Opens the modal and allows setting a new URL.
             *
             * @param  {string} url
             * @param  {string} size WxH e.g. 400x200
             *
             * @return {void}
             */
            open: function( url , size ) {
                if ( !angular.isUndefined( url ) && angular.isString( url ) && url.length ) {
                    service.url = url;
                }

                service['size'] = null;
                if ( !angular.isUndefined( size ) && angular.isString( size ) ) {
                    service['size'] = size;
                }

                service.visible = true;

                // Throw an event to let the app know that the modal has opened.
                $rootScope.$broadcast( 'modal.opened' );
            },

            /**
             * If the size is provided correctly, it gets parsed and an object containing
             * the width and height is returned after ensuring that it's not too small.
             *
             * @return {object}
             */
            parseSize: function() {
                var parts = service['size'].split('x'), w, h;

                // Only continue if the size has 2 splits, meaning the format provided is valid.
                if ( parts.length !== 2 ) return null;

                w = parts[ 0 ];
                h = parts[ 1 ];

                // Ensure that a minimum size of 300x200 is provided.
                if ( w < 300 ) w = 300;
                if ( h < 200 ) h = 200;

                // Return an object suitable to use in jQuery's .css() method.
                return {
                    width:  w,
                    height: h
                }
            }
        };

        return service;
    }]);

    module.directive( 'modal' , [ 'Modalize' , function( Modalize ) {
        var $container = $('#modal-container'),
            $content   = $('#modal-content');

        return {
            restrict: 'A',
            link: function( scope , element, attributes ) {
                // Close button should tell the Modalize module to close.
                scope.close = Modalize.close;

                // Watch the visible property on the Modalize service and display and update the template url
                // whenever the visibile is set to true.
                scope.$watch( function() { return Modalize.visible; }, function( visibility ) {
                    if ( visibility && Modalize.url ) {
                        scope.template = Modalize.url;

                        if ( Modalize['size'] ) $content.css( Modalize.parseSize() );
                    }

                    // Determines whether or not to show or hide the modal.
                    scope.visible = visibility;
                });
            }
        }
    }]);


})();