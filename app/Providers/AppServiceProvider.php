<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('lineClamp', function ($text, $lines = 3) {
            $words = explode(' ', $text);
            $lineLength = 50;
            $clamped = '';
            $currentLine = 0;
            
            foreach ($words as $word) {
                if (strlen($clamped) + strlen($word) > $lineLength) {
                    $currentLine++;
                    if ($currentLine >= $lines) {
                        $clamped = rtrim($clamped) . '...';
                        break;
                    }
                    $clamped .= "\n" . $word . ' ';
                } else {
                    $clamped .= $word . ' ';
                }
            }
            
            return rtrim($clamped);
        });
    }
}
