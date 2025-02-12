<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class ReporteDeVentas extends Mailable
{
    use Queueable;

    public $ventasPorMes;

    public function __construct($ventasPorMes)
    {
        $this->ventasPorMes = $ventasPorMes;
    }

    public function build()
    {
        return $this->view('reporte_ventas')
                    ->with(['ventasPorMes' => $this->ventasPorMes])
                    ->subject('Reporte de Ventas por Mes');
    }
}
