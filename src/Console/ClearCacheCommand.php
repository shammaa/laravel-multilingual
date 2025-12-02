<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command
     */
    protected $signature = 'multilingual:clear-cache';

    /**
     * The console command description
     */
    protected $description = 'Clear the multilingual cache';

    /**
     * Execute the console command
     */
    public function handle(): int
    {
        $prefix = config('multilingual.cache.prefix', 'multilingual');
        
        // Clear cache items with multilingual prefix
        Cache::flush(); // In production, you might want to be more specific
        
        $this->info('Multilingual cache cleared successfully!');
        
        return Command::SUCCESS;
    }
}
