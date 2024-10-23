<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        }

        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (! $user) {
            $user = (new CreateNewUser)->create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => '',
            ], socialUser: true);
            $user->provider = $provider;
            $user->provider_id = $socialUser->id;
            $user->save();

            // Upload social avatar
            if ($socialUser->getAvatar()) {
                $avatarUrl = $socialUser->getAvatar();
                $fileContents = file_get_contents($avatarUrl);

                if ($fileContents !== false) {
                    $tempFilePath = tempnam(sys_get_temp_dir(), 'avatar_');
                    file_put_contents($tempFilePath, $fileContents);
                    $avatar = new UploadedFile($tempFilePath, basename($avatarUrl));
                    $user->updateProfilePhoto($avatar);
                    unlink($tempFilePath);
                }
            }
        }

        Auth::login($user, true);

        return redirect('/dashboard');
    }
}
