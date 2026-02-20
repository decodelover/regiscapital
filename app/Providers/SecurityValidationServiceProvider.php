<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class SecurityValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production', 'prod', 'live')) {
            $this->validateProductionSecurity();
        }
    }

    /**
     * Validate security configurations for production environment.
     *
     * @return void
     */
    protected function validateProductionSecurity()
    {
        $issues = [];

        // Check if debug is enabled in production
        if (config('app.debug') === true) {
            $issues[] = 'APP_DEBUG is enabled in production environment. This poses a security risk.';
        }

        // Check if app key is set
        if (empty(config('app.key'))) {
            $issues[] = 'APP_KEY is not set. This is required for encryption.';
        }

        // Check if default database credentials are being used
        if (config('database.default') === 'mysql') {
            $dbConfig = config('database.connections.mysql');
            if ($dbConfig['username'] === 'root' && empty($dbConfig['password'])) {
                $issues[] = 'Default database credentials detected. Change from root user with no password.';
            }
        }

        // Check environment consistency
        $appEnv = config('app.env');
        $appDebug = config('app.debug');
        
        if ($appDebug && !in_array($appEnv, ['local', 'testing', 'development'])) {
            $issues[] = "APP_DEBUG is true while APP_ENV is '{$appEnv}'. Debug should only be enabled in local/testing environments.";
        }

        // Check for secure session configuration
        if (config('session.secure') === false && $this->app->environment('production')) {
            $issues[] = 'Session cookies should be secure in production environment.';
        }

        // Check for HTTPS enforcement
        if (!config('app.force_https') && $this->app->environment('production')) {
            $issues[] = 'HTTPS should be enforced in production environment.';
        }

        // Log security issues
        if (!empty($issues)) {
            foreach ($issues as $issue) {
                Log::warning('Security Configuration Issue: ' . $issue);
            }
            
            // Also log to a dedicated security log file
            Log::channel('security')->warning('Security validation found issues', [
                'issues' => $issues,
                'environment' => $appEnv,
                'debug_enabled' => $appDebug,
                'timestamp' => now()->toISOString()
            ]);
        }
    }
}