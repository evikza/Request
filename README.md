# Request
A dead simple PHP class for cURL request

```php
$r = new Request();

$r->withMethod('GET');
$r->withHeaders([
  'Content-Type' => 'application/json',
  'X-Requested-With' => 'XMLHttpRequest',
]);
$r->execute();

if ($r->getHttpCode() === 200) {
  echo $r->getBody();
}
```
