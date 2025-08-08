@extends('admin.layouts.navigation')
@section('title','Add Players')
@section('content')
<!-- Flash Message -->
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50">
                {{ session('error') }}
            </div>
        @endif
    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
<div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Add Player</h1>
            <a href="{{ route('players.show') }}"
                @click.prevent="loading = true; setTimeout(() =>{window.location.href='{{ route('players.show') }}'},500);"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
    <form action="{{ route('players.store',$team_id) }}" @submit="loading = true;" method="POST">
    @csrf
    <label for="member_id" class="block mb-2 font-medium">Select Member:</label>
<select name="member_id" id="member_id"
                class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">        @foreach($members as $member)
    <option value="{{ $member->id }}">
        {{ $member->user->fname ?? 'No Firstname' }} {{ $member->user->mname ?? ' ' }} {{ $member->user->lname ?? 'No Lastname' }}
    </option>
@endforeach
    </select>
<input type="submit" value="Add Member"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black hover:shadow-lg transition-all duration-300"></form>
    </div>
@endsection