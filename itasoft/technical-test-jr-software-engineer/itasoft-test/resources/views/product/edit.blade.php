<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            {{ __('Edit Product') }}

            <a href="{{ route('products.index') }}" class="text-sm flex items-center justify-center gap-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
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
                      <form action="{{ route('products.update', $product->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div>
                              <x-input-label for="name" :value="__('Product Name')" />
                              <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="name" name="name" value="{{ old('name', $product->name) }}" autocomplete="off" autofocus required>

                              @error('name')
                                <span class="text-danger mt-2">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="mt-4">
                              <x-input-label for="price" :value="__('Price')" />
                              <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="price" name="price" value="{{ old('price', $product->price) }}" autocomplete="off" required>

                              @error('price')
                                <span class="text-danger mt-2">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="mt-4">
                              <x-input-label for="stock" :value="__('Stock')" />
                              <input type="number" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" autocomplete="off" required>

                              @error('stock')
                                <span class="text-danger mt-2">{{ $message }}</span>
                              @enderror
                          </div>
                          
                          <x-primary-button class="mt-4">
                            {{ __('Edit') }}
                          </x-primary-button>
                      </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
