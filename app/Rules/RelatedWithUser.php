<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class RelatedWithUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $relationName, $userId = null)
    {
        $this->relationName = $relationName;
        if(is_null($userId)){
            $this->user = \request()->user();
        } else{
            $this->user = User::getByUserAndId(\request()->user(), $userId);
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(is_array($value)) {
            $entities = $this->user->{$this->relationName}()
                ->whereIn('id', $value)
                ->select('id')
                ->pluck('id');
            $value = collect($value);
            $diff = $entities->diff($value);
            return $diff->isEmpty();
        } else {
            $entity = $this->user->{$this->relationName}()
                ->find($value);
            return !is_null($entity);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute should be related with current user.';
    }
}
