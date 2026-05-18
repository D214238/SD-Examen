<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Orders</h1>

            <div class="flex gap-3">
                <a
                        href="{{ route('orders.export', request()->query()) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                >
                    Export CSV
                </a>

                <a
                        href="{{ route('orders.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                >
                    Create Order
                </a>
            </div>
        </div>

        <form method="GET" class="bg-white p-6 rounded-xl shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search order, customer, email"
                        class="border rounded-lg px-4 py-2"
                >

                <select
                        name="status"
                        class="border rounded-lg px-4 py-2"
                >
                    <option value="">All statuses</option>

                    @foreach($statuses as $status)
                        <option
                                value="{{ $status->value }}"
                                @selected(request('status') === $status->value)
                        >
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>

                <select
                        name="payment_status"
                        class="border rounded-lg px-4 py-2"
                >
                    <option value="">All payment statuses</option>

                    @foreach($paymentStatuses as $status)
                        <option
                                value="{{ $status->value }}"
                                @selected(request('payment_status') === $status->value)
                        >
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>

                <select
                        name="payment_method"
                        class="border rounded-lg px-4 py-2"
                >
                    <option value="">All payment methods</option>

                    @foreach($paymentMethods as $method)
                        <option
                                value="{{ $method->value }}"
                                @selected(request('payment_method') === $method->value)
                        >
                            {{ $method->value }}
                        </option>
                    @endforeach
                </select>

                <select
                        name="shipping_method"
                        class="border rounded-lg px-4 py-2"
                >
                    <option value="">All shipping methods</option>

                    @foreach($shippingMethods as $method)
                        <option
                                value="{{ $method->value }}"
                                @selected(request('shipping_method') === $method->value)
                        >
                            {{ $method->value }}
                        </option>
                    @endforeach
                </select>

                <input
                        type="date"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="border rounded-lg px-4 py-2"
                >

                <input
                        type="date"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="border rounded-lg px-4 py-2"
                >
            </div>

            <div class="mt-4 flex gap-3">
                <button
                        class="px-4 py-2 bg-gray-900 text-white rounded-lg"
                >
                    Filter
                </button>

                <a
                        href="{{ route('orders.index') }}"
                        class="px-4 py-2 border rounded-lg"
                >
                    Reset
                </a>
            </div>
        </form>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Order</th>
                    <th class="text-left px-4 py-3">Customer</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Payment</th>
                    <th class="text-left px-4 py-3">Total</th>
                    <th class="text-left px-4 py-3">Created</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse($orders as $order)
                    <tr class="border-t">
                        <td class="px-4 py-3">
                            {{ $order->id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->order_code }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->user?->name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->status?->value }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->payment_status?->value }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->total }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->created_at?->format('Y-m-d') }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <a
                                        href="{{ route('orders.show', $order) }}"
                                        class="text-blue-600"
                                >
                                    View
                                </a>

                                <a
                                        href="{{ route('orders.edit', $order) }}"
                                        class="text-yellow-600"
                                >
                                    Edit
                                </a>

                                <form
                                        action="{{ route('orders.destroy', $order) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete order?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-600">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                                colspan="8"
                                class="text-center py-8 text-gray-500"
                        >
                            No orders found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>