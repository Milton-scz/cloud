<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Reporte;
use App\Models\Venta;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Mail\ReporteDeVentas;
use App\Traits\UserPermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ReporteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Contar el número total de productos
        $totalProductos = Producto::count();

        // Sumar el monto total de ventas
        $ventasTotales = Venta::sum('montototal');

        // Obtener las ventas agrupadas por mes y sumar el monto total por mes
        $ventasPorMes = Venta::selectRaw("EXTRACT(MONTH FROM CAST(fecha AS DATETIME)) as mes, SUM(montototal) as monto_total")
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();


        // Obtener los productos que han sido vendidos al menos una vez
       // Obtener los productos vendidos y su cantidad (la cantidad vendida por cada producto)
       $productosVendidos = Producto::select('productos.nombre', DB::raw('sum(detalle_ventas.cantidad) as cantidad'))
       ->join('detalle_ventas', 'productos.id', '=', 'detalle_ventas.producto_id')
       ->groupBy('productos.id', 'productos.nombre')
       ->get();

//dd( $productosVendidos);
        // Devolver la vista con los datos
        return Inertia::render('GestionarReportesEstadisticas/Reportes/index', [
            'totalProductos' => $totalProductos,
            'ventasTotales' => $ventasTotales,
            'ventasPorMes' => $ventasPorMes,  // Pasamos las ventas por mes
            'productosVendidos' => $productosVendidos, // Pasamos los productos vendidos

        ]);
    }



    public function sendReport(Request $request)
    {
        // Validar las entradas
        $request->validate([
            'destinatario' => 'required|email',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        $mail = new PHPMailer(true);

        $destinatario = $request->input('destinatario');
        $asunto = $request->input('asunto');
        $mensaje = $request->input('mensaje');

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
            $mail->SMTPAuth = true;   // Activar autenticación SMTP
            $mail->Username = 'AKIA4MTWJNPECI7XEHOR';  // Tu nombre de usuario SMTP
            $mail->Password = 'BAXl1eeMzdd1iqNXD5ngoa+5frczFC9HhCeCdJuCxT+2';              // Tu contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Usar TLS para una conexión segura
            $mail->Port = 587;  // Puerto para conexiones seguras (587 recomendado)

            // Datos del remitente
            $mail->setFrom('kevin@pijamas-cloud.online', 'grupo01sa');

            // Destinatarios
            $mail->addAddress($destinatario);

            // Contenido del correo
            $mail->isHTML(true);  // Correo en formato HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;
            $mail->AltBody = strip_tags($mensaje);  // Texto plano como alternativa para clientes que no soportan HTML

            // Enviar el correo
            if ($mail->send()) {
                return redirect()->route('admin.reportes');
               // return response()->json(['message' => 'El correo ha sido enviado correctamente.']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $mail->ErrorInfo], 500);
        }
    }




}
