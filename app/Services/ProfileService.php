<?php
namespace App\Services;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ProfileService
{
    /**
     * Get a user by its slug.
     *
     * @param string $slug The slug of the user to retrieve.
     * @return \App\Models\User The user with the matching slug.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no user is found with the given slug.
     */
    public function getBySlug(string $slug): User
    {
        // Retrieve the user with the matching slug from the database.
        // If no user is found, throw a ModelNotFoundException.
        $user = User::with('profile')->where('slug', $slug)->firstOrFail();
        return $user;
    }
    public function createData(array $data){
        return Profile::create($data);
    }
    /**
     * Update a profile by its ID.
     *
     * @param int $id The ID of the profile to update.
     * @param array $data The data to update the profile with.
     * @return \Illuminate\Database\Eloquent\Model The updated profile.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the profile is not found.
     */
    public function updateData(string $slug, array $data)
    {
        // Find the profile by its ID
        $user = Profile::where("slug",$slug)->first();
        // Update the profile with the given data
        $user->update($data);
        // Return the updated profile
        return $user;
    }

}