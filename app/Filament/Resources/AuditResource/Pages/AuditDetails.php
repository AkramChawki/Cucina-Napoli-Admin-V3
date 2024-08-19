<?php

namespace App\Filament\Resources\AuditResource\Pages;

use App\Filament\Resources\AuditResource;
use App\Models\Audit;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class AuditDetails extends Page
{
    use InteractsWithRecord;

    protected static string $resource = AuditResource::class;

    protected static string $view = 'filament.resources.audit-resource.pages.audit-details';

    public function mount(int | string $record): void
    {
        $this->record = Audit::find($record);
    }
}
