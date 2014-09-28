/*
 Function: viewPath

 When dealing with views and skins, it is possible that the path could be very different to the default. For example, the default bundle's path
 is located at /bundles/bootstrap/views/tectonic/, whereas custom skins will reside at /views/skinname/. In addition, the viewPath helper locates
 any custom templates that may have been added that aren't considered part of any skin. These are loaded from /views/custom/.

 Parameters:

 path - The main path to the view. This should not include the views directory. Eg. users/form.html

 Returns:

 The full path to where the view is located, based on the skin configuration.
 */
var viewPath = function( path, bundle ) {
    var chunks = [ 'views' ];

    if ( customViews.indexOf( path ) != -1 ) {
        chunks.push( 'custom' );
    }
    else {
        if ( bundle ) {
            chunks = [ 'bundles', bundle, 'views' ];
        }
    }

    chunks.push( config.app.skin );
    chunks.push( path );

    path = '/' + chunks.join('/');

    return path;
};

/*
 Function: routeUrl

 Helps determine where requests should be routed to, depending on what the config.app.base
 value has been set to.

 Parameters:

 url - The relative URL (from root) you'd like to route to
 baseUrl - If true, uses the base url configuration variable, otherwise it will use the base PATH

 Returns:

 The relative correct URL to the given route
 */
var routeUrl = function( url, baseUrl ) {
    baseUrl = ( !baseUrl ) ? config.app.base : config.app.url;
    if ( url.substr( -1, 1 ) == '/' ) url = url.substr( 0, url.length - 1 );
    url = [ config.app.base, url ].join( '/' );

    return url;
};

/*
 Function: apiUrl

 Helps to associate the API's URL locations. This is necessary if the API resides in a different location to where the app
 is stored (different domain) or if the application's base URL (aka, it has a prefix) is provided.

 Parameters:

 url - The relative URL for the API request.
 baseUrl - If you would like a different base URL to do the request from, supply it here. This is to help with for example, if the API domain is different to the app's location.

 Returns:

 The updated, valid API url.
 */
var apiUrl = function( url, baseUrl ) {
    baseUrl = ( !baseUrl ) ? config.app.base : config.app.url;

    if ( url.substr( -1, 1 ) == '/' ) url = url.substr( 0, url.length - 1 );
    url = [ config.app.base, url ].join( '/' );

    return baseUrl + url;
};


/**
 * Splits an array into multiple chunks.
 *
 * @param  array  array The array to split up into chunks
 * @param  number chunk Chunk size.
 *
 * @return array
 */
var arrayChunk = function( array , chunk ) {
    var i, j, temp = [];

    for ( i = 0 , j = array.length; i < j; i += chunk ) {
        temp.push( array.slice( i , i + chunk ) );
    }

    return temp;
};


/**
 * Tests if a variable is available and returns it. It returns a
 * default otherwise. The default can be set as the second parameter,
 * otherwise the function will return null.
 *
 * @param  mixed input The variable to perform the check upon.
 * @param  mixed def   The default to be returned if above is undefined.
 *
 * @return mixed
 */
var get = function( input , def ) {
    if ( def == undefined ) def = null;

    return typeof input == 'undefined' ? def : input;
};

/**
 * Removes an item from an array if it's there.
 *
 * @param  array array The array to remove the item from.
 * @param  mixed value The item to remove from the array.
 *
 * @return mixed
 */
function arrayRemove(array, value) {
    var index = array.indexOf( value );

    if ( index >= 0 ) {
        array.splice( index , 1 );
    }

    return value;
};

/**
 * Makes the first character of the string an uppercase version.
 *
 * @param string str
 * @return string
 */
var ucFirst = function( str ) {
    if ( str && typeof str == 'string' ) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    return '';
};
