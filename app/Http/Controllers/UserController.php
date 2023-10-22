<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService,  UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index(): ResourceCollection
    {
        return $this->userRepository->index();
    }

    public function show(string $id): ?UserResource
    {
        return $this->userRepository->show($id);
    }

    public function register(UserRegisterRequest $request): Response
    {
        return $this->userService->register($request);
    }

    public function login(UserLoginRequest $request): Response
    {
        return $this->userService->login($request);
    }

    public function logout(): Response
    {
        return $this->userService->logout();
    }

    public function user(Request $request): ?UserResource
    {
        return $this->userService->user($request);
    }

    public function store(UserStoreRequest $request): ?Response
    {
        return $this->userService->store($request);
    }

    public function update(string $id, UserUpdateRequest $request): Response
    {
        return $this->userService->update($id, $request);
    }

    public function destroy(string $id): Response
    {
        return $this->userService->destroy($id);
    }
}
