<x-mail::message>
# Pago Realizado

Se ha confirmado el pago correctamente, por el monto de Gs. {{number_format($amount,0,',','.')}}
en concepto de: {{$description}}

Muchas gracias,<br>
{{ config('app.name') }}
</x-mail::message>
