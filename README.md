# JRCS
A Volunteer Management Software for Jacksonville Refugee services

##Version Log
###Version 1.0.0
- initial commit
- created user php class
- added local database connection

###Version 1.0.1
- added jquery and js to asych login users 
- added php file to log in users based on which button they clicked
- added staff abiliity to log into all 3 volunteer sites

###Version 1.0.2
- Cleaned up volunteer_profile UI 
- added additional methods to query db
- cleaned up db design
- added code documentation for `User.Class.php`

###Version 1.0.3
- Added Travis.yml file for CI
- Added Heroku PHP App for deployable dev environment
- Added Seamless transitioning between volunteer groups
- App only shows groups that are available to the user

###Version 1.0.4
- Added Admin Login for a high level overview
- Added Slim Micro framework to map php callback functions to HTTP Requests for Restful API
- Bug fixes 
- Changed Directory structure to accomodate autoload.php and Composer.json

###Version 1.0.5
- Added DB_migrations SQL
- Added Slim framework compatibility for Routing URI's to specific HTTP req's
- Fixed Bug with Card titles showing volunteers group
- Wrote JS API to query backend and reuturn JSON Objects

###Version 2.0.0
- JRCS 2.0 is here!!! 
- New and more stable Frontend js api
- Eloquent query building api
- correct composer.json so project dependencies can be managed added and deleted like a breeze!
- Fully correct MVC Design structure
- Blade templating engine added 
- Laravel framework and support built right in!
- Simplified database design
- So so so much more!

