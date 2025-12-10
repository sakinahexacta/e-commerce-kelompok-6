<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Buyer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function index(Request $request, Product $product)
    {
        $qty = $request->qty ?? 1;

        $address = session('checkout.address');
        $address_id = session('checkout.address_id');
        $city = session('checkout.city');
        $postal_code = session('checkout.postal_code');
        $shipping = session('checkout.shipping');
        $payment = session('checkout.payment');
        $shippingCost = 5000;

        return view('pengguna.cekout', [
            'product' => $product,
            'qty' => $qty,
            'total' => $product->price * $qty,
            'address' => $address,
            'address_id' => $address_id,
            'city' => $city,
            'postal_code' => $postal_code,
            'shipping' => $shipping,
            'payment' => $payment,
            'shippingCost' => $shippingCost,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $user = Auth::user();
        $request->validate([
            'qty' => 'required|integer|min:1',
            'address' => 'required|string',
            'address_id' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'tax' => 'required|numeric',
            'grand_total' => 'required|numeric',
        ]);


        $buyer = Buyer::firstOrCreate(['user_id' => $user->id]);

        $product = Product::findOrFail($product->id);

        $transaction = Transaction::create([
            'buyer_id' => $buyer->id,
            'store_id' => 1,
            'code' => 'TRX-' . strtoupper(uniqid()),
            'address' => $request->address,
            'address_id' => $request->address_id,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'shipping' => 0,
            'shipping_type' => $request->shipping_type,
            'shipping_cost' => $request->shipping_cost,
            'tax' => $request->tax,
            'grand_total' => $request->grand_total,
            'payment_status' => 'pending',
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => $request->qty,
            'sub_total' => $product->price * $request->qty,
        ]);

        return redirect()->route('pengguna.cekout.show', $transaction->id);
    }

    public function show(Transaction $transaction)
    {
        $transaction = Transaction::with('transactionDetails.product')->findOrFail($transaction->id);
        return view('pengguna.cekout', compact('transaction'));
    }

    public function address(Product $product)
    {
        return view('pengguna.alamat', compact('product'));
    }


    public function storeAddress(Request $request, Product $product)
    {
        $request->validate([
            'address' => 'required',
            'address_id' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        session([
            'checkout.address' => $request->address,
            'checkout.address_id' => $request->address_id,
            'checkout.city' => $request->city,
            'checkout.postal_code' => $request->postal_code,
        ]);

        return redirect()->route('pengguna.cekout', $product->id);
    }

    public function shipping(Product $product)
    {
        return view('pengguna.pengiriman', compact('product'));
    }

    public function storeShipping(Request $request, Product $product)
    {
        $request->validate([
            'shipping' => 'required',
        ]);

        session([
            'checkout.shipping' => $request->shipping
        ]);

        return redirect()->route('pengguna.cekout', $product->id);
    }

    public function payment(Product $product)
    {
        return view('pengguna.metodepembayaran', compact('product'));
    }

    public function storePayment(Request $request, Product $product)
    {
        $request->validate([
            'payment' => 'required',
        ]);

        session([
            'checkout.payment' => $request->payment
        ]);

        return redirect()->route('pengguna.cekout', $product->id);
    }
}
