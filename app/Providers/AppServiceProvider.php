<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $raw = (string) env('WHATSAPP_PHONE_NUMBER', '919899791945');
            $digits = preg_replace('/\D+/', '', $raw);
            $url = '';
            if ($digits) {
                $url = 'https://wa.me/'.$digits;
                $msg = trim((string) env('WHATSAPP_PREFILL_MESSAGE', "Hi, I'm interested in a property on your site."));
                if ($msg !== '') {
                    $url .= '?text='.rawurlencode($msg);
                }
            }
            $view->with('whatsapp_chat_url', $url);
        });
    }
}
