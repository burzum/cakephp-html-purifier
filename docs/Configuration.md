# Configuration

## Purifier Filter Configuration

Important: Before you start declaring a configuration you should lookup how HTML Purifier can be configured. http://htmlpurifier.org/docs

In `config/boostrap.php` you can either set the purifier config as an array or pass a native config object.

The array style would look like this:

```php
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

## Caching ###

It is recommended to change the path of the purifier libs cache to your `tmp` folder. For example:

```php
Purifier::config('ConfigName', array(
		'Cache.SerializerPath' => ROOT . DS . 'tmp' . DS . 'purifier',
	)
);
```

See this page as well [http://htmlpurifier.org/live/configdoc/plain.html#Cache](http://htmlpurifier.org/live/configdoc/plain.html#Cache).
