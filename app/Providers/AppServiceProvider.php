<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define("manageCategories", function (User $user) {
            //TODO essa parte está conferindo o cargo diretamente.
            //no arquivo custom.php tenho métodos que conferem se o usuário é admin ou moderator
            //o que eu posso fazer aqui é o seguinte:
            //
            //como os métodos retornam um bool, posso conferir se o retorno é verdadeiro E
            //se o papel está definido corretamente também
            return $user->role === "admin";
        });

        Gate::define("manageProducts", function (User $user) {
            return $user->role === "moderator" || $user->role === "admin";
        });
    }
}
