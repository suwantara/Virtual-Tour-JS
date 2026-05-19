<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi User')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation) => $operation === 'create')
                            ->helperText(fn (string $operation) => $operation === 'edit' ? 'Kosongkan jika tidak ingin mengubah password.' : null)
                            ->maxLength(255),

                        Select::make('role')
                            ->label('Role')
                            ->options(collect(UserRole::cases())->mapWithKeys(
                                fn (UserRole $role) => [$role->value => $role->label()]
                            ))
                            ->required()
                            ->default(UserRole::Viewer->value),
                    ]),
            ]);
    }
}
