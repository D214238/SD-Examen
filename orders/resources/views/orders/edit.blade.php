<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">

        <h1 class="text-3xl font-bold mb-6">
            Edit Order
        </h1>

        <form
                action="{{ route('orders.update', $order) }}"
                method="POST"
                class="bg-white p-6 rounded-xl shadow"
        >
            @method('PUT')

            @include('orders._form')
        </form>

    </div>
</x-app-layout>