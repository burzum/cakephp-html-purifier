# If you are using APC ...

...and get this error message

	Fatal error: Cannot override final method HTMLPurifier_VarParser::parse()

you can fix this by adding

```php
Configure::write('HtmlPurifier.standalone', true);
```

to your bootstrap.php *before* you load this plugin.

This line will use a compacted one file version of Html Purifier. This is an official and know issue and workaround, see http://htmlpurifier.org/phorum/read.php?3,4099,6680.
