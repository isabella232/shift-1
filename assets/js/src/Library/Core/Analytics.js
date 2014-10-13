(function () {
    'use strict';

    /**
     * Analytics tracking
     *
     * Currently set up to use Google Analytics.
     * If you wish to use another tracking service, update the track methods.
     */
    angular
        .module('Shift.Library.Core.Analytics', [])
        .factory('Analytics', Analytics);

    Analytics.$inject = ['$window', '$rootScope'];
    function Analytics($window, $rootScope) {
        return {

            /**
             * Tracks a custom event.
             * This is useful for tracking specific actions, such as how many times
             * a video is played.
             *
             * @param  {string} category Required category name
             * @param  {string} action Required action
             * @param  {string} label Optional label
             *
             * @return {boolean}
             */
            trackEvent: function( category , action , label ) {
                if ( $window._gaq && category.length && action.length ) {
                    $window._gaq.push([ '_trackEvent' , category , action , label ]);

                    if( $rootScope.settings[ 'app.site.google_analytics_code' ] ) {
                        $window._gaq.push([ 'secondTracker._trackEvent' , category , action , label ]);
                    }

                    return true;
                }

                return false;
            },

            /**
             * Tracks a page.
             * This is useful for AJAX apps where the page changes without reloading.
             *
             * @param  {string} url Required url to track
             *
             * @return {boolean}
             */
            trackPageView: function( url ) {
                if ( $window._gaq && url.length ) {
                    $window._gaq.push([ '_trackPageview' , url ]);

                    if( $rootScope.settings[ 'app.site.google_analytics_code' ] ) {
                        $window._gaq.push([ 'secondTracker._trackPageview' , url ]);
                    }

                    return true;
                }

                return false;
            }

        }
    };

})();