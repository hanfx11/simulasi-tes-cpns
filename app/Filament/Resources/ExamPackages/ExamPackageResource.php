<?php

namespace App\Filament\Resources\ExamPackages;

use App\Filament\Resources\ExamPackages\Pages\CreateExamPackage;
use App\Filament\Resources\ExamPackages\Pages\EditExamPackage;
use App\Filament\Resources\ExamPackages\Pages\ListExamPackages;
use App\Filament\Resources\ExamPackages\Schemas\ExamPackageForm;
use App\Filament\Resources\ExamPackages\Tables\ExamPackagesTable;
use App\Models\ExamPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamPackageResource extends Resource
{
    protected static ?string $model = ExamPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ExamPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamPackagesTable::configure($table);
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
            'index' => ListExamPackages::route('/'),
            'create' => CreateExamPackage::route('/create'),
            'edit' => EditExamPackage::route('/{record}/edit'),
        ];
    }
}
