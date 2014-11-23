# Shift

[![Circle CI](https://circleci.com/gh/tectonic/shift.png?style=badge)](https://circleci.com/gh/tectonic/shift)

Shift is a development platform for SAAS applications. It uses the latest and greatest technologies, including Laravel 5 and Angular JS 1.2.x (1.3+ doesn't support IE8), utilises the best development patterns and methodologies currently in use in the market, and has an intense focus on security and performance. As a result Shift is a robust, secure, feature-rich development platform for anyone wanting to create a product as a SaaS delivery platform.

## Installation

Shift is a package that can be installed via composer, in the usual manner:

    composer require tectonic/shift --prefer-source

As Shift is still currently in a beta state, no official releases have been created.

Then, you need to setup the database tables, required data.etc.

    php artisan migrate --package=tectonic/laravel-localisation
    php artisan migrate --package=tectonic/shift
    
Then, make sure you publish the assets of the package:

    php artisan asset:publish tectonic/shift

All done!

# License
 
The MIT License (MIT)
[OSI Approved License]
The MIT License (MIT)

Copyright (c) 2014 Tectonic Digital

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
