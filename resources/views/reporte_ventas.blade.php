<h1>Reporte de Ventas por Mes</h1>
<ul>
    @foreach ($ventasPorMes as $index => $monto)
        <li>{{ $loop->index + 1 }}: {{ $monto }} </li>
    @endforeach
</ul>
