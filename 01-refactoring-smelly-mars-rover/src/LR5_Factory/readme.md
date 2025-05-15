Використання фабрики
```aiignore
try {
    $message = MessageFactory::create($type);
    $message->send();
} catch (InvalidArgumentException $e) {
    echo "Помилка: " . $e->getMessage() . "\n";
}
```
