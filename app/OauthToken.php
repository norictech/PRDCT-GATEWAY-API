<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthToken extends Model
{
    protected $table = 'oauth_tokens';
    protected $fillable = ['user_id', 'token_type', 'token', 'remember_token', 'expires_in'];
}
