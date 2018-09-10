# Clay Back-end Assessment

Submission by **Aryel Tupinambá**


## Project scope

- Admin panel to manage locks & accessors
- Registered accessors can login to the panel
- API w/ accessor-bound JWT to get list of locks & manage their status
- Status changes are queued, call CLP API
- Audit trail at every event
	- Request generates an event
	
	
## Technology stack
- Laravel 5.7
- VueJS
- JWT tokens

## Stack choice reasoning
I picked Laravel because it is a very flexible and fast framework for quick prototyping, and has an overall 'batteries included' approach, without forcing design sacrifices.

I picked VueJS for it's simplicity and expressiveness.

I chose JWT for client authentication to avoid the time cost of implementing a fuller, more complete OAuth solution.


## Architecture
This application follows sound MVC architectural patterns, and follows many of the DDD patterns and recommendations. 

It does not, however, implement a strict hexagonal architecture (where domain models are completely isolated from the application and UI layers), as this adds unnecessary complexity for the simplicity of this tool, as well as requiring a data mapper ORM (such as Doctrine), which takes much longer to integrate and optimize.

As the specs were mostly abstract, I had to assume a lot of the technical aspects and feature requirements. There was no indication of how the system would talk to Clay's CLP, or possibly directly to the IQ hardware, so I initially thought of having these API calls happen in a queued fashion. After getting some more boilerplate done, I realized the nature of lock/unlock operations are much more on-time, and I had no way of having these async API calls happen, so I opted to discard the queued approach and go straight for a service provider.


## Room for improvement
There are many things I would improve/change with more time: 
- Move most of the cross-cutting operations happening in models (such as `Lock::attemptAccess`) to Services instead.
- Further integration with the actual CLP would be nice
- Having a way to poll the actual hardware after the lock is 'unlocked', to identify when it has closed and locked by itself
- Improve test coverage of edge cases
- Redesign the `Access` object (or maybe have a different object) to keep track of failed lock/unlock attempts (though these shouldn't be normally possible in the actual UI)
- Add test coverage for the admin panel (using Laravel Dusk)


## How to install and run locally
- Clone the repo from GitHub
- Install composer dependencies with `composer install`
- Configure the environment by copying `.env.example` into `.env`, and updating the setings
- Run `php artisan app:key` to generate the `APP_KEY`
- Run `php artisan jwt:secret` to generate the `JWT_SECRET`
- Run `php artisan migrate` to create the tables
- Run `php artisan maintenance:create_admin` to create admin users
- Run `php artisan db:seed` to seed the database with test data

## To develop / test locally
- Make sure to install composer dev dependencies
- Run tests with `phpunit` and the `phpunit.xml` config
- Run `npm install` to install front-end deps
- Run `npm run watch` to start the frontend asset pipeline