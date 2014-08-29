//(function() {
//    'use strict';
//
//    var module = angular.module('Shift.Library.Core.Factories', []);
//
//    /**
//     * The "stacktrace.js" library is included in the /js/vendor directory
//     * is on the the Global scope; but, we don't want to reference
//     * global objects inside the AngularJS components - that's
//     * not how AngularJS rolls.  So we want to wrap the
//     * "stacktrace.js" features in a proper AngularJS factory that
//     * formally exposes the print method.
//     */
//    module.service('StackTrace', [function (){
//
//        return ({
//            print: printStackTrace
//        });
//
//    }]);
//
//    // The error log service is our wrapper around the core error
//    // handling ability of AngularJS. Notice that we pass off to
//    // the native "$log" method and then handle our additional
//    // server-side logging.
//    module.service("ErrorLogger", ['$log', '$window', 'StackTrace', function( $log, $window, StackTrace ) {
//
//        // Log the given error to the remote server.
//        function log( exception, cause ) {
//
//            // Pass off the error to the default error handler
//            // on the AngularJS logger. This will output the
//            // error to the console (and let the application
//            // keep running normally for the user).
//            $log.error.apply( $log, arguments );
//
//            // Now, we need to try and log the error the server.
//            //
//            // TODO: Add some form of debouncing logic
//            // here to prevent the same client from
//            // logging the same error over and over again! All
//            // that would do is add noise to the log.
//            try {
//
//                var errorMessage = exception.toString();
//                var stackTrace = StackTrace.print({ e: exception });
//
//                // Log the JavaScript error to the server.
//                // We're using jQuery here as AngularJS $http
//                // service has a dependency on $exceptionHandler
//                // and this creates a circular dependency issue
//                $.ajax({
//                    type: "POST",
//                    url: "/log-error",
//                    contentType: "application/json",
//                    data: angular.toJson({
//                        errorUrl: $window.location.href,
//                        errorMessage: errorMessage,
//                        stackTrace: stackTrace,
//                        cause: ( cause || "" )
//                    })
//                });
//
//            } catch ( loggingError ) {
//
//                // For Developers - log the log-failure.
//                $log.warn( "Error logging failed" );
//                $log.log( loggingError );
//
//            }
//
//        }
//
//
//        // Return the logging function.
//        return( log );
//
//    }]);
//
//})();