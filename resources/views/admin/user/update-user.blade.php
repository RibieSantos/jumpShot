@extends('admin.layouts.navigation')
@section('title', 'Update User')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Update User</h1>
            <a href="{{ route('user.show') }}"
                @click.prevent="loading = true; setTimeout(() => {window.location.href = '{{ route('user.show') }}'}, 500);"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <form action="{{ route('user.update', $user->id) }}" @submit="loading = true;" method="POST">
            @csrf
            @method('PUT')

         
            
            <label for="status" class="block mt-4 mb-2 font-medium">Status</label>
            <select name="status" id="status"
                class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="{{ $user->status }}">{{ $user->status }}</option>
                <option value="inactive">Inactive</option>
                <option value="active">Active</option>
            </select>
            <!-- Submit Button -->
            <input type="submit" value="Update Member"
                class="cursor-pointer bg-yellow-500 text-white px-3 py-2 rounded-lg mt-3 w-full hover:bg-white hover:text-black transition-all duration-300 hover:shadow-lg">
        </form>
    </div>

@endsection
