# CakePHP HTML Purifier Plugin

This is a CakePHP wrapper for the HTML Purifier lib. http://htmlpurifier.org/

HTML Purifier is a standards-compliant HTML filter library written in PHP. HTML Purifier will not only remove all malicious code (better known as XSS) with a thoroughly audited, secure yet permissive whitelist, it will also make sure your documents are standards compliant, something only achievable with a comprehensive knowledge of W3C's specifications.

The plugin includes a Helper and Behavior to clean your markup wherever you like, in the view or in Model::beforeSave.

## Setup

Clone the code

	git clone git://github.com/burzum/HtmlPurifier.git

In APP/bootstrap.php add

	CakePlugin::load('HtmlPurifier', array('bootstrap' => true));

## Usage

### Configuration

Important: Before you start declaring a configuration you should lookup how HTML Purifier can be configured. http://htmlpurifier.org/docs

In APP/Config/boostrap.php you can either set the purifier config as an array or pass a native config object.

The array style would look like this:

	Purifier::config('ConfigName', array(
		'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img',
		'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt'));

The plugin will construct a HTML Purifier config from that and instantiate the purifier.

A pure HTML Purifier config might look like this one:

	$config = HTMLPurifier_Config::createDefault();
	$config->set('HTML.AllowedElements', 'a, em, blockquote, p, strong, pre, code, span,ul,ol,li,img');
	$config->set('HTML.AllowedAttributes', 'a.href, a.title, img.src, img.alt');
	$config->set('HTML.AllowedAttributes', "*.style");
	$config->set('CSS.AllowedProperties', 'text-decoration');
	$config->set('HTML.TidyLevel', 'heavy');
	$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');

Simply assign it to a config:

	Purifier::config('ConfigName', $config);

Now that you have a configured instance of HTML Purifier ready you can use it directly and get you an instance of the purifier

	Purifier::config('ConfigName');

or clean some dirty HTML directly by calling

	Purifier::clean($markup, 'ConfigName');

For some automatization you can also use the Behavior or Helper.

### The Behavior

Set a config you want to use and the fields you want to sanitize.

	public $actsAs = array(
		'HtmlPurifier' => array(
			'config' => 'ConfigName',
			'fields' => array(
				'body', 'excerpt')));

### The Helper

In your controller load the helper and set a default config if you want.

	public $helpers = array(
		'HtmlPurifier' => array(
			'config' => 'ConfigName'));

In the views you can then use the helper like this:

	$this->HtmlPurifier->clean($markup, 'ConfigName');

## Support

For support and feature request, please visit the HtmlPurifier issue page

https://github.com/burzum/HtmlPurifier/issues

## License

Copyright 2012, Florian Krämer

Licensed under The MIT License
Redistributions of files must retain the above copyright notice.
