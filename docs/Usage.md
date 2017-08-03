# Usage

## The Behavior

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

## The Helper

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

## The Shell

Using the shell is very easy and self-explaining:

```sh
cake purify <table> <fields>
```

You can specify a purifier config to use as well:

```sh
cake purify <table> <fields> --config myconfig
```

## The Trait

Where ever you need the purifier you can simply add it to your class by using the [PurifierTrait](../src/Lib/PurifierTrait.php).

The trait add two methods:

* **purifyHtml($markup, $config = 'default')**: Cleans a passed string of HTML.
* **getHtmlPurifier($config = 'default')**: Gets a `\HtmlPurifier` instance by config name.

[See the official php documentation](http://php.net/manual/en/language.oop5.traits.php) for traits if you don't know how to use it.
