<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Продукты';
    protected static ?string $modelLabel = 'продукт';
    protected static ?string $pluralModelLabel = 'Продукты';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->unique()
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\Select::make('category_id')
                    ->label('Категория')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->optionsLimit(10)
                    ->required(),
                Forms\Components\Hidden::make('slug'),
                Forms\Components\FileUpload::make('image')
                    ->label('Изображение')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('gallery')
                    ->label('Галлерея')
                    ->multiple()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('oldPrice')
                    ->label('Старая цена')
                    ->required()
                    ->numeric(),
                MarkdownEditor::make('description')
                    ->label('Описание')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->sortable(),
                Tables\Columns\TextColumn::make('oldPrice')
                    ->label('Старая цена')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Категория')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->optionsLimit(10),
                Filter::make('price')
                    ->form([
                        Grid::make([
                            'default' => 2,
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('price_min')
                                    ->label('Мин. цена')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('price_max')
                                    ->label('Макс. цена')
                                    ->numeric()
                                    ->default(Product::max('price')),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->whereBetween('price', [$data['price_min'], $data['price_max']]);
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
