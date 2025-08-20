@extends('layouts.vertical', ['title' => 'Create Meal', 'sub_title' => 'Menu', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="space-y-4">
            <div class="w-full">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                        <div class="card-header">
                            <h5 class="card-title">
                                Create New Meal
                            </h5>
                        </div>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <form action="{{ route('admin.restaurants.meals.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-6">
                                <div>
                                    <label for="meal-name" class="block text-sm font-medium text-gray-700">Meal Name</label>
                                    <input type="text" id="meal-name" name="name" value="{{ old('name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="meal-description"
                                        class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="meal-description" name="description" rows="4" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                                </div>

                                <div>
                                    <label for="meal-price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" id="meal-price" name="price"
                                            value="{{ old('price') }}" required
                                            class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label for="meal-category"
                                        class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="meal-category" name="category_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" id="meal-available" name="is_available" value="1"
                                        {{ old('is_available') ? 'checked' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="meal-available" class="ml-2 block text-sm text-gray-900">Available for
                                        ordering</label>
                                </div>

                                <div>
                                    <label for="meal-image" class="block text-sm font-medium text-gray-700">Meal
                                        Image</label>
                                    <input type="file" id="meal-image" name="image" accept="image/*"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div class="flex justify-end">
                                    <a href="{{ route('admin.restaurants.meals.index') }}"
                                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Create Meal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
