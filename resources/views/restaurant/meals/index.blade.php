@extends('layouts.vertical', ['title' => 'Meals Management', 'sub_title' => 'Menu', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="space-y-4">
            <div class="w-full">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <button type="button" class="absolute top-0 right-0 px-4 py-3" data-bs-dismiss="alert">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="shadow rounded-lg">
                        <div class="card-header flex justify-between items-center">
                            <h5 class="card-title text-lg font-medium leading-6 ">
                                Meals
                            </h5>
                            <a href="{{ route('dashboard.meals.create') }}"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Add New Meal
                            </a>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            @if ($meals->isEmpty())
                                <p class="text-gray-500 text-center py-4">No meals found. Create your first meal!</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Image</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Price</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Category</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach ($meals as $meal)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if ($meal->getFirstMediaUrl('image'))
                                                            <img src="{{ $meal->getFirstMediaUrl('image') }}"
                                                                alt="{{ $meal->name }}"
                                                                class="h-10 w-10 rounded-full object-cover">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                <span class="text-gray-500">No img</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium ">{{ $meal->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm ">
                                                            ${{ number_format($meal->price, 2) }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm ">
                                                            {{ $meal->category->name ?? 'No Category' }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $meal->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ $meal->is_available ? 'Available' : 'Unavailable' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('dashboard.meals.edit', $meal) }}"
                                                            class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                        <form action="{{ route('dashboard.meals.destroy', $meal) }}"
                                                            method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                                onclick="return confirm('Are you sure you want to delete this meal?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
