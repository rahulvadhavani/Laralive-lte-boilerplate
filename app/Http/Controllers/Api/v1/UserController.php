<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{ChangePasswordRequest, UpdateProfileRequest};
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{Hash, Auth, File};

class UserController extends Controller
{
    public function userProfile()
    {
        try {
            $user = Auth::user();
            $user = User::where('id', $user->id)->first()->makeHidden(['updated_at', 'role']);
            $user->status = User::STATUSARR[$user->status];
            return response()->json(['status' => true, 'message' => 'data fetched successfully!', 'data' => $user]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong!', 'errorMessage' => $e->getMessage()]);
        }
    }

    public function ChangePassword(ChangePasswordRequest $request)
    {
        try {
            $validData = $request->validated();
            $userId = Auth::user()->id;
            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                return error('Invalid old password.');
            } else if ((Hash::check(request('password'), Auth::user()->password)) == true) {
                return error('Please enter a password which is not similar then current password.');
            } else {
                User::where('id', $userId)->update(['password' => bcrypt($validData['password'])]);
                return success('Password updated successfully.');
            }
        } catch (Exception $err) {
            return error('Something went wrong', $err->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return success('Successfully logout');
        } catch (Exception $e) {
            return error('Something went wrong', $e->getMessage());
        }
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $validData = $request->validated();
            $userId = Auth::user()->id;
            $user = User::userRole(true)->where('id', $userId)->first();
            if ($user == null) {
                return error('User not found.');
            }
            if (isset($validData['image']) && $validData['image'] != '') {
                $validData['image'] = imageUploader($request->image,'uploads/users');
                $oldImg = $user->getRawOriginal('image');
                if (File::exists(public_path($oldImg))) {
                    File::delete(public_path($oldImg));
                }
            }
            $user->update($validData);
            return success('Profile updated successfully.');
        } catch (Exception $err) {
            return error('Something went wrong', $err->getMessage());
        }
    }
}
