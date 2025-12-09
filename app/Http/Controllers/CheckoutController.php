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

        return view('pengguna.cekout', [
            'product' => $product,
            'qty' => $qty,
            'total' => $product->price * $qty,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'address' => 'required|string',
        ]);

        $user = Auth::user();

        $buyer = Buyer::firstOrCreate(['user_id' => $user->id]);

        $transaction = Transaction::create([
            'buyer_id' => $buyer->id,
            'store_id' => 1,
            'code' => 'TRX-' . strtoupper(uniqid()),
            'address' => $request->address,
            'total' => $product->price * $request->qty,
            'status' => 'pending',
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => $request->qty,
            'price' => $product->price,
        ]);

        return redirect()->route('checkout.show', $transaction->id);
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product');
        return view('pengguna.cekout', compact('transaction'));
    }

    public function address()
    {
        return view('pengguna.alamat');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'postalcode' => 'required',
        ]);

        session([
            'checkout.address' => $request->address,
            'checkout.city' => $request->city,
            'checkout.postalcode' => $request->postalcode,
        ]);

        return redirect()->route('pengguna.pengiriman');
    }

    public function shipping()
    {
        return view('pengguna.pengiriman');
    }

    public function storeShipping(Request $request)
    {
        session([
            'checkout.shipping' => $request->shipping_method
        ]);

        return redirect()->route('pengguna.metodepembayaran');
    }

    public function payment()
    {
        return view('pengguna.metodepembayaran');
    }
}
