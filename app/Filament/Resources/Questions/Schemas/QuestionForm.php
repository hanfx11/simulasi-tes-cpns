<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),
                Select::make('subcategory_id')
                    ->relationship('subcategory', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Textarea::make('question_text')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Textarea::make('explanation')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ])
                    ->required()
                    ->default('medium'),
                Select::make('score_type')
                    ->options([
                        'binary' => 'Binary - TWK/TIU',
                        'weighted' => 'Weighted - TKP',
                    ])
                    ->required()
                    ->live()
                    ->default('binary'),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required()
                    ->default('active'),
                Repeater::make('options')
                    ->relationship()
                    ->schema([
                        Select::make('option_label')
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                                'D' => 'D',
                                'E' => 'E',
                            ])
                            ->required(),
                        Textarea::make('option_text')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                        Select::make('is_correct')
                            ->label('Jawaban benar TWK/TIU')
                            ->options([
                                0 => 'Tidak',
                                1 => 'Ya',
                            ])
                            ->default(0),
                        TextInput::make('score')
                            ->label('Skor TKP')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5),
                    ])
                    ->defaultItems(5)
                    ->minItems(5)
                    ->maxItems(5)
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
