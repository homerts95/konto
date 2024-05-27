<?php

namespace App\Http\Controllers;

use Darryldecode\Cart\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

// use App\Models\Cart;

class CartController extends Controller
{

    public function __construct()
    {
        $cartItems = \Cart::getContent();

        if (Auth::check()) {
            \Cart::session(Auth::user()->id);
            foreach ($cartItems as $row) {
                dd($row);
                \Cart::add($row);
            }
        }
    }

    public function index(): Response
    {
        return Inertia::render('Cart/Cart');
    }

    public function add(): RedirectResponse
    {
        $product = request()->product;

        \Cart::add(
            array(
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => request()->quantity,
                'attributes' => [
                    'image' => $product['thumbnail_url'],
                    'price_with_currency' => $product['price_with_currency']
                ],
                'associatedModel' => $product
            )
        );
        return redirect()->back()->with('success', 'Product is Added to Cart Successfully !');
    }

    public function update(Request $request): RedirectResponse
    {

        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        return redirect()->back();
    }

    public function remove(Request $request): RedirectResponse
    {
        \Cart::remove($request->id);
        return redirect()->back();
    }
}
