<h2>Resumen de Membresía</h2>

Cliente: {{ $membership->customer->user->name }} <br>
Membresía: {{ $membership->plan->name }} <br>
Precio Unitario: {{ $membership->plan->price_in_dollars }} <br>
Precio Total: {{ $membership->payment->total_price_in_dollars }} <br>
Fecha Inicio: {{ $membership->date_start->format('d-m-Y') }} <br>
Fecha de Caducidad: {{ $membership->date_end->format('d-m-Y') }}