<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use Illuminate\Auth\Notifications\ResetPassword;




class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return 'http://127.0.0.1:8000/reset-password?token='.$token;
        });

        // การกำหนดสิทธิ์ในการedit and delete
        
        // Gate::define('edit-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });
        
        // Gate::define('delete-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });
        
    }
}
