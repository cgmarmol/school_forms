<?php
namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user) {
        return [
          'id' => (int) $user->id,
          'first_name' => $user->person->first_name,
          'middle_name' => $user->person->middle_name,
          'last_name' => $user->person->last_name,
          'email' => $user->email,
          'created_at' => $user->created_at->format('M d, Y'),
        ];
    }
}
