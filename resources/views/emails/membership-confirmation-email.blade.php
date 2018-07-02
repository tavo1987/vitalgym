<h2>Resumen de Membresía</h2>

Cliente: {{ $membership->customer->user->name }}
Membresía: {{ $membership->membershipType->name }}
Precio Unitario: {{ $membership->membershipType->price_in_dollars }}
Precio Total: {{ $membership->payment->total_price_in_dollars }}
Fecha Inicio: {{ $membership->date_start->format('d-m-Y') }}
Fecha de Caducidad: {{ $membership->date_end->format('d-m-Y') }}