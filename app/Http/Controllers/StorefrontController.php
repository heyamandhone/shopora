<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StorefrontController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->with(['category:id,name,slug', 'brand:id,name,slug'])
            ->latest()
            ->take(6)
            ->get();

        return Inertia::render('storefront/Home', [
            'featuredProducts' => $featuredProducts->map(fn (Product $product) => $this->formatProduct($product)),
            'categories' => Category::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'slug']),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function shop(Request $request)
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with(['category:id,name,slug', 'brand:id,name,slug'])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('storefront/Shop', [
            'products' => $products->through(fn (Product $product) => $this->formatProduct($product)),
            'filters' => [
                'search' => $request->search,
            ],
            'categories' => Category::where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'slug']),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return Inertia::render('storefront/Product', [
            'product' => $this->formatProduct($product->load(['category:id,name,slug', 'brand:id,name,slug'])),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function cart()
    {
        $cartItems = $this->cartItems();

        return Inertia::render('storefront/Cart', [
            'cartItems' => $cartItems->values(),
            'subtotal' => round($cartItems->sum(fn ($item) => $item->quantity * $item->price), 2),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $customer = Auth::check() ? $this->ensureCustomer(Auth::user()) : null;

        Cart::updateOrCreate(
            [
                'session_id' => session()->getId(),
                'customer_id' => $customer?->id,
                'product_id' => $product->id,
            ],
            [
                'quantity' => $quantity,
                'price' => $product->sale_price ?? $product->price,
                'options' => [],
            ]
        );

        return back()->with('success', 'Item added to your cart.');
    }

    public function removeFromCart(Cart $cart)
    {
        $cart->delete();

        return back()->with('success', 'Item removed from your cart.');
    }

    public function checkoutPage()
    {
        $cartItems = $this->cartItems();

        return Inertia::render('storefront/Checkout', [
            'cartItems' => $cartItems->values(),
            'subtotal' => round($cartItems->sum(fn ($item) => $item->quantity * $item->price), 2),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function checkout(Request $request)
    {
        $cartItems = $this->cartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('storefront.cart')->with('error', 'Your cart is empty.');
        }

        $customer = Auth::check() ? $this->ensureCustomer(Auth::user()) : null;
        $subtotal = round($cartItems->sum(fn ($item) => $item->quantity * $item->price), 2);
        $shipping = $subtotal > 0 ? 5.00 : 0.00;
        $tax = round($subtotal * 0.10, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        $order = Order::create([
            'order_number' => 'ORD-' . now()->format('YmdHis'),
            'customer_id' => $customer?->id ?? 0,
            'subtotal' => $subtotal,
            'discount' => 0,
            'tax' => $tax,
            'shipping_charge' => $shipping,
            'total' => $total,
            'status' => 'processing',
            'payment_status' => 'paid',
            'notes' => $request->input('notes'),
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => round($item->quantity * $item->price, 2),
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'card',
            'transaction_id' => Str::uuid(),
            'amount' => $total,
            'status' => 'paid',
            'notes' => 'Checkout completed from storefront.',
        ]);

        Cart::where(function ($query) use ($customer) {
            $query->where('session_id', session()->getId());

            if ($customer) {
                $query->orWhere('customer_id', $customer->id);
            }
        })->delete();

        return redirect()->route('storefront.account')->with('success', 'Order placed successfully.');
    }

    public function account()
    {
        $customer = Auth::check() ? $this->ensureCustomer(Auth::user()) : null;

        $orders = $customer
            ? Order::where('customer_id', $customer->id)->with('items.product')->latest()->get()
            : collect();

        return Inertia::render('storefront/Account', [
            'user' => Auth::user(),
            'customer' => $customer,
            'orders' => $orders,
            'cartCount' => $this->cartCount(),
        ]);
    }

    private function cartItems()
    {
        $customer = Auth::check() ? $this->ensureCustomer(Auth::user()) : null;

        $query = Cart::query()
            ->with('product')
            ->where('session_id', session()->getId());

        if ($customer) {
            $query->orWhere('customer_id', $customer->id);
        }

        return $query->get()->filter(fn (Cart $item) => $item->product !== null);
    }

    private function cartCount(): int
    {
        return $this->cartItems()->sum('quantity');
    }

    private function ensureCustomer($user): Customer
    {
        return Customer::firstOrCreate(
            ['email' => $user->email],
            [
                'first_name' => Str::before($user->name, ' '),
                'last_name' => Str::after($user->name, ' '),
                'email' => $user->email,
                'phone' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }

    private function formatProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'description' => $product->description,
            'price' => number_format((float) $product->price, 2, '.', ''),
            'sale_price' => $product->sale_price ? number_format((float) $product->sale_price, 2, '.', '') : null,
            'thumbnail' => $product->thumbnail,
            'category' => $product->relationLoaded('category') ? $product->category?->only(['id', 'name', 'slug']) : null,
            'brand' => $product->relationLoaded('brand') ? $product->brand?->only(['id', 'name', 'slug']) : null,
            'stock' => $product->stock,
            'is_active' => $product->is_active,
            'is_featured' => $product->is_featured,
        ];
    }
}
