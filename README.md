CakePHP HTML Purifier Plugin
----------------------------

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://img.shields.io/travis/burzum/cakephp-html-purifier/2.0.svg?style=flat-square)](https://travis-ci.org/burzum/cakephp-html-purifier)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/burzum/cakephp-html-purifier/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/cakephp-html-purifier/)
[![Code Quality](https://img.shields.io/scrutinizer/g/burzum/cakephp-html-purifier.svg?branch=2.0?style=flat-square)](https://scrutinizer.io/r/burzum/cakephp-html-purifier)

This is a CakePHP wrapper for [the HTML Purifier lib](http://htmlpurifier.org/).

HTML Purifier is a standards-compliant HTML filter library written in PHP. HTML Purifier will not only remove all malicious code (better known as XSS) with a thoroughly audited, secure yet permissive whitelist, it will also make sure your documents are standards compliant, something only achievable with a comprehensive knowledge of W3C's specifications.

The plugin includes a trait, a view helper, a behavior and a shell to clean your markup wherever you like, in the view or in the model layer or clean any table and field using the shell.

---

* For **CakePHP 2.x** use the 1.x version or branch.
* For **CakePHP <=3.5** use the 2.0 version or branch.
* For **CakePHP > 3.5** use the 3.0 version or branch.

Documentation
-------------

For documentation, as well as tutorials, see the [docs](docs/Home.md) directory of this repository.

Support
-------

For support and feature request, please visit the [Support Site](https://github.com/burzum/cakephp-html-purifier/issues).

Contributing to this Plugin
---------------------------

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features. If you want to contribute some code, create a feature branch from develop, and send us your pull request. Unit tests for new features and issues detected are mandatory to keep quality high.

* Contributions must follow the [PSR2 coding standard recommendation](https://github.com/php-fig-rectified/fig-rectified-standards).
* [Unit tests](https://book.cakephp.org/4/en/development/testing.html) are required.

License
-------

Copyright 2012 - 2018 Florian Krämer

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.
