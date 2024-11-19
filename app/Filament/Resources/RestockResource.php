<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestockResource\Pages;
use App\Models\Restock;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RestockResource extends Resource
{
    protected static ?string $model = Restock::class;

    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->label('Supplier')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('Produk')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),
                DateTimePicker::make('restock_date')
                    ->label('Tanggal Restock')
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable(),
                TextColumn::make('restock_date')
                    ->label('Tanggal Restock')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([
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
            // Relasi tambahan jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestocks::route('/'),
            'create' => Pages\CreateRestock::route('/create'),
            'edit' => Pages\EditRestock::route('/{record}/edit'),
        ];
    }
}
