<?php

namespace App\Filament\Pages;

use App\Settings\KaidoSetting;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSetting extends SettingsPage
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = KaidoSetting::class;

    protected static ?string $navigationGroup = 'Settings';


    public static function getModelLabel(): string
    {
        return __('Site Settings');
    }

    
    public static function getNavigationLabel(): string
    {
        return __('Site Settings');
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Site Information'))->columns(1)->schema([
                    TextInput::make('site_name')
                        ->label(__('Site Name'))
                        ->required(),
                    Toggle::make('site_active')
                        ->label(__('Site Active')),
                    Toggle::make('registration_enabled')
                        ->label(__('Registration Enabled')),
                    Toggle::make('password_reset_enabled')
                        ->label(__('Password Reset Enabled')),
                    Toggle::make('sso_enabled')
                        ->label(__('SSO Enabled')),
                ]),
            ]);
    }
}
