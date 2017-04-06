# JRCS
[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.com/cbartram/JRCS)

A Volunteer Management Software for Jacksonville Refugee services

This software helps manage multiple volunteers, donation, events, and programs for the Jacksonville Refugee Community Services.

JRCS Volunteer Management is a web based application hosted in the cloud for scalability and performance. 

## Installation
JRCS Can be easily installed on a local environment. If you prefer to use the JRCS applicatino without downloading any files you can access the production version of the application at `https://jrcs.herokuapp.com`. Simply open up a command line utility navigate to the directory where you want JRCS installed and type `git clone https://github.com/cbartram/JRCS.git`

This will clone the JRCS repository onto your local computer.

Next Navigate to the root directory of JRCS in your command line utility e.g. `cd laravel-jrcs` 

Run `php artisan serve` this will launch the JRCS application on PHP's built it webserver using artisan. You can view the application at `http://localhost:8000/`

## Configuring the Database
Contact *@cbartram* if you have any issues with the database or want to setup a local copy instead. By default JRCS will connect to the database set up in the development environment on Heroku, however, this may not be ideal for testing application components which require inserting or updating large quantities of data in the database.

## Common Issues
Ensure that you install composer (dependency manager) for php correctly from http://getcomposer.org

Run this in a command prompt or terminal 
`php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
`php composer-setup.php`
`php -r "unlink('composer-setup.php');"`

The basic script above: 
- Downloads the installer to the current directory
- Verifies the installer SHA-384 Hash
- Runs the installer
- Removes the installer

(If it gives you an error run the commands as `sudo`)

Now that you have composer installed run 
`php composer-setup.php --filename=composer`

*On Mac* you can simply do `sudo mv composer.phar /usr/local/bin/composer` to move composer to your classpath. 
Access composer in terminal using the cmd `composer` from wherever you are!

*On Windows* follow this tutorial http://leedavis81.github.io/global-installation-of-composer-on-windows/

Navigate to your root directory for JRCS and run `composer update` after composer has been updated run `php artisan serve` to access your local webserver at http://localhost:8000/

If your still recieving errors try following the composer installation guide from the beginning on their website at http://getcomposer.org 


## Version Log
### Version 1.0.0
- initial commit
- created user php class
- added local database connection

### Version 1.0.1
- added jquery and js to asych login users 
- added php file to log in users based on which button they clicked
- added staff abiliity to log into all 3 volunteer sites

### Version 1.0.2
- Cleaned up volunteer_profile UI 
- added additional methods to query db
- cleaned up db design
- added code documentation for `User.Class.php`

### Version 1.0.3
- Added Travis.yml file for CI
- Added Heroku PHP App for deployable dev environment
- Added Seamless transitioning between volunteer groups
- App only shows groups that are available to the user

### Version 1.0.4
- Added Admin Login for a high level overview
- Added Slim Micro framework to map php callback functions to HTTP Requests for Restful API
- Bug fixes 
- Changed Directory structure to accomodate autoload.php and Composer.json

### Version 1.0.5
- Added DB_migrations SQL
- Added Slim framework compatibility for Routing URI's to specific HTTP req's
- Fixed Bug with Card titles showing volunteers group
- Wrote JS API to query backend and reuturn JSON Objects

### Version 2.0.0
- JRCS 2.0 is here!!! 
- New and more stable Frontend js api
- Eloquent query building api
- correct composer.json so project dependencies can be managed added and deleted like a breeze!
- Fully correct MVC Design structure
- Blade templating engine added 
- Laravel framework and support built right in!
- Simplified database design
- Increased security
- SQL Injection protection
- CRSF Tokenization
- Sitewide encryption
- XSS & JS Protection Protection 
- So so so much more!

### Version 2.0.1
- Added Password Reset functionality 
- Added ability for staff to add new volunteers to their respective groups
- Fixed several bugs and security issues
- Added account settings panel which gives staff several ways to manage their account

### Version 2.1.0
- Added Redis functionality
- Rewrote UI across the entire site
- Show/Hide for all panels
- New and easy to use navbar
- Added Additional Account Settings
- Highcharts integration
- FullCalendar integration
- Persistant storage for account settings instead of using sessions
- Event, Calendar, and event logging functionality added
- Donation, donation approva/denial functionality added
- More expressive definitions between staff and admin 
- Volunteer *Drag and Drop* to switch and copy volunteers between group
- Volunteer drag and drop to delete volunteers

### Version 2.1.1
- Multiple Bug fixes
- Much more verbose JS API 
- includes functions to: interact with events (CRUD), authenticate user emails and passwords, check-in and check-out volunteers, and open, close, approve, and deny donations
- Functions to interact with volunteer events, donations, data and more
- Account settings update to include showing drag and drop for all groups
- bulk checkout feature for staff members
- ability to delete/re-open a previously approved donation
- dynamic programs and events (ability to remove events from the calendar, and add and delete programs) 
- More controls for the calendar on the profile page
- client requested changes (2 password reset fields, nationality, switching login and cico pages etc...)

### Version 2.2.0
- Updated volunteer list to show accordian dropdown.
- Volunteer accordian dropdown shows volunteer hours per groups 
- Volunteer hours are broken down by groups
- Color coded events on the calendar
- Added larger volunteer creation form to store more information.



