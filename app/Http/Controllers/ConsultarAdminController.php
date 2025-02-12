<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\Pago;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
use App\Models\Venta;
use Illuminate\Support\Facades\Log;

class ConsultarAdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Log::debug($request);
        $venta_id = $request->input('venta_id');
        $ventaEnCurso = Venta::findOrFail($venta_id);

        $idUltimaVenta = $venta_id; //$ultimaVenta->id;
        $loClientEstado = new Client();
        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";
        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $idUltimaVenta
        ];
        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);

        // Decode the JSON response
        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());
        if ($laResultEstadoTransaccion && isset($laResultEstadoTransaccion->values->messageEstado)) {
            $cadenaCompleta = $laResultEstadoTransaccion->values->messageEstado;
            $elementos = explode(' - ', $cadenaCompleta);
            if (count($elementos) >= 2) {
                $textoExtraido = $elementos[0] . '-' . $elementos[1];
                // Verificar si el estado de la venta es "COMPLETADO-PROCESADO"
                if ($textoExtraido == "COMPLETADO-PROCESADO") {
                    // Obtener la venta que está en curso
                    $venta = $ventaEnCurso;
                    $venta->estado = 2;  // Estado completado
                    $venta->update();  // Actualizar la venta con el nuevo estado

                    // Obtener el pago asociado a la venta
                    $pago = Pago::findOrFail($venta->pago_id);
                    $pago->estado = 2;  // Estado completado
                    $pago->update();  // Actualizar el pago con el nuevo estado

                    // Obtener todos los productos en detalle_venta de esta venta
                    $detalleVenta = DetalleVenta::where('venta_id', $venta->id)->get();

                    foreach ($detalleVenta as $detalle) {
                        $producto = Producto::findOrFail($detalle->producto_id);

                        // Obtener los registros de producto_almacen donde hay stock disponible
                        $productoAlmacen = ProductoAlmacen::where('producto_id', $producto->id)->get();

                        $cantidadRestar = $detalle->cantidad;
                        foreach ($productoAlmacen as $almacenProducto) {
                            if ($cantidadRestar <= 0) break;  // Si ya hemos restado toda la cantidad necesaria, salimos

                            // Si el almacén tiene suficiente stock para restar
                            if ($almacenProducto->stock > 0) {
                                $restar = min($cantidadRestar, $almacenProducto->stock);
                                $almacenProducto->stock -= $restar;
                                $cantidadRestar -= $restar;

                                // Guardamos el cambio
                                $almacenProducto->save();
                            }
                        }

                        // Si después de recorrer todos los almacenes, aún falta cantidad por restar
                        if ($cantidadRestar > 0) {
                            Log::error("No hay suficiente stock para el producto: {$producto->id} después de intentar distribuir entre almacenes.");
                            throw new \Exception("No hay suficiente stock para el producto: {$producto->id}");
                        }
                    }
                }




                return $textoExtraido;
            } else {
                return "Error";
            }
        }
        return "ENTROOO";
    }
    //  }
    //}

}
