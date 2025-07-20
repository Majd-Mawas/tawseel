@extends('layouts.vertical', ['title' => 'Create Category', 'sub_title' => 'Menu', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                                Create New Category
                            </h5>
                        </div>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <form action="{{ route('dashboard.categories.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-6">
                                <div>
                                    <label for="category-name" class="block text-sm font-medium text-gray-700">Category
                                        Name</label>
                                    <input type="text" id="category-name" name="name" value="{{ old('name') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="category-type" class="block text-sm font-medium text-gray-700">Type</label>
                                    <select id="category-type" name="type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="restaurant" {{ old('type') === 'restaurant' ? 'selected' : '' }}>
                                            Restaurant</option>
                                        <option value="shop_center" {{ old('type') === 'shop_center' ? 'selected' : '' }}>
                                            Shop Center</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="category-image" class="block text-sm font-medium text-gray-700">Category
                                        Image</label>
                                    <input type="file" id="category-image" name="image" accept="image/*"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div class="flex justify-end">
                                    <a href="{{ route('dashboard.categories.index') }}"
                                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Create Category
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
