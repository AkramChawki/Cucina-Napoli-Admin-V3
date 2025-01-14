@php
    $record = $getRecord();
    $baseUrl = 'https://restaurant.cucinanapoli.com/storage/';
@endphp

@if($record->images && count($record->images) > 0)
    <div class="flex -space-x-2 overflow-hidden">
        @foreach(array_slice($record->images, 0, 3) as $index => $imagePath)
            <img
                src="{{ $baseUrl . $imagePath }}"
                class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover"
                alt="Photo {{ $index + 1 }}"
            >
        @endforeach
        
        @if(count($record->images) > 3)
            <div class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ring-2 ring-white">
                <span class="text-xs font-medium text-gray-500">+{{ count($record->images) - 3 }}</span>
            </div>
        @endif
    </div>
@else
    <span class="text-gray-400 text-sm">Aucune photo</span>
@endif