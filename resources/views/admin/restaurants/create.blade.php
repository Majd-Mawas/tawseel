@extends('layouts.vertical', ['title' => 'Create Restaurant', 'sub_title' => 'Admin', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="space-y-4">
            <div class="w-full">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
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
                            <h5 class="card-title">Create New Restaurant</h5>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium">Restaurant Information</h3>

                                    <div>
                                        <label for="restaurant-name" class="block text-sm font-medium text-gray-700">Restaurant Name</label>
                                        <input type="text" id="restaurant-name" name="name" value="{{ old('name') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="restaurant-description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="restaurant-description" name="description" rows="4"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                                    </div>

                                    <div>
                                        <label for="restaurant-phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="text" id="restaurant-phone" name="phone" value="{{ old('phone') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                        <div>
                                            <label for="restaurant-latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                            <input type="text" id="restaurant-latitude" name="latitude" value="{{ old('latitude') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="restaurant-longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                            <input type="text" id="restaurant-longitude" name="longitude" value="{{ old('longitude') }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="restaurant-type" class="block text-sm font-medium text-gray-700">Type</label>
                                        <select id="restaurant-type" name="type"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="restaurant" {{ old('type') === 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                            <option value="shop_center" {{ old('type') === 'shop_center' ? 'selected' : '' }}>Shop Center</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="restaurant-image" class="block text-sm font-medium text-gray-700">Restaurant Image</label>
                                        <input type="file" id="restaurant-image" name="image" accept="image/*"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <h3 class="text-lg font-medium text-gray-900 pt-4">Restaurant Admin Information</h3>

                                    <div>
                                        <label for="admin-name" class="block text-sm font-medium text-gray-700">Admin Name</label>
                                        <input type="text" id="admin-name" name="admin_name" value="{{ old('admin_name') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="admin-email" class="block text-sm font-medium text-gray-700">Admin Email</label>
                                        <input type="email" id="admin-email" name="admin_email" value="{{ old('admin_email') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="admin-phone" class="block text-sm font-medium text-gray-700">Admin Phone</label>
                                        <input type="text" id="admin-phone" name="admin_phone" value="{{ old('admin_phone') }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="admin-password" class="block text-sm font-medium text-gray-700">Admin Password</label>
                                        <input type="password" id="admin-password" name="admin_password" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('admin.restaurants.index') }}"
                                            class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Create Restaurant
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
