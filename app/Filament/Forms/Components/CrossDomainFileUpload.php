<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;

class CrossDomainFileUpload extends FileUpload
{
    protected function getDefaultImageUrl(?string $state = null): ?string
    {
        if (!$state) {
            return null;
        }

        return config('app.restaurant_url') . '/public/storage/' . $state;
    }

    protected function getImageUrl(?string $state = null): ?string
    {
        return $this->evaluate($this->getDefaultImageUrl($state));
    }
}