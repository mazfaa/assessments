<x-app-layout>
    <x-slot name="styles">
        <style>
            table tbody tr td {
                text-align: center !important
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Summary Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="flex items-center justify-between pb-6">
                            <h2>Summary Reports Table</h2>

                            <div class="flex items-center justify-center gap-x-2">
                                <a href="{{ route('summary.export') }}"
                                    class="bg-green-500 text-white px-3 py-2 rounded-lg text-sm">
                                    Export to Excel
                                </a>
                            </div>
                        </div>
                        <table class="table display" id="summary-table">
                            <thead>
                                <tr>
                                    <th>Customer Amount</th>
                                    <th>Total Sales</th>
                                    <th>Average Purchase</th>
                                    <th>Total Customers That Have Bought 1a</th>
                                    <th>Total Customers That Have Not Bought 1b</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $customer_amount }}</td>
                                    <td>{{ $total_sales }}</td>
                                    <td>Rp. {{ str_replace(',', '.', number_format($average_purchase)) }}
                                    </td>
                                    <td>{{ $customers_that_have_bought_1a }}</td>
                                    <td>{{ $customers_that_have_not_bought_1b }}</td>
                                </tr>
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
                $("#summary-table").DataTable({});
            });
        </script>
    </x-slot>
</x-app-layout>
