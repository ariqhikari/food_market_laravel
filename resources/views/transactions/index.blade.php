<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border px-6 py-4">ID</th>
                            <th class="border px-6 py-4">Food</th>
                            <th class="border px-6 py-4">User</th>
                            <th class="border px-6 py-4">Quantity</th>
                            <th class="border px-6 py-4">Total</th>
                            <th class="border px-6 py-4">Status</th>
                            <th class="border px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="border px-6 py-4">{{ $transaction->id }}</td>
                                <td class="border px-6 py-4">{{ $transaction->food->name }}</td>
                                <td class="border px-6 py-4">{{ $transaction->user->name }}</td>
                                <td class="border px-6 py-4">{{ $transaction->quantity }}</td>
                                <td class="border px-6 py-4">{{ number_format($transaction->total) }}</td>
                                <td class="border px-6 py-4">{{ $transaction->status }}</td>
                                <td class="border px-6 py-4 text-center">
                                    <a href="{{ route('transactions.show', $transaction) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                        View
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border px-6 py-4 text-center" colspan="7">Data Transaction Tidak Ditemukan!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-5">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
