<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserRepository implements UserRepositoryInterface
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index(Request $request): ResourceCollection
    {
        $query = $this->userModel::with('roles');


        if ($request->has('sortParam')) {
            $sortParam = $request->input('sortParam');
            $direction = $request->input('sortDirection', 'asc');

            switch ($sortParam) {
                case 'first_name':
                    $query->orderBy('first_name', $direction);
                    break;

                case 'last_name':
                    $query->orderBy('last_name', $direction);
                    break;

                case 'email':
                    $query->orderBy('email', $direction);
                    break;

                case 'role':
                    $query->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                        ->orderBy('roles.name', $direction)
                        ->select('users.*');
                    break;

                default:
                    $query->orderBy($sortParam, $direction);
                    break;
            }
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(first_name) like ?', ["%" . strtolower($searchTerm) . "%"])
                    ->orWhereRaw('LOWER(last_name) like ?', ["%" . strtolower($searchTerm) . "%"])
                    ->orWhereRaw('LOWER(email) like ?', ["%" . strtolower($searchTerm) . "%"]);
            });
        }

        $users = $query->paginate(10);
        return UserResource::collection($users);
    }

    public function show(string $id): ?UserResource
    {
        return new UserResource($this->userModel::with('roles')->find($id));
    }
}
