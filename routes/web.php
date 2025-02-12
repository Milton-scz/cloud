<?php

use App\Http\Controllers\AjusteInventarioController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CallBackAdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ConsultarAdminController;
use App\Http\Controllers\GenerarCobroController;
use App\Http\Controllers\NotaCompraController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductosLandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckAdmin;
use App\Mail\TestEmail;
use App\Models\PageView;
use App\Models\Producto;
use App\Models\Rating;
use App\Models\Role;
use App\Models\User;
use App\Models\Welcome;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\TextPart;

Route::get('/', WelcomeController::class)->name('/');
Route::get('/landing/productos/search', [WelcomeController::class, 'search'])->name('landing.productos.search');

Route::get('/landing/productos', [ProductosLandingController::class, 'index'])->name('landing.productos');

Route::get('/landing/misproductos', [ProductosLandingController::class, 'misproductos'])->name('landing.mis.productos');
Route::get('/landing/miproducto/details/{producto_id}', [ProductosLandingController::class, 'misproductosdetails'])->name('landing.miproducto.details');

Route::get('/landing/producto/details/{producto_id}', [ProductosLandingController::class, 'details'])->name('landing.producto.details');
Route::post('/pagos/callback', CallBackAdminController::class)->name('admin.pagos.callback');
// CONSULTAR PAGO
Route::get('/landing/pagos/create', [PagoController::class, 'create'])->name('landing.pagos.create');
Route::get('/landing/pagos/consultar', [ConsultarAdminController::class, '__invoke'])->name('landing.pagos.consultar');
Route::get('/admin/ratings', [RatingController::class, 'index'])->name('admin.ratings');
Route::post('/landing/ratings/register', [RatingController::class, 'storerating'])->name('landing.ratings.storerating');
Route::post('/landing/pagos/generarCobro', [GenerarCobroController::class, 'generarCobro'])->name('landing.pagos.generarCobro');
Route::get('/dashboard', function () {
    $user = null;
        if (Auth::check()) {
            $email = Auth::user()->email;
            $user = User::where('email', $email)->first();
        }
    if ($user && $user->hasPermissionTo('ver-dashboard')) {
        return Inertia::render('Dashboard', [
        ]);
    }
    return redirect()->route('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/send-report', [ReporteController::class, 'sendReport'])->name('send.report');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


      // GESTIONAR ROLES
      Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');
      Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
      Route::post('/admin/roles/register', [RoleController::class, 'store'])->name('admin.roles.store');
      Route::get('/admin/roles/edit/{role}', [RoleController::class, 'edit'])->name('admin.roles.edit');
      Route::post('/admin/roles/edit/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
      Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
      Route::post('admin/roles/{role}/assignPermissions', [RoleController::class, 'assignPermissions'])->name('admin.roles.assignPermissions');
      Route::post('adin/roles/{role}/remove-permissions', [RoleController::class, 'removePermissions'])->name('admin.roles.removePermissions');

      // GESTIONAR PERMISOS
      Route::get('/admin/permisos', [PermissionController::class, 'index'])->name('admin.permisos');
      Route::get('/admin/permisos/create', [PermissionController::class, 'create'])->name('admin.permisos.create');
      Route::post('/admin/permisos/register', [PermissionController::class, 'store'])->name('admin.permisos.store');
      Route::get('/admin/permisos/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.permisos.edit');
      Route::post('/admin/permisos/edit/{permission}', [PermissionController::class, 'update'])->name('admin.permisos.update');
      Route::delete('/admin/permisos/{permission}', [PermissionController::class, 'destroy'])->name('admin.permisos.destroy');


      // GESTIONAR USUARIOS
      Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
      Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
      Route::post('/admin/users/register', [UserController::class, 'store'])->name('admin.users.store');
      Route::get('/admin/users/edit/{user}', [UserController::class, 'edit'])->name('admin.users.edit');
      Route::post('/admin/users/edit/{user}', [UserController::class, 'update'])->name('admin.users.update');
      Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

       // GESTIONAR CATEGORIAS
       Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias');
       Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create');
       Route::post('/admin/categorias/register', [CategoriaController::class, 'store'])->name('admin.categorias.store');
       Route::get('/admin/categorias/edit/{categoria}', [CategoriaController::class, 'edit'])->name('admin.categorias.edit');
       Route::post('/admin/categorias/edit/{categoria}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
       Route::delete('/admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

        // GESTIONAR PRODUCTOS
        Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos');
        Route::get('/admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create');
        Route::post('/admin/productos/register', [ProductoController::class, 'store'])->name('admin.productos.store');
        Route::get('/admin/productos/edit/{producto}', [ProductoController::class, 'edit'])->name('admin.productos.edit');
        Route::post('/admin/productos/edit/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');
        Route::delete('/admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');



         // GESTIONAR  RATINGS

         Route::get('/admin/ratings/create', [RatingController::class, 'create'])->name('admin.ratings.create');
         Route::post('/admin/ratings/register', [RatingController::class, 'store'])->name('admin.ratings.store');
         Route::get('/admin/ratings/edit/{producto}', [RatingController::class, 'edit'])->name('admin.ratings.edit');
         Route::post('/admin/ratings/edit/{producto}', [RatingController::class, 'update'])->name('admin.ratings.update');
         Route::delete('/admin/ratings/{producto}', [RatingController::class, 'destroy'])->name('admin.ratings.destroy');


          //GESTIONAR VENTAS
         Route::get('/admin/ventas',[VentaController::class, 'index'])->name('admin.ventas');
         Route::get('/admin/ventas/catalogo',[VentaController::class, 'catalogo'])->name('admin.ventas.catalogo');
         Route::get('/admin/ventas/create',[VentaController::class, 'create'])->name('admin.ventas.create');
         Route::post('/admin/ventas/store',[VentaController::class, 'store'])->name('admin.ventas.store');
         Route::get('/admin/ventas/edit/{venta}',[VentaController::class, 'edit'])->name('admin.ventas.edit');
         Route::patch('/admin/ventas/update/{venta}', [VentaController::class, 'update'])->name('admin.ventas.update');
         Route::delete('admin/ventas/destroy/{venta}',  [VentaController::class, 'destroy'])->name('admin.ventas.destroy');

        //GESTIONAR PAGOS
         Route::get('/admin/pagos',[PagoController::class, 'index'])->name('admin.pagos');
         Route::get('/admin/pagos/create',[PagoController::class, 'create'])->name('admin.pagos.create');
         Route::post('/admin/pagos/store',[PagoController::class, 'store'])->name('admin.pagos.store');
         Route::get('/admin/pagos/edit/{pago}',[PagoController::class, 'edit'])->name('admin.pagos.edit');
        Route::patch('/admin/pagos/update/{pago}', [PagoController::class, 'update'])->name('admin.pagos.update');
         Route::delete('admin/pagos/destroy/{pago}',  [PagoController::class, 'destroy'])->name('admin.pagos.destroy');


        // GESTIONAR OFERTAS
        Route::get('/admin/ofertas', [OfertaController::class, 'index'])->name('admin.ofertas');
        Route::get('/admin/ofertas/create', [OfertaController::class, 'create'])->name('admin.ofertas.create');
        Route::post('/admin/ofertas/update/{producto_id}', [OfertaController::class, 'update'])->name('admin.ofertas.update');

        Route::delete('/admin/ofertas/{producto_id}', [OfertaController::class, 'destroy'])->name('admin.ofertas.destroy');


          //GESTIONAR PROVEEDORES
          Route::get('/admin/proveedores',[ProveedorController::class, 'index'])->name('admin.proveedores');
          Route::get('/admin/proveedores/create',[ProveedorController::class, 'create'])->name('admin.proveedores.create');
          Route::post('/admin/proveedores/store',[ProveedorController::class, 'store'])->name('admin.proveedores.store');
          Route::get('/admin/proveedores/edit/{proveedor}',[ProveedorController::class, 'edit'])->name('admin.proveedores.edit');
          Route::post('/admin/proveedores/update/{proveedor}', [ProveedorController::class, 'update'])->name('admin.proveedores.update');
          Route::delete('admin/proveedores/destroy/{proveedor}',  [ProveedorController::class, 'destroy'])->name('admin.proveedores.destroy');

           //GESTIONAR ALMACENES
           Route::get('/admin/almacenes',[AlmacenController::class, 'index'])->name('admin.almacenes');
           Route::get('/admin/almacenes/create',[AlmacenController::class, 'create'])->name('admin.almacenes.create');
           Route::post('/admin/almacenes/store',[AlmacenController::class, 'store'])->name('admin.almacenes.store');
           Route::get('/admin/almacenes/edit/{almacen}',[AlmacenController::class, 'edit'])->name('admin.almacenes.edit');
           Route::post('/admin/almacenes/update/{almacen}', [AlmacenController::class, 'update'])->name('admin.almacenes.update');
           Route::delete('admin/almacenes/destroy/{almacen}',  [AlmacenController::class, 'destroy'])->name('admin.almacenes.destroy');
           Route::get('/almacenes/verProductos/{almacen_id}', [AlmacenController::class, 'verProductos'])->name('admin.almacenes.productos');
           Route::get('/admin/almacenes/{almacen}/agregar-producto', [AlmacenController::class, 'agregarProducto'])->name('admin.almacenes.agregar-producto');
           Route::post('/admin/almacenes/agregarProductoAlmacen', [AlmacenController::class, 'agregarProductoAlmacen'])->name('admin.almacenes.agregarProductoAlmacen');




            //GESTIONAR NOTAS COMPRAS
            Route::get('/admin/notascompras',[NotaCompraController::class, 'index'])->name('admin.notascompras');
            Route::get('/admin/notascompras/create',[NotaCompraController::class, 'create'])->name('admin.notascompras.create');
            Route::post('/admin/notascompras/store',[NotaCompraController::class, 'store'])->name('admin.notascompras.store');
            Route::delete('/admin/notascompras/destroy/{notacompra}',  [NotaCompraController::class, 'destroy'])->name('admin.notascompras.destroy');
            Route::get('/admin/notascompras/{id}/productos', [NotaCompraController::class, 'getProductos']);




            //GESTIONAR AJUSTE INVENTARIO
            Route::get('/admin/ajustesinventarios',[AjusteInventarioController::class, 'index'])->name('admin.ajustesinventarios');
            Route::post('/admin/ajustesinventarios/agregar', [AjusteInventarioController::class, 'agregar'])->name('admin.ajustesinventarios.agregar');
            Route::delete('admin/ajustesinventarios/destroy/{ajusteinventario}',  [AjusteInventarioController::class, 'destroy'])->name('admin.ajustesinventarios.destroy');

          //GESTIONAR REPORTES Y ESTADISTICAS
          Route::get('/admin/reportes',[ReporteController::class, 'index'])->name('admin.reportes');

            //GESTIONAR VIEWS
            Route::get('/admin/views',[PageViewController::class, 'index'])->name('admin.views');


          // PAGOS WEB

          Route::post('/pagos/generarCobro', [GenerarCobroController::class, 'generarCobro'])->name('admin.pagos.generarCobro');
          Route::post('/pagos/callback', CallBackAdminController::class)->name('admin.pagos.callback');
          Route::get('/pagos/consultar/{venta_id}', ConsultarAdminController::class)->name('admin.pagos.consultar');

});


Route::post('/send-report', [ReporteController::class, 'sendReport']);

require __DIR__.'/auth.php';

