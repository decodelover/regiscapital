<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DatabaseValidationService;

class ValidateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:validate {--fix : Automatically fix detected issues}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate database schema and fix common issues';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting database validation...');

        $result = DatabaseValidationService::validateAndFix();

        if ($result['status'] === 'healthy') {
            $this->info('✅ Database is healthy - no issues found!');
            return 0;
        }

        $this->warn('⚠️  Database issues detected:');
        foreach ($result['issues'] as $issue) {
            $this->line("  - {$issue}");
        }

        if ($this->option('fix') && !empty($result['fixes'])) {
            $this->info('🔧 Applied fixes:');
            foreach ($result['fixes'] as $fix) {
                $this->line("  ✓ {$fix}");
            }
        } elseif (!empty($result['issues'])) {
            $this->info('💡 Run with --fix option to automatically resolve issues');
        }

        return 0;
    }
}