libducksboardapi
================

Ducksboard (http://ducksboard.com) has an API, but no PHP library.  Now it does.

## Usage
**Push data to a widget**
```php
$ducksboard = new DucksboardAPIPush($data, $API->slot, $API->key);
$result = $ducksboard->runAction(true);
```

**Pull data from a widget**
```php
$ducksboard = new DucksboardAPIPull($API->endpoint, $API->slot, $API->key);
$result = $ducksboard->runAction(true);
```

**Pull data from all, or a specific dashboard**
```php
$ducksboard = new DucksboardAPIDashboard($API->request_type, $API->dashboard_slug, $API->key);
$result = $ducksboard->runAction(true);
```

## Run multiple requests in a row
```php
$ducksboard = new DucksboardAPIDashboard($API->request_type, $API->dashboard_slug, $API->key);
$result = $ducksboard->runAction(true);

// ... some other code here ...

$newDataSet = array(...);
$ducksboard->runAction(true, $newDataSet);
```

So long as you want to run the same action multiple times (i.e. insert multiple items into a widget, create several dashboards, etc) you can just keep referencing the object which instantiates the type of request you want to run.