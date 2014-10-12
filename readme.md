# Tectonic Shift

_**Note: Shift is still very much a work in progress, and its APIs and documentation are volatile. Use at your own risk until a stable release is ready. Tectonic Digital assumes no responsibility for any consequences of using this package.**_

## Work approach - repositories, entities, service layers and more.

* Tectonic Shift has been refactored to now utilise Doctrine as the main ORM for persisting and retrieving data from the database.
* Repositories have been given more responsibility in conforming to Doctrine requirements
* Models you'll notice are now Entities. They have far less responsibility and therefore can be passed around much more safely than before.
* Modules are now all utilised via service providers. Every module must have a service provider and have Shift provide it as part of its own service provider.
* Autoincrement of IDs to continue. If we ever get to a problem whereby IDs are not satisfactory, we'll deal with it then.

## Generators needed

Due to the large amount of code required to get things going (braces, new classes, new methods, comments.etc.). We need various generators to help manage this and ensure that our work continues quickly. I'm thinking of generating some PHPStorm templates that we can utilise.

## How code is executed, responsibilities of each layer

Not much has changed in respect to the lifecycle of an application:

1. Define a route, ensure it's linked to a controller and action
2. Requests get routed to controllers
3. Controllers to act as a layer for the HTTP requests. No business logic to be contained. Send off a request to a service, return response. Nothing more.
4. Repositories solely responsible for data access. The reason for this is two-fold:
	1. It abstracts away the utility classes (in this case models, entities and others) from our business logic and
	2. It ensures that caching and other systems such as elasticsearch will be more easily implemented as we need them in future.
5. We now have a solid service layer. Crud operations go via a crud service for that resource (because it's quite generic). Everything else to go via its own service (such as user registration).
6. Continued heavy use of events. Using Domain Driven Design to power the main architecture of the application with events used to tie into logic that may be outside of core domains. A perfect example is sending an email after a user is registered.
	1. User registers (data persisted to database)
	2. Event is fired with a new UserHasRegistered event object
	3. Listeners anywhere in the application (preferably ones in subdomains) listen to event and work with a specific event object.

## Helpers

1. To migrate workbench migrations (as we're using PSR-4) run: `php artisan migrate --path=workbench/tectonic/shift` from the laravel root. NOTE: `php artisan migrate --bench=tectonic/shift` will not work!