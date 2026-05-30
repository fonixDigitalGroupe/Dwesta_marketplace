<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$orders = \App\Models\Order::latest('id')->limit(5)->select('id', 'statut', 'destination_point_relais_id', 'total_final')->get();
$pr = \App\Models\PointRelais::select('id', 'nom')->get();
echo json_encode(['orders' => $orders, 'pr' => $pr]);
