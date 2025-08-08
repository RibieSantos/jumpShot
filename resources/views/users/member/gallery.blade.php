<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-images text-blue-500 mr-2"></i> Team Gallery
            </h2>
            <div class="text-sm text-blue-500">
                <i class="fas fa-camera mr-1"></i> {{ $gallery->count() }} Photos
            </div>
        </div>
    </x-slot>

    @push('styles')
    <style>
        [x-cloak] {
            display: none;
        }

        .gallery-image {
            transition: transform 0.3s ease-in-out;
        }

        .gallery-image:hover {
            transform: scale(1.05);
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 0.5rem;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .group:hover .overlay {
            opacity: 1;
        }
    </style>
    @endpush

    <div class="py-6">
        @if ($gallery->isEmpty())
            <div class="flex justify-center items-center h-64 bg-gray-300 rounded-lg mt-4">
                <p class="text-gray-400 text-lg">No images uploaded yet.</p>
            </div>
        @else
            <div 
                x-data="{
                    showModal: false,
                    imageUrl: '',
                    imageTitle: '',
                    imageDesc: '',
                    openModal(url, title = '', desc = '') {
                        this.imageUrl = url;
                        this.imageTitle = title;
                        this.imageDesc = desc;
                        this.showModal = true;
                    },
                    closeModal() {
                        this.showModal = false;
                    }
                }"
                @keydown.escape.window="closeModal()"
            >
                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-5 mt-5">
                    @foreach ($gallery as $item)
                        <div 
                            class="relative group bg-gray-800 rounded-lg shadow-lg overflow-hidden cursor-pointer"
                            @click="openModal('{{ asset('gallery/' . $item->image) }}', '{{ $item->title ?? '' }}', '{{ $item->description ?? '' }}')"
                        >
                            <img src="{{ asset('gallery/' . $item->image) }}" 
                                 alt="Gallery Image"
                                 class="gallery-image w-full h-48 object-cover">
                            <div class="overlay text-center text-white">
                                <h3 class="text-sm font-semibold truncate">{{ $item->title ?? 'Untitled' }}</h3>
                                <p class="text-xs line-clamp-1">{{ $item->description ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal -->
                <div 
                    x-cloak 
                    x-show="showModal" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" 
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" 
                    x-transition:leave-end="opacity-0 scale-90"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 px-4 py-6"
                >
                    <div class="relative w-full max-w-4xl mx-auto">
                        <!-- Close Button -->
                        <button @click="closeModal()"
                            class="absolute top-2 right-2 text-white text-3xl font-bold z-10 hover:scale-110 transition transform">
                            &times;
                        </button>

                        <!-- Full Image -->
                        <img :src="imageUrl" alt="Fullscreen Image"
                            class="w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">

                        <!-- Optional Title & Description -->
                        <div class="text-center mt-4 text-white">
                            <h2 class="text-lg font-semibold" x-text="imageTitle"></h2>
                            <p class="text-sm" x-text="imageDesc"></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
