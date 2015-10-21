Usage
=====

If you use APC ...
------------------

...and get this error message

	Fatal error: Cannot override final method HTMLPurifier_VarParser::parse()

you can fix this by adding

```php
Configure::write('HtmlPurifier.standalone', true);
```

to your bootstrap.php *before* you load this plugin.

This line will use a compacted one file version of Html Purifier. This is an official and know issue and workaround, see http://htmlpurifier.org/phorum/read.php?3,4099,6680.

Configuration
-------------

Important: Before you start declaring a configuration you should lookup how HTML Purifier can be configured. http://htmlpurifier.org/docs

In `config/bootstrap.php` you can either set the purifier config as an array or pass a native config object.

The array style would look like this:

```php
// Don't forget to add the `use` statement
use Burzum\HtmlPurifier\Lib\Purifier;

Purifier::config('ConfigName', array(
		'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img',
		'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt'
	)
);
```

The plugin will construct a HTML Purifier config from that and instantiate the purifier.

A pure HTML Purifier config might look like this one:

```php
$config = HTMLPurifier_Config::createDefault();
$config->set('HTML.AllowedElements', 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img');
$config->set('HTML.AllowedAttributes', 'a.href, a.title, img.src, img.alt');
$config->set('HTML.AllowedAttributes', "*.style");
$config->set('CSS.AllowedProperties', 'text-decoration');
$config->set('HTML.TidyLevel', 'heavy');
$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
```

Simply assign it to a config:

```php
Purifier::config('ConfigName', $config);
```

Now that you have a configured instance of HTML Purifier ready you can use it directly and get you an instance of the purifier

```php
Purifier::config('ConfigName');
```

or clean some dirty HTML directly by calling

```php
Purifier::clean($markup, 'ConfigName');
```

For some automatization you can also use the Behavior or Helper.

### Caching ###

It is recommended to change the path of the purifier libs cache to your `tmp` folder. For example:

```php
Purifier::config('ConfigName', array(
		'Cache.SerializerPath' => ROOT . DS . 'tmp' . DS . 'purifier',
	)
);
```

See this page as well http://htmlpurifier.org/live/configdoc/plain.html#Cache.

### The Behavior

Set a config you want to use and the fields you want to sanitize.

```php
public $actsAs = array(
	'Burzum/HtmlPurifier.HtmlPurifier' => array(
		'config' => 'ConfigName',
		'fields' => array(
			'body', 'excerpt'
		)
	)
);
```

### The Helper

In your controller load the helper and set a default config if you want.

```php
public $helpers = array(
	'Burzum/HtmlPurifier.HtmlPurifier' => array(
		'config' => 'ConfigName'
	)
);
```

In the views you can then use the helper like this:

```php
$this->HtmlPurifier->clean($markup, 'ConfigName');
```
