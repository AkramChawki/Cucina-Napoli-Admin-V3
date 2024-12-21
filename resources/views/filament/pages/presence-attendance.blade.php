<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informations de l'employé</h3>
                    <p class="text-gray-800 dark:text-gray-200">{{ $presence->employe->first_name }} {{ $presence->employe->last_name }}</p>
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
                    ][$presence->month] }} {{ $presence->year }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th class="px-2 py-1 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white">{{ $day }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <td class="px-2 py-1 border border-gray-200 dark:border-gray-700 text-center">
                                    @if(isset($presence->attendance_data[$day]))
                                        <span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset ring-gray-500/10"
                                            style="background-color: {{ $statusColors[$presence->attendance_data[$day]] }};">
                                            {{ $statusLabels[$presence->attendance_data[$day]] }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <h4 class="text-lg font-medium mb-2 text-gray-900 dark:text-white">Légende</h4>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($statusLabels as $status => $label)
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset ring-gray-500/10"
                                style="background-color: {{ $statusColors[$status] }};">
                                {{ $label }}
                            </span>
                            <span class="text-gray-800 dark:text-gray-200">{{ ucfirst($status) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>