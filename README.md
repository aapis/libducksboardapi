libducksboardapi
================

Ducksboard (http://ducksboard.com) has an API, but no PHP library.  Now it does.  This makes it a lot quicker to create dashboard widgets than manually running cURL queries in the terminal.

## Usage
**Push data to a widget**
```php
$ducksboard = new DucksboardAPI("push", array($data, $API->slot, $API->key));
$result = $ducksboard->runAction(true);
```

**Pull data from a widget**
```php
$ducksboard = new DucksboardAPI("pull", array($API->endpoint, $API->slot, $API->key));
$result = $ducksboard->runAction(true);
```

**Pull data from all, or a specific dashboard**
```php
$ducksboard = new DucksboardAPI("dashboard", array($API->request_type, $API->dashboard_slug, $API->key));
$result = $ducksboard->runAction(true);
```

## Run multiple requests in a row
```php
$ducksboard = new DucksboardAPI("dashboard", array($API->request_type, $API->dashboard_slug, $API->key));
$result = $ducksboard->runAction(true);

// ... some other code here ...

$newDataSet = array(...);
$ducksboard->runAction(true, $newDataSet);
```

So long as you want to run the same action multiple times (i.e. insert multiple items into a widget, create several dashboards, etc) you can just keep referencing the object which instantiates the type of request you want to run.

## "Copyright"
Obviously this is open source and also WTFPL licensed, but it was originally written for use in a project at http://wearefree.ca so I feel there should be at least be a link pointing people to where they can find the final product.
