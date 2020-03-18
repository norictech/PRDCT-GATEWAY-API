<?php

namespace App\Listeners;

use App\OauthToken;
use Carbon\Carbon;
use Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Passport\Events\AccessTokenCreated;

class RevokeOldTokens
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        /** delete previous token if maximum device reached */
        $active_token = OauthToken::where('user_id', $event->userId)->count();

        if ($active_token > get_max_token_each_user()) {
            OauthToken::where('user_id', $event->userId)
                        ->latest()
                            ->take('count')
                            ->skip(
                                get_max_token_each_user()
                            )
                            ->get()
                            ->each(function ($row) {
                                $row->delete();
                            });
        }

        DB::table('oauth_access_tokens')->where('revoked', 1)->delete();
        DB::table('oauth_refresh_tokens')->where('revoked', 1)->delete();
    }
}
