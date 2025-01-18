<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informations de consommation</h3>
                    <p class="text-gray-800 dark:text-gray-200">Restaurant: {{ $record->restaurant->name }}</p>
                    <p class="text-gray-800 dark:text-gray-200">Mois: {{ [
                        1 => 'Janvier',
                        2 => 'Février',
                        3 => 'Mars',
                        4 => 'Avril',
                        5 => 'Mai',
                        6 => 'Juin',
                        7 => 'Juillet',
                        8 => 'Août',
                        9 => 'Septembre',
                        10 => 'Octobre',
                        11 => 'Novembre',
                        12 => 'Décembre',
                    ][$record->month] }} {{ $record->year }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white text-left">Produit</th>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th class="px-2 py-1 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">{{ $day }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-2 border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="{{ $product->designation }}" 
                                             class="h-8 w-8 object-cover rounded-md mr-2">
                                        <span class="text-gray-900 dark:text-white">{{ $product->designation }}</span>
                                    </div>
                                </td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <td class="px-2 py-1 border border-gray-200 dark:border-gray-700 text-center">
                                        @if(isset($consumptionData[$product->id]))
                                            @php
                                                $dayData = $consumptionData[$product->id]->firstWhere('day', $day);
                                            @endphp
                                            @if($dayData)
                                                <span class="text-gray-900 dark:text-white">
                                                    {{ number_format($dayData->value, 2) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-600">-</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400 dark:text-gray-600">-</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>