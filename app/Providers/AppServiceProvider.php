<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\AdminNotification;

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
        View::composer('Admin.*', function ($view) {
            if (Schema::hasTable('admin_notifications')) {
                $unreadCount = AdminNotification::where('is_read', false)->count();
                $adminNotifications = AdminNotification::orderBy('created_at', 'desc')->take(15)->get();
                $view->with('unreadCount', $unreadCount)->with('adminNotifications', $adminNotifications);
            }
        });
    }
}
