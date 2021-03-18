<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Story;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Collection;

class StoryPolicy
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
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function view(User $user, Story $story)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @param Project $project
     * @return mixed
     */
    public function create(User $user, Project $project)
    {
        return $user->projects->where('id', $project->id)->pluck('product_owner')->contains($user->id) ||
            $user->projects->where('id', $project->id)->pluck('project_master')->contains($user->id);
    }

    /**
     * Determine whether the user can  add stories to the active Sprint.
     *
     * @param \App\Models\User $user
     * @param Project $project
     * @return mixed
     */
    public function update_sprints(User $user, Project $project)
    {
        // TODO update this when #25 is implemented
        return $user->projects->where('id', $project->id)->pluck('project_master')->contains($user->id);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param Project $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $user->projects->where('id', $project->id)->pluck('product_owner')->contains($user->id) ||
            $user->projects->where('id', $project->id)->pluck('project_master')->contains($user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param Project $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $user->projects->where('id', $project->id)->pluck('product_owner')->contains($user->id) ||
            $user->projects->where('id', $project->id)->pluck('project_master')->contains($user->id);
    }

    /**
     * Determine whether the user can reject/accept the story.
     *
     * @param \App\Models\User $user
     * @param Story $story
     * @param Project $project
     * @return mixed
     */
    public function acceptReject(User $user, Story $story, Project $project)
    {
        return $user->projects->where('id', $project->id)->pluck('product_owner')->contains($user->id);
    }

    /**
     * Determine whether the story is in an active sprint.
     *
     * @param \App\Models\User $user
     * @param Story $story
     * @param Collection $sprint
     * @return mixed
     */
    public function inActiveSprint(User $user, Story $story, Collection $sprint)
    {
        return count($sprint) > 0 && $story->sprint_id === $sprint[0]->id;
    }

    /**
     * Determine whether the story has no past sprint dedicated.
     *
     * @param \App\Models\User $user
     * @param Story $story
     * @param Collection $sprint
     * @return mixed
     */
    public function inNoSprint(User $user, Story $story, Collection $sprint)
    {
        return is_null($story->sprint_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function restore(User $user, Story $story)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function forceDelete(User $user, Story $story)
    {
        //
    }
}
