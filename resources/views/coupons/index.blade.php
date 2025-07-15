@extends('layouts.app')

@section('content')
<div class="w-full mt-20 p-8 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">All Coupons</h2>

    @if(session('success'))
    <div class="flex justify-between items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-green-700" aria-label="Close" onclick="this.parentElement.style.display='none';">
            <span aria-hidden="true" class="text-xl font-bold">&times;</span>
        </button>
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        {{-- Add Coupon Form --}}
        <div class="w-full md:w-1/2 bg-gray-50 p-4 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Add New Coupon</h3>
            <form action="{{ route('coupons.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                    <input type="text" name="code" required class="w-full px-3 py-2 border border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                    <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                    <input type="number" step="0.01" name="value" required class="w-full px-3 py-2 border border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded">
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Add Coupon</button>
                </div>
            </form>
        </div>

        {{-- Coupons List --}}
        <div class="w-full md:w-1/2 overflow-x-auto bg-gray-50 p-4 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">All Coupons</h3>
            <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Code</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Value</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-200">
                    @foreach($coupons as $index => $coupon)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $coupon->code }}</td>
                        <td class="px-6 py-4">{{ ucfirst($coupon->type) }}</td>
                        <td class="px-6 py-4">
                            @if($coupon->type == 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ₹{{ $coupon->value }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
