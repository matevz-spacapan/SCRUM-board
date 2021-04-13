<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SprintPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @param Project $project
     * @return mixed
     */
    public function viewAny(User $user, Project $project)
    {
        return $user->projects->contains($project) || $project->project_master === $user->id ||
            $project->product_owner === $user->id;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function view(User $user, Sprint $sprint)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user, Project $project)
    {
        return $project->project_master === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Sprint $sprint
     * @return mixed
     */
    public function update(User $user, Sprint $sprint)
    {
        return $sprint->project->project_master === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function delete(User $user, Sprint $sprint)
    {
        return $sprint->project->project_master === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function restore(User $user, Sprint $sprint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function forceDelete(User $user, Sprint $sprint)
    {
        //
    }
}
