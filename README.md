# Documentacion rapida de notificacion

## Usar Resend para el envio de correos

- Se hace el siguiente comando para los drives de Resend `composer require resend/resend-php`
- Utilizando este recurso tuvo en cuenta para la configuracion de Resend [Laravel Resend config](https://laravel.com/docs/12.x/mail#resend-driver)
- Se añadio la API key de Resend al env *RESEND_API_KEY=* (Variable de entorno)
- Se configuro `MAIL_MAILER` para que el servicio por defecto fuera Resend. (Variable de entorno)

## ¿Como configurar los correos ?(Evelope function)
[Laravel wreiting mailables](https://laravel.com/docs/12.x/mail#writing-mailables)
- Podemos utilizar este archivo para crear calses de correos `php artisan make:mail SendQuote`
- Definimos en mail.php un ``from`` global. De este modo, no hay que especificar nada en la funcion ``envelope```y se va a utilizar el from por defecto del env.

## ¿Como se manda el cuerpo de un correo? (Content function)
- Al igual que las vistas, se debe de crear un tipo de layout. Este esta creada en `views/components/mail`.

## ¿Como se envia un correo?
- [Enviar un correo](https://laravel.com/docs/12.x/mail#sending-mail)

## Links interesantes
[Enviar un archivo sin escribirlo a disco, solo con los bytes](https://laravel.com/docs/12.x/mail#raw-data-attachments)
[Poner imagenes embebidas en el correo](https://laravel.com/docs/12.x/mail#inline-attachments)
[Queues](https://laravel.com/docs/12.x/queues)

## Congiraciones extra
- Se tuvo que configurar el archivo ``config/app.php`` para ajustar la zona horaria `'timezone' => 'America/Bogota',` 

## Cuanto es la disponibilidad de la API de Resend?
- Se puede consultar aqui: [Link](https://resend-status.com/)

# Documentacion rapida del OCR

## Definir el service provider
- Se creo el provider con php artisan make:provider OCRServiceProvider

## Configuracion
- Se debe de definir la API key en el env, en este caso de mistral: *MISTRAL_API_KEY*
- En *config/services.php* se añadio  

```php
'mistral'=> [
        'key'=> env('MISTRAL_API_KEY'),
]
```

- Se creo un nuevo servicio el cual tiene todos los metodos necesarios para ser invocados ene los controladores (Explicar detlladamente el servicio)
- Se añadio el provider de este nuevo servicio *OCRServiceProvider.php* (Explicar por encima el controller)
- Se añadio *App\Providers\OCRServiceProvider::class,* en el archivo *bootstrap/providers.php*
- Se creo un Form Request para validar que la request se genere por admin y se suba un pdf, png o jpg.

## Mistral documentation
[Como usar la API](https://docs.mistral.ai/getting-started/quickstart)