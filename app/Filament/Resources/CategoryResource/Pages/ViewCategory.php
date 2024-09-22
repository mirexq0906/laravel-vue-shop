<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;


class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return "Просмотр категории";
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
