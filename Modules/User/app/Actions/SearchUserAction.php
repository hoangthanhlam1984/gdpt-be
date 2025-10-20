<?php

namespace Modules\User\Actions;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchUserAction
{
    /**
     * Execute the search
     *
     * @param array<string, mixed> $filters
     */
    public function execute(array $filters = []): LengthAwarePaginator
    {
        $query = User::query();

        if (isset($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }
        if (isset($filters['email'])) {
            $query->where('email', 'LIKE', "%{$filters['email']}%");
        }
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate();
    }
}
