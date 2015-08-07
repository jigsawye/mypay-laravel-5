#Mypay for Laravel 5

##Using

```
$result = Mypay::orderId($orderId)
    ->items($items)
    ->user($user)
    ->send();
```