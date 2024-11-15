{{-- {{ @if (isset($errors)) dd($errors) }} --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Create Transaction') }}

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
                        <form action="{{ route('transactions.store') }}" method="POST">
                            @csrf
                            <div>
                                <x-input-label for="user_id" :value="__('Customer Name')" />
                                <select name="user_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                                    @if (auth()->user()->hasRole('customer'))
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @else
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div id="product-list" class="mt-4">
                                <div class="flex items-center gap-x-2 product-item">
                                    <div class="w-1/2">
                                        <x-input-label for="Product" :value="__('Product')" />
                                        <select name="products[0][id]"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full select-product-form"
                                            id="product-select-form">
                                            @foreach ($products as $product)
                                                <option data-price={{ $product->price }} value="{{ $product->id }}">
                                                    {{ $product->name }} - Rp. {{ number_format($product->price, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-1/2">
                                        <x-input-label for="quantity" :value="__('Quantity')" />
                                        <input type="number" name="products[0][quantity]"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full quantity-form"
                                            value="{{ old('products[0][quantity]', 1) }}" autocomplete="off"
                                            placeholder="Quantity" id="quantity-form" min="1" required>
                                        <span
                                            class="text-danger mt-3">{{ $errors->first('products.0.quantity') }}</span>
                                    </div>
                                </div>
                            </div>

                            <table class="table w-1/4 mt-4">
                                <tr>
                                    <th class="text-left">Total Quantity</th>
                                    <td>:</td>
                                    <td id="total-quantity-transaction" class="ps-8"></td>
                                </tr>

                                <tr>
                                    <th class="text-left">Total Price</th>
                                    <td>:</td>
                                    <td id="total-price-transaction" class="ps-8"></td>
                                </tr>
                            </table>

                            <button type="button" id="add-product"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Add
                                Another Product</button>
                            <x-primary-button class="mt-4">
                                {{ __('Submit') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('total-price-transaction').innerText =
                    'Rp. {{ number_format($products[0]->price, 2) }}'
                document.getElementById('total-quantity-transaction').innerText = 1;

                function updateTotalPrice() {
                    let totalPrice = 0;
                    let totalQuantity = 0;

                    const productSelects = document.querySelectorAll('.select-product-form');
                    const quantityInputs = document.querySelectorAll('.quantity-form');

                    productSelects.forEach((select, index) => {
                        const selectedOption = select.options[select.selectedIndex];
                        const productPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                        const quantity = parseInt(quantityInputs[index].value) || 0;

                        totalPrice += productPrice * quantity;
                        totalQuantity += quantity;
                    });

                    document.getElementById('total-price-transaction').innerText =
                        `Rp. ${totalPrice.toLocaleString('id-ID')}`;
                    document.getElementById('total-quantity-transaction').innerText = totalQuantity;
                }

                // Attach event listeners
                function attachEventListeners() {
                    const productSelects = document.querySelectorAll('.select-product-form');
                    const quantityInputs = document.querySelectorAll('.quantity-form');

                    productSelects.forEach(select => {
                        select.addEventListener('change', updateTotalPrice);
                    });

                    quantityInputs.forEach(input => {
                        input.addEventListener('input', updateTotalPrice);
                    });
                }

                document.getElementById('add-product').addEventListener('click', function() {
                    const productList = document.getElementById('product-list');
                    const index = productList.children.length;

                    const productSelect = `
                      <div class="flex items-center gap-x-2 product-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                          class="size-4 hover:cursor-pointer remove-product" onclick="removeProduct(this)">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                        <div class="form-group flex items-center gap-x-2 w-full">
                          <div class="w-1/2">
                            <select name="products[${index}][id]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full select-product-form">
                              @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ${{ $product->price }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="w-1/2">
                            <input type="number" name="products[${index}][quantity]" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full mt-2 quantity-form" placeholder="Quantity" value="1" min="1" required>
                          </div>
                        </div>
                      </div>
                    `;

                    productList.insertAdjacentHTML('beforeend', productSelect);
                    attachEventListeners(); // Attach event listeners to new elements
                });

                attachEventListeners(); // Initial call to attach listeners

                // Fungsi untuk menghapus elemen input produk
                window.removeProduct = function(element) {
                    const productItem = element.closest('.product-item');
                    if (productItem && document.querySelectorAll('.product-item').length > 1) {
                        productItem.remove();
                        updateTotalPrice(); // Update total price after removing
                    } else {
                        alert('Minimal satu produk harus dipilih.');
                    }
                };
            });
        </script>
    </x-slot>
</x-app-layout>
