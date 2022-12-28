TimeZone Bundle
==================

Bundle para facilitar el trabajo con zonas horarias.

Instalación
----

Ejecutar 

    composer require "optimeconsulting/timezone-bundle" "@dev"

Luego de ello, registrar el bundle en el **config/bundles.php**:

```php

return [
    ...
    Optime\TimeZone\Bundle\OptimeTimeZoneBundle::class => ['all' => true],
];
```
