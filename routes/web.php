<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\DispatchGuideController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DeliveryGuideController;
use App\Http\Controllers\GraphicCustomerController;
use App\Http\Controllers\SalesGuideController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\PettyCashController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login'); 
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/home', [HomeController::class, 'index'])->name('home');

//Rutas de categorías
Route::get('/categoria', [CategoryController::class, 'index'])
->middleware('auth')
->name('categoria.index');

Route::post('/categoria/create', [CategoryController::class, 'create'])
->middleware('auth')
->name('categoria.create');

Route::post('/categoria/edit/{id}', [CategoryController::class, 'edit'])
->middleware('auth')
->name('categoria.edit');

Route::post('/categoria/destroy/{id}', [CategoryController::class, 'destroy'])
->middleware('auth')
->name('categoria.destroy');


//Rutas de clientes
Route::get('/cliente', [CustomerController::class, 'index'])
->middleware('auth')
->name('cliente.index');

Route::post('/cliente/create', [CustomerController::class, 'create'])
->middleware('auth')
->name('cliente.create');

Route::post('/cliente/edit/{id}', [CustomerController::class, 'edit'])
->middleware('auth')
->name('cliente.edit');

Route::post('/cliente/destroy/{id}', [CustomerController::class, 'destroy'])
->middleware('auth')
->name('cliente.destroy');

//Rutas de marcas
Route::get('/marca', [BrandController::class, 'index'])
->middleware('auth')
->name('marca.index');

Route::post('/marca/create', [BrandController::class, 'create'])
->middleware('auth')
->name('marca.create');

Route::post('/marca/edit/{id}', [BrandController::class, 'edit'])
->middleware('auth')
->name('marca.edit');

Route::post('/marca/destroy/{id}', [BrandController::class, 'destroy'])
->middleware('auth')
->name('marca.destroy');

//Rutas de unidades
Route::get('/unidad', [UnitController::class, 'index'])
->middleware('auth')
->name('unidad.index');

Route::post('/unidad/create', [UnitController::class, 'create'])
->middleware('auth')
->name('unidad.create');

Route::post('/unidad/edit/{id}', [UnitController::class, 'edit'])
->middleware('auth')
->name('unidad.edit');

Route::post('/unidad/destroy/{id}', [UnitController::class, 'destroy'])
->middleware('auth')
->name('unidad.destroy');

//Rutas de bodegas
Route::get('/bodega', [StoreController::class, 'index'])
->middleware('auth')
->name('bodega.index');

Route::post('/bodega/create', [StoreController::class, 'create'])
->middleware('auth')
->name('bodega.create');

Route::post('/bodega/edit/{id}', [StoreController::class, 'edit'])
->middleware('auth')
->name('bodega.edit');

Route::post('/bodega/destroy/{id}', [StoreController::class, 'destroy'])
->middleware('auth')
->name('bodega.destroy');

//Rutas de productos
Route::get('/producto', [ProductController::class, 'index'])
->middleware('auth')
->name('producto.index');

Route::post('/producto/create/{origen}', [ProductController::class, 'create'])
->middleware('auth')
->name('producto.create');

Route::post('/producto/edit/{id}', [ProductController::class, 'edit'])
->middleware('auth')
->name('producto.edit');

Route::post('/producto/destroy/{id}', [ProductController::class, 'destroy'])
->middleware('auth')
->name('producto.destroy');

Route::get('/producto/pdf', [ProductController::class, 'pdf'])
->middleware('auth')
->name('producto.pdf');


//Rutas de formas de pagos
Route::get('/forma_pago', [PaymentFormController::class, 'index'])
->middleware('auth')
->name('forma_pago.index');

Route::post('/forma_pago/create', [PaymentFormController::class, 'create'])
->middleware('auth')
->name('forma_pago.create');

Route::post('/forma_pago/edit/{id}', [PaymentFormController::class, 'edit'])
->middleware('auth')
->name('forma_pago.edit');

Route::post('/forma_pago/destroy/{id}', [PaymentFormController::class, 'destroy'])
->middleware('auth')
->name('forma_pago.destroy');

//Rutas de facturas
Route::get('/factura', [DispatchGuideController::class, 'index'])
->middleware('auth')
->name('factura.index');

Route::get('/factura/create', [DispatchGuideController::class, 'create'])
->middleware('auth')
->name('factura.create');

Route::post('/factura/store', [DispatchGuideController::class, 'store'])
->middleware('auth')
->name('factura.store');

Route::post('/factura/destroy/{id}', [DispatchGuideController::class, 'destroy'])
->middleware('auth')
->name('factura.destroy');



//Rutas de inventario
Route::get('/inventario', [InventoryController::class, 'index'])
->middleware('auth')
->name('inventario.index');

Route::get('/inventario/pdf', [InventoryController::class, 'pdf'])
->middleware('auth')
->name('inventario.pdf');


//Rutas de cargas
Route::get('/carga', [DeliveryGuideController::class, 'index'])
->middleware('auth')
->name('carga.index');

Route::post('/carga/create', [DeliveryGuideController::class, 'create'])
->middleware('auth')
->name('carga.create');

Route::post('/carga/destroy/{id}', [DeliveryGuideController::class, 'destroy'])
->middleware('auth')
->name('carga.destroy');

//Ruta de gráfica clientes
Route::get('/grafica/cliente', [GraphicCustomerController::class, 'index'])
->middleware('auth')
->name('grafica.cliente.index');

//Rutas de ventas x mayor
Route::get('/venta', [SalesGuideController::class, 'index'])
->middleware('auth')
->name('venta_mayor.index');

Route::post('/venta/create', [SalesGuideController::class, 'create'])
->middleware('auth')
->name('venta_mayor.create');

Route::post('/venta/destroy/{id}', [SalesGuideController::class, 'destroy'])
->middleware('auth')
->name('venta_mayor.destroy');

//Rutas de ventas x menor
Route::get('/venta_menor', [SalesDetailController::class, 'index'])
->middleware('auth')
->name('venta_menor.index');

Route::post('/venta_menor/store', [SalesDetailController::class, 'store'])
->middleware('auth')
->name('venta_menor.store');

Route::post('/venta_menor/destroy/{id}', [SalesDetailController::class, 'destroy'])
->middleware('auth')
->name('venta_menor.destroy');

Route::post('/venta_menor/desglose', [SalesDetailController::class, 'desglose'])
->middleware('auth')
->name('venta_menor.desglose');

Route::post('/venta_menor/create', [SalesDetailController::class, 'create'])
->middleware('auth')
->name('venta_menor.create');

//Rutas de caja
Route::get('/caja', [PettyCashController::class, 'index'])
->middleware('auth')
->name('caja.index');

Route::get('/caja/modal', [PettyCashController::class, 'ajax'])
->middleware('auth')
->name('caja.ajax');

Route::post('/caja/update/{id}', [PettyCashController::class, 'update'])
->middleware('auth')
->name('caja.update');

Route::get('/caja/form/{id}', [PettyCashController::class, 'form'])
->middleware('auth')
->name('caja.form');

Route::get('/caja/pdf/{id}', [PettyCashController::class, 'pdf'])
->middleware('auth')
->name('caja.pdf');

Route::post('/caja/create', [PettyCashController::class, 'create'])
->middleware('auth')
->name('caja.create');