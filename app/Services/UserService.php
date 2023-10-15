<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class UserService implements UserServiceInterface
{
    private User $userModel;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        User $userModel,
        UserRepositoryInterface $userRepository
    ) {
        $this->userModel = $userModel;
        $this->userRepository = $userRepository;
    }

    public function store(Request $request): Response
    {
        $user = $this->userModel::create([
            'id' => Str::uuid()->toString(),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->assignRole($request->input('role'));

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function register(Request $request): Response
    {
        $user = $this->userModel::create([
            'id' => Str::uuid()->toString(),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->assignRole($request->input('client'));

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function login(Request $request): Response
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = Auth::user();

        $jwt = $user->createToken('token')->plainTextToken;
        $cookie = cookie('jwt', $jwt, 60 * 24 * 365);

        return response([
            'user' => new UserResource($user->load('roles')),
            'jwt' => $jwt
        ])->withCookie($cookie);
    }

    public function user(Request $request): ?UserResource
    {
        $user = $request->user();
        return new UserResource($user->load('roles'));
    }

    public function logout(): Response
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function update(string $id, Request $request): Response
    {
        $user = $this->userRepository->show($id);
        $user->update($request->only('first_name', 'last_name', 'email', 'role'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id): Response
    {
        $success = $this->userModel::destroy($id);

        return response([
            'isSuccess' => boolval($success),
        ]);
    }
}
