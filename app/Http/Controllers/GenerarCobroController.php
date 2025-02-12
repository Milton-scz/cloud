<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Venta;
use App\Models\Pago;
use App\Models\DetalleVenta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GenerarCobroController extends Controller
{



    // GENERAR COBRO
    public function generarCobro(Request $request)
    {
       // dd($request);
        do {
            $nroPago = rand(100000, 999999);
            $existe = Pago::where('id', $nroPago)->exists();
        } while ($existe);

        try {
            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";  // credencia dado por pagofacil
            $lnMoneda              = 1;
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = $nroPago; // Genera un número aleatorio entre 100,000 y 999,999   sirve para callback , pedidoID
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = route('admin.pagos.callback'); //"https://mail.tecnoweb.org.bo/inf513/grupo03sa/ultimo/public/cursos/pagos/callback";
            $lcUrlReturn           = "";
            $laPedidoDetalle       =  $request->taPedidoDetalle;
            $lcUrl                 = "";

            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,

            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            $laResult = json_decode($loResponse->getBody()->getContents());

            if ($request->tnTipoServicio == 1) {

                $csrfToken = csrf_token();
                $laValues = explode(";", $laResult->values)[1];
                $nroTransaccion = explode(";", $laResult->values)[0];

                // Buscar usuario por correo
                $user = User::where('email', $request->tcCorreo)->first();

                if (!$user) {
                    // Si no existe el usuario, crearlo
                    $user = User::create([
                        'name' => $request->name,
                        'cedula' => $request->cedula,
                        'celular' => $request->tnTelefono,
                        'email' => $request->tcCorreo,
                        'password' => "null",
                    ]);
                    // Asignar rol
                    $user->roles()->attach(1);
                }




                Pago::create([
                    'id' =>  $nroPago,
                    'fechapago' => now(),
                    'estado' => 1,
                    'metodopago' => 4,   // 4 es Qr
                ]);
                $user_id = Auth::user()->id;

                Venta::create([
                    'id' => $nroTransaccion,
                    'user_id' => $user_id,
                    'pago_id' => $lcNroPago,
                    'fecha' => now(),
                    'metodopago' => 4,  // 4 = Qr , 2 = tigo Money
                    'montototal' => $request->tnMonto,
                    'estado' => 1, // 1 = pendiente , 2 = pago exitos0 , 3 = revertido , 4 = anulado
                ]);




                foreach ($laPedidoDetalle as $detalle) {
                    // dd( $detalle );
                    DetalleVenta::create([
                        'venta_id' => $nroTransaccion,    // Tiene el ID del pedido por tigo money
                        'producto_id' =>  $detalle['id'],  // Tiene el ID del producto, en este caso, el curso
                        'cantidad' => $detalle['cantidad'],
                        'total' =>  $detalle['total'],
                    ]);
                }

                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;

                return response()->json([
                    'qrImage' => $laQrImage,
                    'nroTransaccion' =>  $nroTransaccion,
                ]);
            } elseif ($request->tnTipoServicio == 2) {
                $venta = Venta::create([
                    'id' => $laResult->values,
                    'user_id' => Auth::user()->id,
                    'fecha' => now(),
                    'metodopago' => 2,  // 1 = Qr , 2 = tigo Money
                    'montototal' => $request->tnMonto,
                    'estado' => 1, // 1 = pendiente , 2 = pago exitos0 , 3 = revertido , 4 = anulado
                ]);
                foreach ($laPedidoDetalle as $detalle) {
                    $detalleVenta = DetalleVenta::create([
                        'venta_id' =>  $laResult->values,   // tiene el id del pedido por tigo money
                        'producto_id' => $detalle['id'],   // Tiene el ID del producto
                        'cantidad' => $detalle['Cantidad'],
                        'total' =>  $detalle['Total'],
                    ]);

                }
            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }
}
