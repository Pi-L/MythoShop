<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

// todo test if session still up
class CartController extends Controller
{
    protected $shippingCondition;
    protected $taxCondition;

    public function __construct()
    {
        $this->shippingCondition = new \Darryldecode\Cart\CartCondition(
        [
            'name' => 'colissimo',
            'type' => 'shipping',
            'target' => 'subtotal',
            'value' => '10',
        ]);

        $this->taxCondition = new \Darryldecode\Cart\CartCondition(
        [
            'name' => 'tva',
            'type' => 'tax',
            'target' => 'total',
            'value' => '20%',
        ]);
    }

    public function index(){
        //  \Cart::clear();
        //  \Cart::clearCartConditions();

        switch( session('shippingChoice' , 'colissimo') ){
            case ('store'):
            $shippingCost = 0;
            \Cart::removeCartCondition('colissimo');
            break;
            default:
            $shippingCost = $this->shippingCondition->getValue();
            \Cart::condition($this->shippingCondition);
            break;
        }

        \Cart::condition($this->taxCondition);

        return view('cart.index',
            [
            'shippingCost' => $shippingCost,
            'shippingChoice' => session('shippingChoice' , 'colissimo')
            ]);
    }
    // todo add an optionnal flash message array parametre to this methode
    public function redirect() {
        $prevUrl = url()->previous();

        if(!empty($prevUrl) && strpos($prevUrl, 'cart') !== false) {
            return redirect()->route('cart.index');
        }
        else if(!empty($prevUrl)) {
            return redirect()->back();
        }
        else {
            return redirect()->route('main.index');
        }
    }

    public function add($id=null){

        if ($id===null)
            return redirect()->back();

        $product = Product::find($id);

        if(!$product)
            return redirect()->back();

        if(\Cart::get($id))
            return redirect()->back()->with('flashError',[
                    'p1' => 'Cette créature est déjà dans le panier',
                    'p2' => 'Pour modifier la quantité, allez au panier ou dans sa fiche créature'
                    ]);

        \Cart::add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $product,
        ));

        return redirect()->back()->with('flashSuccess',[
                    'p1' => 'Créature bien ajouté au panier',
                    ]);
    }

    public function remove($id=null){
        if ($id!==null && \Cart::has($id)) {

            \Cart::remove($id);
            return redirect()->back()->with('flashSuccess',[
                    'p1' => 'Créature supprimée',
                    ]);
        }

        return $this->redirect();
    }

    public function updateShippingChoice(Request $request) {

        $shippingChoice = $request->shipping__choice;

        if($shippingChoice === 'store') {
            session(['shippingChoice' => 'store']);
        }
        else {
            session(['shippingChoice' => 'colissimo']);
        }

        return $this->redirect();
    }

    public function updateRelative(Request $request) {
        $productId = $request->productId;
        $quantity = (int) $request->quantity;
        $product = Product::find($productId);

        if(!$product || $quantity === 0) {
            return $this->redirect();
        }

        if($product->quantity <= 0) {
            $request->session()->flash('flashError', [
                'p1' => 'Nous n\'avons plus de stock pour cette créature',
            ]);
            return $this->redirect();
        }

        if($this->isRemovable($product, $quantity)) {
            $this->removeNoRedirect($product->id);
            $request->session()->flash('flashSuccess', [
                    'p1' => 'Créature supprimée'
                    ]);
            return $this->redirect();
        }

        if($this->isAboveMaxRelative($product, $quantity)) {
            $request->session()->flash('flashError', [
                'p1' => 'La quantité demandée est superieure à nos stock.',
            ]);
            return $this->redirect();
        }

        if(!\Cart::has($product->id)) {
            $this->addMany($product, $quantity);
            $request->session()->flash('flashSuccess', [
                    'p1' => 'Créature bien ajouté au panier',
                    ]);
            return $this->redirect();
        }

        \Cart::update($product->id,[
                    'quantity' => ['relative'=> true, 'value' => $quantity],
                ]);

        $request->session()->flash('flashSuccess', [
                    'p1' => 'Quantité mise à jour',
                    ]);

        return $this->redirect();
    }

    public function update(Request $request) {
        $productId = $request->productId;
        $quantity = (int) $request->quantity;
        $product = Product::find($productId);

        if(!$product || !\Cart::has($productId)) {
            return $this->redirect();
        }

        if($quantity <= 0) {
            $this->removeNoRedirect($productId);
            $request->session()->flash('flashSuccess', [
                    'p1' => 'Créature supprimée'
                    ]);
            return $this->redirect();
        }

        if($this->isAboveMax($product, $quantity)) {
            $request->session()->flash('flashError', [
                'p1' => 'La quantité demandée est superieure à nos stock.',
            ]);
            return $this->redirect();
        }

        \Cart::update($product->id,[
                    'quantity' => ['relative'=> false, 'value' => $quantity],
                ]);

        $request->session()->flash('flashSuccess', [
                    'p1' => 'Quantité mise à jour'
                    ]);

        return $this->redirect();
    }

    public function removeNoRedirect($id=null):void{
        if ($id!==null && \Cart::has($id))
            \Cart::remove($id);
    }

    public function isAboveMaxRelative(Product $product, $quantity) {
        $quantity = (int) $quantity;
        $currentCartQuantity = ( \Cart::has($product->id) ? \Cart::get($product->id)->quantity : 0 );

        $quantityMax = $product->quantity - $currentCartQuantity;

        if($quantity > $quantityMax)
            return true;

        return false;
    }

    public function isAboveMax(Product $product, $quantity) {

        if((int) $quantity > (int) $product->quantity)
            return true;

        return false;
    }

    public function isRemovable(Product $product, $quantity) {
        $quantity = (int) $quantity;
        $currentCartQuantity = ( \Cart::has($product->id) ? \Cart::get($product->id)->quantity : 0 );

        if(($currentCartQuantity > 0) && ($quantity < 0) && ($currentCartQuantity + $quantity) <= 0)
            return true;

        return false;
    }

    public function addMany(Product $product, $quantity):void {

        if(!\Cart::has($product->id)) {

            \Cart::add(array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'attributes' => array(),
                    'associatedModel' => $product,
                ));
        }
    }

}
