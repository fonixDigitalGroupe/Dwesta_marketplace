<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\VendeurAbonnement;
use App\Models\Abonnement;
use App\Models\Vendeur;
use App\Services\LogisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Webhook;
use Carbon\Carbon;

class StripeWebhookController extends Controller
{
    protected $fulfillment;

    public function __construct(\App\Services\StripeFulfillmentService $fulfillment)
    {
        $this->fulfillment = $fulfillment;
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutCompleted($session);
                break;
            
            case 'invoice.paid':
                $invoice = $event->data->object;
                $this->handleInvoicePaid($invoice);
                break;

            default:
                Log::info('Unhandled Stripe event: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutCompleted($session)
    {
        // Toute la logique idempotente est centralisée dans le service partagé
        // (également utilisé en filet de sécurité sur les pages de succès).
        $this->fulfillment->fulfill($session);
    }

    protected function handleInvoicePaid($invoice)
    {
        // Utile pour les renouvellements automatiques
        // Logique similaire à handleCheckoutCompleted pour prolonger l'abonnement
    }
}
