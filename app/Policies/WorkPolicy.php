<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Work;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param \App\Models\User $user
     * @param string $ability
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
     * @param \App\Models\User $user
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
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return mixed
     */
    public function view(User $user, Work $work)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user, Task $task)
    {
        return $user->working_on === $task->id && $task->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return mixed
     */
    public function update(User $user, Work $work)
    {
        return $work->user_id === $user->id;
    }


    /**
     * Can a user start working on some task
     */
    public function startWork(User $user, Task $task)
    {
        return $task->user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return mixed
     */
    public function delete(User $user, Work $work)
    {
        return $work->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return mixed
     */
    public function restore(User $user, Work $work)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Work $work
     * @return mixed
     */
    public function forceDelete(User $user, Work $work)
    {

    }
}
