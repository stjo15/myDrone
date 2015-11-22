DRONE ZONE
=========

Drone Zone is a 'Stack Overflow' style website based on the Anax MVC Framework. 
The language of the content is swedish but the code is written in english so you
should be able to localize it easily enough.

To setup your own project, follow these steps:

1. Clone this repository

2. Open app/config/confiq_mysql in your text editor and change
yourUsername, yourPassword, yourHost and yourDatabaseName according to your environment.

3. Import all .sql files in db-tables/* to your database.

4. If you have problems with the theme or CSS, you may need to change the user rights 
of webroot/css/stalle-grid/ folder to 777. Delete the cache file, reload the page and
you should be good to go!

5. The admin account is already created. Login with username 'admin' and password 'secret'.
IMMEDIATELY edit your admin user and choose a safer password.


License
------------------

This software is free software and carries a MIT license.



Use of external libraries
-----------------------------------

The following external modules are included and subject to its own license.



### Modernizr
* Website: http://modernizr.com/
* Version: 2.6.2
* License: MIT license
* Path: included in `webroot/js/modernizr.js`



### PHP Markdown
* Website: http://michelf.ca/projects/php-markdown/
* Version: 1.4.0, November 29, 2013
* License: PHP Markdown Lib Copyright © 2004-2013 Michel Fortin http://michelf.ca/
* Path: included in `3pp/php-markdown`

```
 .  
..:  Copyright (c) 2013 - 2015 Staffan Johansson, stalle.johansson@gmail.com
```
