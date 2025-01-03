<div class="flex items-center justify-end px-4 py-2">
    <select 
        class="fi-select-input dark:bg-gray-900 dark:text-white dark:border-gray-700 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500" 
        onchange="
            const currentUrl = new URL(window.location);
            const tableFilters = currentUrl.searchParams.get('tableFilters[month][value]');
            let newUrl = '?restaurant=' + this.value;
            if (tableFilters) {
                newUrl += '&tableFilters[month][value]=' + tableFilters;
            }
            window.location.href = newUrl;
        "
    >
        <option value="">Tous les restaurants</option>
        @foreach($restaurants as $restaurant)
            <option value="{{ $restaurant }}" {{ request()->query('restaurant') == $restaurant ? 'selected' : '' }}>
                {{ $restaurant }}
            </option>
        @endforeach
    </select>
</div>