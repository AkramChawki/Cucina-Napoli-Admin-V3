<div class="flex items-center justify-end px-4 py-2">
    <select 
        class="text-sm border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500" 
        onchange="window.location.href='?restaurant=' + this.value"
    >
        <option value="">Tous les restaurants</option>
        @foreach($restaurants as $restaurant)
            <option value="{{ $restaurant }}" @selected(request()->restaurant == $restaurant)>
                {{ $restaurant }}
            </option>
        @endforeach
    </select>
</div>