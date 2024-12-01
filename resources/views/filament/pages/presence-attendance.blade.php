<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-medium">Informations de l'employé</h3>
                    <p>{{ $presence->employe->first_name }} {{ $presence->employe->last_name }}</p>
                    <p>Mois: {{ [
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
                                <th class="px-2 py-1 border">{{ $day }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <td class="px-2 py-1 border text-center">
                                    @if(isset($presence->attendance_data[$day]))
                                        <span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-medium"
                                            style="background-color: {{ $statusColors[$presence->attendance_data[$day]] }};">
                                            {{ $statusLabels[$presence->attendance_data[$day]] }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <h4 class="text-lg font-medium mb-2">Légende</h4>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($statusLabels as $status => $label)
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-medium"
                                style="background-color: {{ $statusColors[$status] }};">
                                {{ $label }}
                            </span>
                            <span>{{ ucfirst($status) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>