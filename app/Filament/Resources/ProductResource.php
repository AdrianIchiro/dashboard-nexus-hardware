<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama Produk')->required(),
                Textarea::make('description')->label('Deskripsi Produk')->required(),
                Select::make('category_id')
                ->label('Kategori')
                ->relationship('category', 'name')
                ->required(),
                TextInput::make('price')
                ->label('Harga')
                ->numeric()
                ->step(0.01)
                ->required()
                ->placeholder('Masukkan harga produk')
                ->rules(['regex:/^\d+(\.\d{1,2})?$/'])
                ->default(0.00),
                TextInput::make('stock_quantity')->required()->numeric()->label('jumlah stock')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nama Produk')
                ->searchable() // Kolom dapat dicari
                ->sortable(),  // Kolom dapat diurutkan

            Tables\Columns\TextColumn::make('category.name')
                ->label('Kategori')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('price')
                ->label('Harga')
                ->money('IDR', true) // Format angka menjadi mata uang (Rupiah)
                ->sortable(),

            Tables\Columns\TextColumn::make('stock_quantity')
                ->label('Jumlah Stok')
                ->sortable(),

            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi Produk')
                ->limit(50) // Batasi tampilan deskripsi hingga 50 karakter
                ->tooltip(fn ($record) => $record->description) // Tooltip menampilkan deskripsi penuh
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
