<?php

namespace App\Http\Middleware;

use Closure; // <-- JANGAN LUPA TAMBAHKAN INI
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Auth;

class RedirectToProperPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // Perbaiki baris di bawah ini
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentPanel = Filament::getCurrentPanel()?->getId();

            if ($user->hasRole('admin') && $currentPanel !== 'admin') {
                return redirect()->to(Dashboard::getUrl(panel: 'admin'));
            }

            if ($user->hasRole('technician') && $currentPanel !== 'technician') {
                return redirect()->to(Dashboard::getUrl(panel: 'technician'));
            }

            if ($user->hasRole('user') && $currentPanel !== 'user') {
                return redirect()->to(Dashboard::getUrl(panel: 'user'));
            }
        }

        // Baris ini sekarang akan berfungsi dengan benar
        return $next($request);
    }
}