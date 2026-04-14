<?php

namespace App\Policies;

use App\Models\Posting;
use App\Models\User;

class PostingPolicy
{
    public function view(User $user, Posting $posting): bool
    {
        return $user->id === $posting->user_id || 
               ($user->hasRole('PIMPINAN') && $user->wilayah_id === $posting->wilayah_id) ||
               $user->hasRole('ADMIN');
    }

    public function update(User $user, Posting $posting): bool
    {
        return $user->id === $posting->user_id && in_array($posting->status, ['DRAFT', 'REJECTED']);
    }

    public function delete(User $user, Posting $posting): bool
    {
        return $user->id === $posting->user_id && in_array($posting->status, ['DRAFT', 'REJECTED']);
    }
}
