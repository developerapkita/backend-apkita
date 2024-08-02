<?php
namespace App\Services;
use App\Models\UserToken;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class TokenService
{
    /**
     * Token expiration time in minutes
     *
     * @var int
     */
    protected $tokenExpirationTime = 60;

    /**
     * Generate a new token for a user
     *
     * @param int $id The user ID
     * @return string The generated token
     */
    public function generate($id)
    {
        // Get the total number of user tokens + 1
        $count = UserToken::count() + 1;
        // Generate a random string
        $stringRandom =  Str::random(40);
        // Create the token by concatenating the count and random string
        $token = $count."|".$stringRandom;
        // Calculate the expiration date
        $expiresAt = Carbon::now()->addMinutes($this->tokenExpirationTime);
        // Create a new user token model
        $userToken = new UserToken();
        // Set the user ID, token, and expiration date
        $userToken->user_id = $id;
        $userToken->token = $token;
        $userToken->expires_at = $expiresAt;
        // Save the user token to the database
        $userToken->save();
        // Return the generated token
        return $token;
    }
}