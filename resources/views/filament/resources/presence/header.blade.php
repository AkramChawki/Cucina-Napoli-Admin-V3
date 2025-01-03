<div class="flex items-center justify-end px-4 py-2">
    <select 
        class="fi-select-input dark:bg-gray-900 dark:text-white dark:border-gray-700 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500" 
        onchange="window.location.search = '?restaurant=' + encodeURIComponent(this.value)"
    >
        <option value="">Tous les restaurants</option>
        @foreach($restaurants as $restaurant)
            <option value="{{ $restaurant }}" {{ request()->query('restaurant') == $restaurant ? 'selected' : '' }}>
                {{ $restaurant }}
            </option>
        @endforeach
    </select>
</div>