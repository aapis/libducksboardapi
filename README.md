libducksboardapi
================

Ducksboard (http://ducksboard.com) has an API, but no PHP library.  Now it does.

## Usage
**Push data to a widget**
```
$ducksboard = new DucksboardAPIPush($data2, $API->slot, $API->key);
$result = $ducksboard->send();
```

**Pull data from a dashboard**
```
$ducksboard = new DucksboardAPIPull($data2, $API->slot, $API->key);
$result = $ducksboard->send();
```