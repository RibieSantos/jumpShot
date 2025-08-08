@extends('admin.layouts.navigation')
@section('title','Gallery Page')
@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6 text-white">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl md:text-3xl font-bold">Gallery</h1>
        <a href="{{ route('gallery.create') }}"
            @click.prevent="loading = true; setTimeout(()=>window.location.href='{{ route('gallery.create') }}',500)"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition duration-300 whitespace-nowrap">
            + Add Image
        </a>
    </div>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "{{ session('success') }}"
                    });
                @endif
            });
        </script>
    @if ($gallery->isEmpty())
        <div class="flex justify-center items-center h-64 bg-gray-800 rounded-lg border border-gray-700">
            <p class="text-gray-400 text-lg">No images uploaded yet.</p>
        </div>
    @else
        <!-- Responsive grid for gallery items -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($gallery as $item)
                <div class="relative group bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700 hover:shadow-xl transition-shadow duration-300">
                    <!-- Image with responsive height -->
                    <img src="{{ asset('gallery/' . $item->image) }}"
                         alt="{{ $item->title ?? 'Gallery Image' }}"
                         class="w-full h-48 object-cover">
                    <!-- Image Info Overlay (visible on hover or always visible on smaller screens if preferred) -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-white truncate">{{ $item->title ?? 'No Title' }}</h3>
                        <p class="text-sm text-gray-300 mt-1 line-clamp-2">{{ $item->description ?? 'No description available.' }}</p>
                    </div>
                    <!-- Centered delete icon on hover -->
                    <form action="{{ route('gallery.destroy',$item->id) }}" method="POST"
                        @click.prevent="Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $el.submit();
            }
        })"
                          class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-70 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                title="Delete Image"
                                class="text-white text-4xl hover:text-red-500 transition-colors duration-300 p-3 rounded-full bg-gray-900 bg-opacity-50 hover:bg-opacity-70">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection