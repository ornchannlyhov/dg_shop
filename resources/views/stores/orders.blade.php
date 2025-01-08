@extends('layouts.dashboard')

@section('title', 'Order Requests')

@section('content')

<div class="p-6 min-h-screen">
    <!-- Tabs Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <a href="{{ route('storeOrderView', ['storeId' => $store->store_id]) }}"
            class="bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 text-white text-center">
            All Orders
        </a>
        <a href="{{ route('storeOrderView', ['storeId' => $store->store_id, 'status' => 'pending']) }}"
            class="bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 text-white text-center">
            Pending Orders
        </a>
        <a href="{{ route('storeOrderView', ['storeId' => $store->store_id, 'status' => 'shipped']) }}"
            class="bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 text-white text-center">
            Accepted Orders
        </a>
        <a href="{{ route('storeOrderView', ['storeId' => $store->store_id, 'status' => 'canceled']) }}"
            class="bg-gray-800 p-3 rounded-lg shadow-md hover:bg-gray-700 text-white text-center">
            Cancelled Orders
        </a>
    </div>

    <!-- Orders Table Section -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-md" style="background-color: #3f3f46;">
        <div class="flex justify-between items-center mb-4 flex-wrap">
            <div class="flex items-center mb-0 sm:mb-0">
                <!-- Heading -->
                <h2 class="text-2xl font-bold text-white mr-4">
                    {{ ucfirst($status ?? 'All Orders') }}
                </h2>
            </div>
        </div>

        <!-- Orders Table -->
        <table class="min-w-full text-left border-collapse text-white" style="background-color: #3f3f46;">
            <thead>
                <tr class="bg-gray-700 text-white">
                    <th class="py-3 px-6">Customer</th>
                    <th class="py-3 px-6">Items</th>
                    <th class="py-3 px-6">Total</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Action</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                @forelse($ordersForStore as $order)
                    <tr class="border-b border-gray-600" id="order-row-{{ $order->order_id }}">
                        <td class="py-3 px-6">{{ $order->user_id }}</td>
                        <td class="py-3 px-6">{{ $order->items->count() }}</td>
                        <td class="py-3 px-6">${{ $order->total_amount }}</td>
                        <td class="py-3 px-6 status" id="status-{{ $order->order_id }}">{{ $order->status }}</td>
                        <td class="py-3 px-6">
                            <div class="flex space-x-2">
                                <!-- Accept Button -->
                                @if ($order->status === 'pending')
                                    <form action="{{ route('order.confirm', $order->order_id) }}" method="POST"
                                        id="confirm-order-form-{{ $order->order_id  }}">
                                        @csrf
                                        <button type="button"
                                            class="bg-green-500 text-white rounded-full p-2 hover:bg-green-600 confirm-order-button"
                                            data-order-id="{{$order->order_id  }}">
                                            Accept
                                        </button>
                                    </form>
                                @else
                                    <button type="button"
                                        class="bg-yellow-500 text-white rounded-full p-2 hover:bg-green-600 confirm-order-button" ">
                                                N/A
                                            </button>
                                @endif
                                </div>
                            </td>
                        </tr>
                @empty
                        <tr>
                            <td colspan=" 5" class="py-3 px-6 text-center text-gray-400">No orders available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).on('click', '.confirm-order-button', function () {
        const orderId = $(this).data('order-id');

        $.ajax({
            url: '{{ url("/order/confirm") }}/' + orderId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    $('#status-' + orderId).text('Accepted');
                    $('#confirm-order-form-' + orderId).find('.confirm-order-button').text('Accepted').prop('disabled', true).removeClass('bg-green-500').addClass('bg-gray-500');

                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>

@endsection