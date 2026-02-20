<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\View;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\TermsPrivacy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FacadesStorage::extend('sftp', function ($app, $config) {
            return new Filesystem(new SftpAdapter($config));
        });

        Paginator::useBootstrap();

        // Sharing settings with all view
        $settings = Settings::where('id', '1')->first();
        $terms =  TermsPrivacy::find(1);
        $moreset =  SettingsCont::find(1);

        $brandSourcePath = base_path('main logo for email.png');
        $brandRelativePath = 'branding/main-logo.png';
        $brandStoragePath = storage_path('app/public/' . $brandRelativePath);

        if (file_exists($brandSourcePath)) {
            $brandDir = dirname($brandStoragePath);
            if (!is_dir($brandDir)) {
                @mkdir($brandDir, 0755, true);
            }

            if (!file_exists($brandStoragePath) || @filemtime($brandSourcePath) > @filemtime($brandStoragePath)) {
                @copy($brandSourcePath, $brandStoragePath);
            }

            if ($settings) {
                // Force a single logo identity across the full project.
                $settings->logo = $brandRelativePath;
            }
        }

        $cacheBuster = (string) now()->format('YmdHis');

        View::share('settings', $settings);
        View::share('terms', $terms);
        View::share('moresettings', $moreset);
        View::share('mod', $settings ? $settings->modules : []);
        View::share('cacheBuster', $cacheBuster);
        View::share('brandLogoUrl', $settings ? asset('storage/app/public/' . $settings->logo) : asset('main logo for email.png'));
        View::share('brandLogoPath', file_exists($brandStoragePath) ? $brandStoragePath : $brandSourcePath);
    }
}
