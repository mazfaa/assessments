{{-- {{ dd($transaction_item) }} --}}

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Transaction Details') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <!-- Transaction Info -->
          <div class="mb-6">
            <h3 class="text-lg font-semibold">Transaction Information</h3>

            <table class="table w-1/2 mt-4">
              <tr>
                <th class="text-left">Transaction ID</th>
                <td>:</td>
                <td>{{ $transaction->id }}</td>
              </tr>

              <tr>
                <th class="text-left">Customer Name</th>
                <td>:</td>
                <td>{{ $transaction->user->name }}</td>
              </tr>

              <tr>
                <th class="text-left">Transaction Date</th>
                <td>:</td>
                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
              </tr>

              <tr>
                <th class="text-left">Total Quantity</th>
                <td>:</td>
                <td>{{ $transaction->total_quantity }}</td>
              </tr>

              <tr>
                <th class="text-left">Total Price</th>
                <td>:</td>
                <td>${{ number_format($transaction->total_price, 2)  }}</td>
              </tr>
            </table>
          </div>

          <!-- Product Details -->
          <div>
            <h3 class="text-lg font-semibold">Products</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full mt-4 border border-gray-200">
                <thead>
                  <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Product Name</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-left">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  @php $total_price = 0; @endphp
                  @foreach($transaction_item as $index => $transaction)
                    @php $product = $transaction->product @endphp
                    <tr class="border-t">
                      <td class="px-4 py-2">{{ $index + 1 }}</td>
                      <td class="px-4 py-2">{{ $product->name }}</td>
                      <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                      <td class="px-4 py-2">{{ $transaction->quantity }}</td>
                      <td class="px-4 py-2">${{ number_format($product->price * $transaction->quantity, 2) }}</td>
                      @php $total_price += $product->price * $transaction->quantity @endphp
                    </tr>
                  @endforeach

                  <tr>
                    <td class="px-4 py-2 bg-gray-100" colspan="4">
                      Total
                    </td>
                    <td class="px-4 py-2 bg-gray-900 text-white">
                      ${{ number_format($total_price, 2) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Back Button -->
          <div class="mt-6">
            <a href="{{ route('transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
              Back to Transactions
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
