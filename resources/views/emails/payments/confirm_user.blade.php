<x-mail::message>
# Recibiste un pago.

Hola {{$userName}}, recibiste un pago de Gs. {{$amount}} realizado por {{$clientName}} en concepto de:
<x-mail::table>
| Rifa       | Cantidad         | Monto  |
| ------------- |:-------------:| --------:|
@foreach($details as $item)
| {{$item->raffle->description}}|{{$item->quantity}}| {{$item->amount}} |
@endforeach
</x-mail::table>

Desde ya que tenga un buen resto de jornada,<br>
{{ config('app.name') }}
</x-mail::message>
