<div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
    @foreach($images as $imageUrl)
        <div class="relative group">
            <img 
                src="{{ $imageUrl }}" 
                alt="Photo du produit" 
                class="rounded-lg shadow-lg w-full h-auto object-cover"
            >
            <a 
                href="{{ $imageUrl }}" 
                target="_blank" 
                class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity"
            >
                <span class="text-white opacity-0 group-hover:opacity-100">
                    Voir en plein écran
                </span>
            </a>
        </div>
    @endforeach
</div>