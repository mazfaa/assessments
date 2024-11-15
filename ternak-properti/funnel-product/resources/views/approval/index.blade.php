<x-app-layout>
    {{-- <x-slot name="styles">
        <style>
            table tbody tr td {
                text-align: center !important
            }
        </style>
    </x-slot> --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="flex items-center justify-between pb-6">
                            <h2>Approval Requests List Table</h2>
                        </div>
                        <table class="table display " id="summary-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvals as $approval)
                                    <tr>
                                        <td>{{ $approval->user->name }}</td>
                                        <td>
                                            <span
                                                class="@if ($approval->status == 'pending') bg-yellow-400 @endif @if ($approval->status == 'approved') bg-green-500 @endif @if ($approval->status == 'rejected') bg-red-600 @endif text-white px-4 py-2 rounded text-sm">{{ ucfirst($approval->status) }}</span>
                                        </td>
                                        <td class="flex items-center justify-center space-x-2">
                                            @if ($approval->status == 'pending')
                                                <form action="{{ route('approval.approve', $approval->user) }}"
                                                    method="post" class="flex items-center justify-center gap-x-1">
                                                    @csrf
                                                    <x-primary-button>{{ __('Approve') }}</x-primary-button>
                                                </form>

                                                <form action="{{ route('approval.reject', $approval->user) }}"
                                                    method="post" class="flex items-center justify-center gap-x-1">
                                                    @csrf
                                                    <x-primary-button
                                                        class="bg-red-600">{{ __('Reject') }}</x-primary-button>
                                                </form>
                                            @else
                                                <span>&nbsp;</span>
                                            @endif
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
                $("#summary-table").DataTable({});
            });
        </script>
    </x-slot>
</x-app-layout>
