@extends('admin.layouts.navigation')
@section('title', 'Add Member')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Add Member</h1>
            <a href="{{ route('members.show') }}"
                @click.prevent="loading = true; setTimeout(() =>{window.location.href='{{ route('members.show') }}'},500);"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>

        <form action="{{ route('member.store') }}" @submit="loading = true;" method="POST">
            @csrf

            <!-- Select Member -->
            <label for="user_id" class="block mb-2 font-medium">Select a Member</label>
            <select name="user_id" id="user_id"
                class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select a Member</option>
                @foreach ($users as $user)
                    @if ($user->role == null)
                    <option value="{{ $user->id }}">{{ $user->lname }}, {{ $user->fname }} {{ $user->mname }}
                    </option>
                @endif
                @endforeach
            </select>
            @error('user_id')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
            <!-- Submit Button -->
            <input type="submit" value="Add Member"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black hover:shadow-lg transition-all duration-300">
        </form>
    </div>

@endsection
