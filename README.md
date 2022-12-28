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

<hr/>

Uso
===

Las entidades que necesiten trabajar sus fechas con un timezone deben implementar la interfaz:

`Optime\TimeZone\Bundle\TimeZoneAwareInterface`

Dicha interfaz tiene un método `getTimeZone(): ?TimeZone` que retorna la zona horaria establecida para dicha entidad o null.

Formularios
----

A los campos de tipo DatetimeType, se les pueden pasar varias opciones para facilitar el trabajo con el timzone:

 * timezone: Indica cual zona horaria usar, puede ser `null`, `Optime\TimeZone\Bundle\Entity\TimeZone` o `Optime\TimeZone\Bundle\TimeZoneAwareInterface`
 * timezone_help: es un boolean, por defecto en false, que indica si se debe pintar la zona horaria que está usando el campo.
