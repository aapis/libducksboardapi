libducksboardapi
================

Ducksboard (http://ducksboard.com) has an API, but no PHP library.  Now it does.

## Usage
**Push data to a widget**
```php
$ducksboard = new DucksboardAPIPush($data, $API->slot, $API->key);
$result = $ducksboard->push();
```

**Pull data from a dashboard**
```php
$ducksboard = new DucksboardAPIPull($API->endpoint, $API->slot, $API->key);
$result = $ducksboard->pull();
```