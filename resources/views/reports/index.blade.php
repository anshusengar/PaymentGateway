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

  
       

        {{-- Coupons List --}}
        <div class="w-full md:w-1/2 overflow-x-auto bg-gray-50 p-4 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Report</h3>
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
                  
                </tbody>
            </table>
        </div>
    
</div>
@endsection
