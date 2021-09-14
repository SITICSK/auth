<?php

namespace Sitic\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Sitic\Auth\Http\Resources\UserResource;

/**
 * @group Users API
 *
 * APIs for User
 */
class UserController extends Controller
{
    /**
     * Index Users
     *
     * This endpoint lets you list a users.
     * @authenticated
     * @queryParam perPage integer List users per page. Example: 30
     *
     */
    public function index(Request $request) {
        $this->validate($request, [
            'perPage' => 'integer'
        ]);

        try {
            return UserResource::collection(User::paginate($request->perPage ?? config('settings.perPage', 10)));
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Store User
     *
     * This endpoint lets you create a new user.
     * @authenticated
     * @bodyParam email email required User email. Example: test@sitic.sk
     * @bodyParam name string required User name. Example: Test Name
     * @bodyParam password string required User password. Example: 12345678
     * @bodyParam password_confirmation string required User password confirmed. Example: 12345678
     *
     */
    public function store(Request $request) {
        $this->validate($request, [
            'email' => 'email|required|max:255|min:3|unique:users,email',
            'password' => 'min:8|max:255|required|confirmed',
            'name' => 'min:3|max:255|required',
        ]);

        $fillable = $request->only(['email', 'password', 'name']);
        $fillable['password'] = app('hash')->make($request->password);

        try {
            $model = User::create($fillable);
            return response()->json(['status' => 'success', 'data' => new UserResource($model)]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Show User
     *
     * This endpoint lets you show a user.
     * @authenticated
     * @urlParam id string required The user UUID. Example: cfad9919-7640-4e55-9bdf-78ffc5052249
     * @queryParam with string Get relations. Example: roles
     *
     */
    public function show(Request $request, $id) {
        try {
            $request->with ? $with = explode(',', $request->with) : $with = [];
            $model = User::findOrFail($id);
            foreach ($with as $relation) {
                if ($model->$relation) {
                    $model = $model->with($relation);
                }
            }
            return response()->json(['status' => 'success', 'data' => new UserResource($model->first())]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Update User
     *
     * This endpoint lets you update a user.
     * @authenticated
     * @urlParam id string required The user UUID. Example: cfad9919-7640-4e55-9bdf-78ffc5052249
     * @bodyParam name string User name. Example: Test Updated
     * @bodyParam email string User email. Example: text.updated@example.net
     * @bodyParam password string User password. Example: 123456789
     * @bodyParam password_confirmation string User password. Example: 123456789
     *
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'string|max:255|min:3',
            'email' => 'email|min:3|max:1000|unique:users,email',
            'password' => 'string|min:8|max:255|confirmed'
        ]);

        $fillable = $request->only(['name', 'email', 'password']);
        if (isset($fillable['password'])) {
            $fillable['password'] = app('hash')->make($request->password);
        }

        try {
            $model = User::findOrFail($id);
            if (!empty($fillable)) {
                $model->update($fillable);
            }
            return response()->json(['status' => 'success', 'data' => new UserResource($model)]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Destroy User
     *
     * This endpoint lets you destroy a user.
     * @authenticated
     * @urlParam id string required The user UUID. Example: 50ece335-3f25-4f6c-bfab-f076fa7ad33a
     *
     */
    public function destroy(Request $request, $id) {
        try {
            $model = User::findOrFail($id);
            $model->delete($model);
            return response()->json(['status' => 'success', 'data' => new UserResource($model)]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Restore User
     *
     * This endpoint lets you restore deleted user.
     * @authenticated
     * @urlParam id string required The user UUID. Example: 50ece335-3f25-4f6c-bfab-f076fa7ad33a
     *
     */
    public function restore(Request $request, $id) {
        try {
            $model = User::withTrashed()->findOrFail($id);
            if ($model) $model->restore();
            return response()->json(['status' => 'success', 'data' => new UserResource($model)]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }

    /**
     * Force Delete User
     *
     * This endpoint lets you force delete deleted user.
     * @authenticated
     * @urlParam id string required The user UUID. Example: 50ece335-3f25-4f6c-bfab-f076fa7ad33a
     *
     */
    public function forceDelete(Request $request, $id) {
        try {
            $model = User::withTrashed()->findOrFail($id);
            if ($model) $model->forceDelete();
            return response()->json(['status' => 'success', 'data' => new UserResource($model)]);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()]);
        }
    }
}
