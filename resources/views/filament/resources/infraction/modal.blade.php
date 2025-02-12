<div class="p-4">
    @if($imageUrl)
        <img 
            src="{{ $imageUrl }}" 
            alt="Photo de l'infraction"
            class="max-w-full h-auto rounded-lg"
        >
    @endif
</div>