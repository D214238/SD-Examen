<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Values\OrderStatus;
use App\Values\PaymentMethod;
use App\Values\PaymentStatus;
use App\Values\ShippingMethod;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $this->queryOrders($request)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => OrderStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
            'paymentMethods' => PaymentMethod::cases(),
            'shippingMethods' => ShippingMethod::cases(),
        ]);
    }

    public function create()
    {
        return view('orders.create', [
            'users' => User::query()->orderBy('name')->get(),
            'statuses' => OrderStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
            'paymentMethods' => PaymentMethod::cases(),
            'shippingMethods' => ShippingMethod::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $order = Order::create($data);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('user', 'products');

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', [
            'order' => $order,
            'users' => User::query()->orderBy('name')->get(),
            'statuses' => OrderStatus::cases(),
            'paymentStatuses' => PaymentStatus::cases(),
            'paymentMethods' => PaymentMethod::cases(),
            'shippingMethods' => ShippingMethod::cases(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $this->validated($request);

        $order->update($data);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'orders-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $columns = [
            'ID',
            'Order Code',
            'Customer',
            'Status',
            'Payment Status',
            'Payment Method',
            'Shipping Method',
            'Subtotal',
            'Discount',
            'Shipping Cost',
            'Tax',
            'Total',
            'Created At',
        ];

        return response()->stream(function () use ($request, $columns) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, $columns);

            $this->queryOrders($request)
                ->with('user')
                ->chunk(200, function ($orders) use ($handle) {
                    foreach ($orders as $order) {
                        fputcsv($handle, [
                            $order->id,
                            $order->order_code,
                            $order->user?->name,
                            $order->status?->value,
                            $order->payment_status?->value,
                            $order->payment_method?->value,
                            $order->shipping_method?->value,
                            $order->subtotal,
                            $order->discount,
                            $order->shipping_cost,
                            $order->tax,
                            $order->total,
                            $order->created_at,
                        ]);
                    }
                });

            fclose($handle);
        }, 200, $headers);
    }

    protected function queryOrders(Request $request)
    {
        return Order::query()
            ->with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search');

                $query->where(function ($query) use ($search) {
                    $query->where('order_code', 'like', "%{$search}%")
                        ->orWhere('id', $search)
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->status)
            )
            ->when($request->filled('payment_status'), fn($query) => $query->where('payment_status', $request->payment_status)
            )
            ->when($request->filled('payment_method'), fn($query) => $query->where('payment_method', $request->payment_method)
            )
            ->when($request->filled('shipping_method'), fn($query) => $query->where('shipping_method', $request->shipping_method)
            )
            ->when($request->filled('date_from'), fn($query) => $query->whereDate('created_at', '>=', $request->date_from)
            )
            ->when($request->filled('date_to'), fn($query) => $query->whereDate('created_at', '<=', $request->date_to)
            );
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'status' => ['required'],
            'payment_status' => ['required'],
            'payment_method' => ['required'],
            'shipping_method' => ['nullable'],
            'subtotal' => ['required', 'integer', 'min:0'],
            'discount' => ['nullable', 'integer', 'min:0'],
            'shipping_cost' => ['nullable', 'integer', 'min:0'],
            'tax' => ['nullable', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:0'],
            'order_code' => ['nullable', 'string', 'max:255'],

            'address' => ['required', 'array'],
            'address.name' => ['required', 'string'],
            'address.email' => ['required', 'email'],
            'address.phone' => ['required', 'string'],
            'address.address_line_1' => ['required', 'string'],
            'address.address_line_2' => ['nullable', 'string'],
            'address.city' => ['required', 'string'],
            'address.postcode' => ['required', 'string'],
            'address.country' => ['required', 'string'],
        ]);
    }
}