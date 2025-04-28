<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\User;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use App\Models\Role;
use App\Models\Lead;
class userService
{
    public function getList($inputs)
    {
        try {
            // Set default values for parameters
            $perPage = $inputs["perPage"] ?? ($inputs["params"] ?? 10);
            $sortOrder = $inputs['sortOrder'] ?? 'DESC';
            $sortBy = $inputs['sortBy'] ?? 'id';

            // Initialize query
            $users = User::with(['roles'])
                ->whereHas('roles', function ($q) {
                    $q->where('name', '!=', 'admin');
                })
                ->has('roles')
                ->orderBy($sortBy, $sortOrder);

            // Apply role filters
            if (!empty($inputs['filters']['role'])) {
                $users->whereHas('roles', function ($query) use ($inputs) {
                    $query->where('name', $inputs['filters']['role']);
                });
            }

            // Apply user type filter
            if (!empty($inputs['user_type'])) {
                $users->whereHas('roles', function ($query) use ($inputs) {
                    $query->where('name', $inputs['user_type']);
                });
            }

            // Apply search filter
            if (!empty($inputs["search"])) {
                $search = trim($inputs["search"]);
                $users->where('email', 'LIKE', '%' . $search . '%');
            }

            // Return paginated or all results based on perPage value
            return $perPage != 'all' ? $users->paginate($perPage) : $users->get();

        } catch (\Exception | RequestException $e) {
            Log::error('User fetch service failed', ['error' => $e->getMessage()]);
            throw $e;
        }

    }

    public function store($inputs)
    {
        try {
            $model = User::create($inputs);
            $model->assignRole($inputs['role']);
            return $model;
        } catch (\Exception  | RequestException $e) {
            Log::error('user store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($user)
    {
        return $user;
    }

    public function update($inputs, $id)
    {
        try {
            $user = User::find($id);
            if(empty($inputs['password'])) {
                unset($inputs['password']);
            }
            $user->update($inputs);
            $user->syncRoles($inputs['role']);
            return $user;
        } catch (\Exception  | RequestException $e) {
            Log::error('user update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function login($request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $credentials = $request->only('email', 'password');
            $remember = $request->boolean('remember');
            if (!$user || !Hash::check($request->password, $user->password)) {
                return ApiResponse::error('The provided credentials are incorrect.', 500);
            }
            if (Auth::attempt($credentials, $remember)) {
                $token = $user->createToken(env('APP_NAME'))->plainTextToken;
                $response = [
                    'user_detail' => $user,
                    'token' => $token,
                    'roles' => $user->roles,
                    'fields' => User::user_assigned_lead_fields($user->roles),
                ];
                return ApiResponse::success($response);
            }            
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success('User logout successfully');
    }

    public function forgetPassword($request)
    {
        $userDetail = User::where('email', $request->email)->first();
        if (!isset($userDetail)) {
            return ApiResponse::error('Email is not exist', 401);
        }
        // SendForgetPasswordJob::dispatch($userDetail);
        return ApiResponse::success('Please check you email, We have send you forget password link on you email');
    }

    public function resetPassword($request)
    {
        try {
            $userId = Crypt::decrypt($request->user_id);
            $user = User::find($userId);

            if (!isset($user)) {
                return ApiResponse::error('User is not exist.', 500);
            }
            $user->update([
                'password' => $request->password,
            ]);
            return ApiResponse::success('Password has been updated successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function socialHandler($userDetail)
    {
        try {
            if ($userDetail) {
                $user = User::updateOrCreate([
                    'email' => $userDetail['email'],
                ], [
                    'name' => $userDetail['name'],
                    'google_id' => $userDetail['google_id'],
                    'email_verified_at' => now(),
                    'password' => rand(100000, 999999),
                ]);

                $token = $user->createToken(env('APP_NAME'))->plainTextToken;
                $response = [
                    'user_detail' => $user,
                    'token' => $token,
                ];

                return ApiResponse::success($response);
            } else {
                return ApiResponse::error('Invalid Google token', 401);
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function createUser($request)
    {
        try {
            $userDetail = $request->all();
            // $user->assignRole($validatedData['role']);
            $createUser = User::create($userDetail);
            if ($createUser) {
                $message = 'User created successfully';
                return ApiResponse::success($message);
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function getUserProfile()
    {
        $userDetail = Auth::user();
        return ApiResponse::success($userDetail);
    }

    public function updateProfile($request)
    {
        $isUserExist = User::find($request->id);
        if(!isset($isUserExist)){
            return ApiResponse::error('User is not exist in our database', 500);
        }
        $isUserExist->update([
            'name' => $request->name,
            // 'email' => $request->email
        ]);
        return ApiResponse::success($isUserExist->refresh());
    }

    public function updateProfilePassword($request)
    {
        $isUserExist = User::find($request->id);
        if(!isset($isUserExist)){
            return ApiResponse::error('User is not exist in our database', 500);
        }
        $isUserExist->update([
            'password' => $request->new_password,
        ]);
        return ApiResponse::success($isUserExist->refresh());
    }

    public function dashboardData()
    {
        $adminUsers = User::role('admin')->pluck('id'); 
        $getAllUsersCount = User::where('id', '!=', $adminUsers[0])->get()->count();
        $getRoleCount = Role::count();
        $getLeadCount = Lead::count();
        $data = [
            'total_users' => $getAllUsersCount,
            'total_roles' => $getRoleCount,
            'total_leads' => $getLeadCount,
        ];
        return ApiResponse::success($data);
    }
}
