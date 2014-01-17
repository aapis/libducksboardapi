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