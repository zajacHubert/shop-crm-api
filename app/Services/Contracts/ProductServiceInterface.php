<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface ProductServiceInterface
{
    public function store(Request $request): Response;
    public function update(string $id, Request $request): Response;
    public function destroy(string $id): Response;
}
