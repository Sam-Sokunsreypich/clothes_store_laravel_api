<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('title')->required(),
                TextInput::make('price')->required()
                                        ->numeric()
                                        ->reactive()
                                        ->afterStateUpdated(function (callable $set, $state, $get){
                                            $discount = (float) $get('discount');
                                            $price = (float) $state;
                                            $discountAmount = $price * ($discount/100);
                                            $set('after_dis_price', $price - $discountAmount);
                                        }),
                TextInput::make('description')->required(),

                Select::make('discount')
                ->options([
                        '0' => '0%',
                        '10' => '10%',
                        '20' => '20%',
                        '30' => '30%',
                        '50' => '50%',
                        '70' => '70%',
                    ])
                    ->required()
                    -> reactive()
                    -> afterStateUpdated(function (callable $set, $state, $get){
                        $price = (float) $get('price');
                        $discount = (float) $state;
                        $discountAmount = $price * ($discount / 100);
                        $set('after_dis_price', $price - $discountAmount);
                    }),
    

                TextInput::make('stock')->required(),
                Select::make('store_category')
                    ->options([
                            'General' => 'General',
                            'One get One' => ' One get One',
                            'Clearence Sale' => 'Clearence Sale',
                        ])
                        ->required(),

                Select::make('user_category')
                    ->options([
                            'Man' => 'Man',
                            'Women' => 'Women',
                            'Boy' => 'Boy',
                            'Girl' => 'Girl',
                        ])
                    ->required(),

                TextInput::make('after_dis_price')->required()
                                                ->disabled() // prevent manual editing
                                                ->dehydrated(), // still save to DB,
                FileUpload::make('image')->disk('public')->directory('products')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id'),
                TextColumn::make('title'),
                TextColumn::make('price'),
                TextColumn::make('description'),
                TextColumn::make('discount'),
                TextColumn::make('stock'),
                TextColumn::make('store_category'),
                TextColumn::make('user_category'),
                TextColumn::make('after_dis_price'),
                ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . ltrim($record->image, '/')) : null)
                    ->size(60)
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
