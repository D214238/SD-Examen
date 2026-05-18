@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block mb-2 font-medium">
            User
        </label>

        <select
                name="user_id"
                class="w-full border rounded-lg px-4 py-2"
        >
            <option value="">Guest</option>

            @foreach($users as $user)
                <option
                        value="{{ $user->id }}"
                        @selected(old('user_id', $order->user_id ?? '') == $user->id)
                >
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Order Code
        </label>

        <input
                type="text"
                name="order_code"
                value="{{ old('order_code', $order->order_code ?? '') }}"
                class="w-full border rounded-lg px-4 py-2"
        >
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Status
        </label>

        <select
                name="status"
                class="w-full border rounded-lg px-4 py-2"
        >
            @foreach($statuses as $status)
                <option
                        value="{{ $status->value }}"
                        @selected(old('status', $order->status?->value ?? '') === $status->value)
                >
                    {{ $status->value }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Payment Status
        </label>

        <select
                name="payment_status"
                class="w-full border rounded-lg px-4 py-2"
        >
            @foreach($paymentStatuses as $status)
                <option
                        value="{{ $status->value }}"
                        @selected(old('payment_status', $order->payment_status?->value ?? '') === $status->value)
                >
                    {{ $status->value }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Payment Method
        </label>

        <select
                name="payment_method"
                class="w-full border rounded-lg px-4 py-2"
        >
            @foreach($paymentMethods as $method)
                <option
                        value="{{ $method->value }}"
                        @selected(old('payment_method', $order->payment_method?->value ?? '') === $method->value)
                >
                    {{ $method->value }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Shipping Method
        </label>

        <select
                name="shipping_method"
                class="w-full border rounded-lg px-4 py-2"
        >
            @foreach($shippingMethods as $method)
                <option
                        value="{{ $method->value }}"
                        @selected(old('shipping_method', $order->shipping_method?->value ?? '') === $method->value)
                >
                    {{ $method->value }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Subtotal
        </label>

        <input
                type="number"
                name="subtotal"
                value="{{ old('subtotal', $order->subtotal ?? 0) }}"
                class="w-full border rounded-lg px-4 py-2"
        >
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Discount
        </label>

        <input
                type="number"
                name="discount"
                value="{{ old('discount', $order->discount ?? 0) }}"
                class="w-full border rounded-lg px-4 py-2"
        >
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Shipping Cost
        </label>

        <input
                type="number"
                name="shipping_cost"
                value="{{ old('shipping_cost', $order->shipping_cost ?? 0) }}"
                class="w-full border rounded-lg px-4 py-2"
        >
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Tax
        </label>

        <input
                type="number"
                name="tax"
                value="{{ old('tax', $order->tax ?? 0) }}"
                class="w-full border rounded-lg px-4 py-2"
        >
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Total
        </label>

        <input
                type="number"
                name="total"
                value="{{ old('total', $order->total ?? 0) }}"
                class="w-full border rounded-lg px-4 py-2"
        >
    </div>

</div>

<div class="mt-8">
    <h2 class="text-xl font-semibold mb-4">
        Address
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <input
                type="text"
                name="address[name]"
                value="{{ old('address.name', $order->address['name'] ?? '') }}"
                placeholder="Name"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="email"
                name="address[email]"
                value="{{ old('address.email', $order->address['email'] ?? '') }}"
                placeholder="Email"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="text"
                name="address[phone]"
                value="{{ old('address.phone', $order->address['phone'] ?? '') }}"
                placeholder="Phone"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="text"
                name="address[address_line_1]"
                value="{{ old('address.address_line_1', $order->address['address_line_1'] ?? '') }}"
                placeholder="Address line 1"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="text"
                name="address[address_line_2]"
                value="{{ old('address.address_line_2', $order->address['address_line_2'] ?? '') }}"
                placeholder="Address line 2"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="text"
                name="address[city]"
                value="{{ old('address.city', $order->address['city'] ?? '') }}"
                placeholder="City"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="text"
                name="address[postcode]"
                value="{{ old('address.postcode', $order->address['postcode'] ?? '') }}"
                placeholder="Postcode"
                class="border rounded-lg px-4 py-2"
        >

        <input
                type="text"
                name="address[country]"
                value="{{ old('address.country', $order->address['country'] ?? '') }}"
                placeholder="Country"
                class="border rounded-lg px-4 py-2"
        >
    </div>
</div>

<div class="mt-8">
    <button
            class="px-6 py-3 bg-gray-900 text-white rounded-lg"
    >
        Save Order
    </button>
</div>