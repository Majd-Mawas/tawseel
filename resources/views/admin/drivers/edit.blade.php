@extends('layouts.vertical', ['title' => 'Edit Driver', 'sub_title' => 'Admin', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <h5 class="card-title">Edit Driver</h5>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <form action="{{ route('admin.drivers.update', $driver) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium">Driver Information</h3>

                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', $driver->name) }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="email" name="email" value="{{ old('email', $driver->email) }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone', $driver->phone) }}" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                                        <input type="password" id="password" name="password"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                        <input type="text" id="address" name="address" value="{{ old('address', $driver->address) }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>

                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                        <select id="gender" name="gender"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $driver->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $driver->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end">
                                        <a href="{{ route('admin.drivers.index') }}"
                                            class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-3">
                                            Cancel
                                        </a>
                                        <button type="submit"
                                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Update Driver
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
