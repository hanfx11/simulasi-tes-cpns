<?php

namespace App\Filament\Resources\QuestionOptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('question_id')
                    ->relationship('question', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('option_label')
                    ->required()
                    ->maxLength(1),
                Textarea::make('option_text')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_correct'),
                TextInput::make('score')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),
            ]);
    }
}
