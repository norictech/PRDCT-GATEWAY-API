<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthToken extends Model
{
    protected $table = 'oauth_tokens';
    protected $fillable = ['user_id', 'token_type', 'token', 'refresh_token', 'expires_in', 'client_ip', 'user_agent'];
}
