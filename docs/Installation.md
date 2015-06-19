Installation
------------

Clone the code into your apps plugin folder

	git clone git@github.com:burzum/cakephp-html-purifier.git app/Plugin/HtmlPurifier

or add it as submodule

	git submodule add git@github.com:burzum/cakephp-html-purifier.git app/Plugin/HtmlPurifier

In your config/bootstrap.php add

```php
Plugin::load('Burzum/HtmlPurifier', ['bootstrap' => true]);
```
