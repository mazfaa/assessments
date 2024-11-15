{{-- {{ dd($transaction->products) }} --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Update Transaction') }}

            <a href="{{ route('transactions.index') }}" class="text-sm flex items-center justify-center gap-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Back
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1>Edit Transaction #{{ $transaction->id }}</h1>
                        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label for="user">Customer Name : {{ $transaction->user->name }}</label>
                            </div>

                            <x-input-label for="Product" :value="__('Product')" />
                            <div id="product-list">
                                @foreach ($transaction->products as $index => $detail)
                                    <div class="flex items-center gap-x-2">
                                        <div class="w-1/2">
                                            <select name="products[{{ $index }}][id]"
                                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $detail->id == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }} - Rp.
                                                        {{ number_format($product->price, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="w-1/2">
                                            <input type="number" name="products[{{ $index }}][quantity]"
                                                value="{{ $transaction->transactionDetails[$index]->quantity }}"
                                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                                                placeholder="Quantity" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <x-primary-button class="mt-4">
                                {{ __('Update Transaction') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
