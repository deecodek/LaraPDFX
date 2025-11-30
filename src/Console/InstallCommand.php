<?php

namespace Deecodek\LaraPDFX\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larapdfx:install 
                            {--force : Overwrite existing configuration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure LaraPDFX package';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing LaraPDFX...');
        $this->newLine();

        // Publish configuration
        $this->info('Publishing configuration...');
        $this->call('vendor:publish', [
            '--provider' => 'Deecodek\LaraPDFX\LaraPDFXServiceProvider',
            '--tag' => 'larapdfx-config',
            '--force' => $this->option('force'),
        ]);

        $this->newLine();
        $this->info('LaraPDFX installed successfully!');
        $this->newLine();

        // Show help
        $this->line('<fg=yellow>Next steps:</>');
        $this->line('1. Make sure Chrome/Chromium is installed on your system');
        $this->line('2. Configure your settings in config/larapdfx.php');
        $this->line('3. Test installation with: php artisan larapdfx:test');
        $this->newLine();

        // Check for Chrome
        $this->checkChrome();

        return Command::SUCCESS;
    }

    /**
     * Check if Chrome/Chromium is installed.
     */
    protected function checkChrome(): void
    {
        $chromePaths = [
            '/usr/bin/google-chrome',
            '/usr/bin/chromium',
            '/usr/bin/chromium-browser',
            '/snap/bin/chromium',
            '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
            'C:\Program Files\Google\Chrome\Application\chrome.exe',
            'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe',
        ];

        $found = false;
        foreach ($chromePaths as $path) {
            if (file_exists($path)) {
                $this->info("✓ Chrome found at: {$path}");
                $found = true;
                break;
            }
        }

        if (! $found) {
            $this->warn('⚠ Chrome/Chromium not found in default locations.');
            $this->line('  Please install Chrome or set the path in config/larapdfx.php');
            $this->newLine();
            $this->line('  Ubuntu/Debian: sudo apt install chromium-browser');
            $this->line('  Alpine: apk add chromium');
            $this->line('  macOS: brew install --cask google-chrome');
        }
    }
}
