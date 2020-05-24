<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Addresse;
use App\Order;
use App\Mail\OrderConfirmed;

class OrderController extends Controller
{
    protected $order;
    protected $stripeCharge;
    protected $stripeError;

    public function __construct()
    {
        $this->middleware('auth');

        $this->order = [
                'shippingCost' => null,
                'shippingType' => null,
                'shippingAddresse' => null,
                'taxes'  => null,
                'addresse_id' => null,
            ];

        $this->stripeCharge = null;
        $this->stripeError = '';
    }

   // let user choose means of shipping and addresse to ship to
    public function shipping()
    {
        if(\Cart::getCondition('colissimo')) {
            return view('order.shipping');
        }
        else {
            return redirect()->route('order.checkout', ['id' => 1]);
        }
    }

    // todo : rename to checkAddresse or remove and manage it in checkout
    // tbd
    public function storeAddresse(Request $request) {
        $addresseChoice = $request->addresseChoice;
        $addresse = Auth::user()->addresses->find($addresseChoice);

        if($addresse !== null) {
            return redirect()->route('order.checkout', ['id' => $addresseChoice]);
        }
        else {
            return redirect()->route('order.shipping');
        }
    }

    // final overview and payment
    public function checkout($id = 1)
    {
        $id = (int) $id;
        $addresse = Auth::user()->addresses->find($id);
        $tva = \Cart::getCondition('tva')->getValue();

        if($id === 1) {
            $shop = Addresse::find(1);

            $this->setOrder(
            0,
            'Retrait en magasin',
            $shop,
            $tva,
            $id
            );
        }
        else if($addresse) {
            $this->setOrder(
            \Cart::getCondition('colissimo')->getValue(),
            \Cart::getCondition('colissimo')->getName(),
            $addresse,
            $tva,
            $id
            );
        }
        else {
            return redirect()->route('cart.index');
        }

        return view('order.checkout', ['order' => $this->order]);
    }

    // order confirmation and transaction overview
    public function confirmation(Request $request)
    {
        $addresse_id = (int) $request->addresse_id;

        if(Auth::user()->addresses->find($addresse_id)
            || ($addresse_id === 1 && session('shippingChoice') === 'store')) {

            try{
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                $customer = Customer::create([
                    'email' => Auth::user()->email,
                    'source' => $request->stripeToken
                ]);
                $charge = Charge::create([
                    'customer' => $customer->id,
                    'amount' => round(\Cart::getTotal() * 100,0),
                    'currency' => 'EUR'
                ]);

                $this->setStripeCharge($charge);
            }
            catch (\Exception $e) {
                $this->setStripeError($e->getMessage());
            }

            // if payment went well
            if($this->getStripeError() === '') {

                // store order in DB
                $this->storeOrder($this->getStripeCharge(), $addresse_id);

                // Log payment in storage/logs/payments_success.log
                $this->logger('success');

                // empty the cart
                \Cart::clear();

                // return to main index with a success flash message
                $message = [
                'p1' => 'Merci de votre commande '.Auth::user()->name.' '.Auth::user()->lastname.'!',
                'p2' => 'Un mail de confirmation vous a été envoyé'
                ];
                return redirect()->route('main.index')->with('flashSuccess', $message);

                // if payment failed
            } else {

                // Log failed payment in storage/logs/payments_error.log
                $this->logger('error');

                // return to checkout with a error flash message
                // translations in resources/lang/fr.json
                $message = [
                'p1' => 'Une erreur c\'est produite lors du payment : '.__($this->getStripeError()),

                'p2' => 'Veuillez re-essayer svp'
                ];

                return redirect()->route('order.checkout', ['id' => $addresse_id])->with('flashError', $message);
            }

        } else {
            $message = [
                'p1' => 'Le paiement n\'a pas été effectué.',
                'p2' => 'Veuillez choisir une adresse valide s\'il vous plait',
                ];

                return redirect()->route('order.shipping')->with('flashError', $message);
        }

    }

    protected function storeOrder($charge, $addresse_id) {

            $order = new Order();
            $order->user_id = Auth::id();
            $order->billing_addresse_id = $addresse_id;
            $order->shipping_addresse_id = $addresse_id;
            $order->shipping_type = session('shippingChoice' , 'colissimo');
            $order->taxes = \Cart::getTotal()-\Cart::getSubTotal();
            $order->total_ht = \Cart::getSubTotal();
            $order->total_ttc = \Cart::getTotal();
            $order->status = 1;
            $order->payment_id = $charge->id;

            $order->save();

            $cartContent = \Cart::getContent();

            foreach ($cartContent as $item) {

                $productId = $item->associatedModel->id;
                $order->products()->attach($productId, ['quantity' => $item->quantity, 'current_price' => $item->price]);

            }

            // todo: fix - $order->user() sould not return an array of 1 value
            \Mail::to($order->user()->first())->send(new OrderConfirmed($order));
    }

    // payment logger
    protected function logger(string $event) {
        $charge = $this->getStripeCharge();
        $error = $this->getStripeError();

        switch ($event) {
            case ('success'):
            Log::channel('paymentSuccess')->info(
                'user_id : '.Auth::id().' - '
                .$charge->amount.' '.$charge->currency.
                ' - id trans : '.$charge->id
            );
            break;
            case ('error'):
            Log::channel('paymentError')->warning(
                'user_id : '.Auth::id().' - '
                .\Cart::getTotal().
                ' - message : '.$error
            );
            break;
        }

    }

    public function setOrder($shippingCost=null, $shippingType=null, $shippingAddresse=null, $taxes=null, $addresse_id = null) {
        // maybe not super useful
        $this->order['shippingCost'] = $shippingCost;
        $this->order['shippingType'] =  $shippingType;
        $this->order['shippingAddresse'] = $shippingAddresse;
        $this->order['taxes']  = $taxes;
        $this->order['addresse_id'] = $addresse_id;
    }

    public function setStripeCharge($charge=null) {
        $this->stripeCharge = $charge;
    }

    public function setStripeError($error = '') {
        $this->stripeError = $error;
    }

    public function getStripeCharge() {
        return $this->stripeCharge;
    }

    public function getStripeError() {
        return $this->stripeError;
    }
}
