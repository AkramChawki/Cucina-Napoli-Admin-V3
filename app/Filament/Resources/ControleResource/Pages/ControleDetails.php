<?php

namespace App\Filament\Resources\ControleResource\Pages;

use App\Filament\Resources\ControleResource;
use App\Models\Controle;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ControleDetails extends Page
{
    use InteractsWithRecord;

    // public $record;
    protected static string $resource = ControleResource::class;

    protected static string $view = 'filament.resources.Controle-resource.pages.Controle-details';

    public function mount(int | string $record): void
    {
        $this->record = Controle::find($record);
    }
}
