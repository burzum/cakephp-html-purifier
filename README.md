CakePHP HTML Purifier Plugin
----------------------------

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt) 
[![Build Status](https://img.shields.io/travis/burzum/cakephp-html-purifier/master.svg?style=flat-square)](https://travis-ci.org/burzum/cakephp-html-purifier) 
[![Build Status](https://img.shields.io/coveralls/burzum/cakephp-html-purifier/master.svg?style=flat-square)](https://coveralls.io/r/burzum/cakephp-html-purifier)

This is a CakePHP wrapper for the HTML Purifier lib. http://htmlpurifier.org/

HTML Purifier is a standards-compliant HTML filter library written in PHP. HTML Purifier will not only remove all malicious code (better known as XSS) with a thoroughly audited, secure yet permissive whitelist, it will also make sure your documents are standards compliant, something only achievable with a comprehensive knowledge of W3C's specifications.

The plugin includes a Helper and Behavior to clean your markup wherever you like, in the view or in Model::beforeSave.

---

**For CakePHP 2.x use the 1.x version or branch!**

Documentation
-------------

For documentation, as well as tutorials, see the [docs](docs/Home.md) directory of this repository.

Support
-------

For support and feature request, please visit the [UserTools Support Site](https://github.com/burzum/cakephp-user-tools/issues).

Branch strategy
-------------

* The **master** branch holds the `STABLE` latest version of the plugin.
* The **develop** branch is `UNSTABLE` and used to test new features before releasing them.
* Only **hot fixes** are accepted against the master branch.

Contributing to this Plugin
---------------------------

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features. If you want to contribute some code, create a feature branch from develop, and send us your pull request. Unit tests for new features and issues detected are mandatory to keep quality high.

* Pull requests must be send to the ```develop``` branch.
* Contributions must follow the [PSR2 coding standard recommendation](https://github.com/php-fig-rectified/fig-rectified-standards).
* [Unit tests](http://book.cakephp.org/3.0/en/development/testing.html) are required.

License
-------

Copyright 2013 - 2015 Florian Krämer

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.
