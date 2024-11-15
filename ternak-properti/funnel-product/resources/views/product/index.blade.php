<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products Table') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="flex items-center justify-between pb-6">
                            <h2>Product List</h2>
                            @can('create-product')
                                <div class="flex items-center justify-center gap-x-2">
                                    <a href="{{ route('products.export') }}"
                                        class="bg-green-500 text-white px-3 py-2 rounded-lg text-sm">
                                        Export to Excel
                                    </a>

                                    <a href="{{ route('products.create') }}"
                                        class="bg-zinc-800 text-slate-100 px-3 py-2 rounded-lg text-sm">Create New
                                        Product</a>
                                </div>
                            @endcan
                        </div>
                        <table class="table display mt-3" id="products-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    @role('admin')
                                        <th>Category</th>
                                    @endrole
                                    <th>Price</th>
                                    <th>Stock</th>
                                    {{-- <th>Created At</th> --}}
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        @role('admin')
                                            <td>{{ $product->category }}</td>
                                        @endrole
                                        <td>Rp. {{ str_replace(',', '.', number_format($product->price)) }}</td>
                                        <td>{{ $product->stock }}</td>
                                        {{-- <td>{{ $product->created_at->diffForHumans() }}</td> --}}
                                        <td>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="flex items-center justify-center gap-x-1">
                                                @csrf
                                                @method('DELETE')

                                                @can('edit-product')
                                                    <a href="{{ route('products.edit', $product->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </a>
                                                @endcan

                                                @can('delete-product')
                                                    <button type="submit" class="align-middle"
                                                        onclick="return confirm('Are you sure want to delete this product?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            $(document).ready(function() {
                $("#products-table").DataTable({});
            });
        </script>
    </x-slot>
</x-app-layout>
