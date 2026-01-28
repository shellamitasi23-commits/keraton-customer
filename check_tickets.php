<?php
// Load Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
  $request = Illuminate\Http\Request::capture()
);

// Check tickets
$tickets = \App\Models\TicketCategory::all();
echo "Total Tiket: " . count($tickets) . "\n";
foreach ($tickets as $ticket) {
  echo "- " . $ticket->name . " (Rp " . number_format($ticket->price) . ")\n";
}
?>