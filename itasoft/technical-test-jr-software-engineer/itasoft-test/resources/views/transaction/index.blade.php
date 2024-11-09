<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __("Transactions") }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="container">
            <div class="flex items-center justify-between pb-6">
							<h2>Transactions</h2>
              
              <div class="flex items-center justify-center gap-x-2">
                <a href="{{ route('transactions.export') }}" class="bg-green-500 text-white px-3 py-2 rounded-lg text-sm">
                  Export to Excel
                </a>

                <a href="{{ route('transactions.create') }}"
                    class="bg-zinc-800 text-slate-100 px-3 py-2 rounded-lg text-sm">Create New Transaction</a>
              </div>
						</div>
            <table class="table table-bordered" id="transactions-table">
              <thead>
                <tr>
                  <th>Customer</th>
                  <th>Total Quantity</th>
                  <th>Total Price</th>
                  <th>Transaction Date</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                @foreach($transactions as $transaction)
                <tr>
                  <td>{{ $transaction->user->name }}</td>
                  <td>{{ $transaction->total_quantity }}</td>
                  <td>${{ number_format($transaction->total_price, 2) }}</td>
                  <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                  <td>
                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                      class="flex items-center justify-center gap-x-1">
                      <a href="{{ route('transactions.show', $transaction->id) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                          stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                      </a>

                      @can('edit-transaction')
                        <a href="{{ route('transactions.edit', $transaction->id) }}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                          </svg>
                        </a>
                      @endcan

                      @can('delete-transaction')
                        @csrf @method('DELETE')
                        <button type="submit" class="align-middle" onclick="return confirm('Are you sure?')">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
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
      $(document).ready(function () {
        $("#transactions-table").DataTable({});
      });
    </script>
  </x-slot>
</x-app-layout>