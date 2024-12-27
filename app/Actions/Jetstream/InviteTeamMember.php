<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;

class InviteTeamMember implements InvitesTeamMembers
{
    /**
     * Invite a new team member to the given team.
     */
    public function invite(User $user, Team $team, string $email, ?string $role = null): void
    {
        $name = request()->name;
        $division = request()->division;

        Gate::forUser($user)->authorize('addTeamMember', $team);

        $this->validate($team, $email, $role);

        // InvitingTeamMember::dispatch($team, $email, $role);

        // $invitation = $team->teamInvitations()->create([
        //     'email' => $email,
        //     'role' => $role,
        // ]);

        // Mail::to($email)->send(new TeamInvitation($invitation));
        // $newTeamMember = Jetstream::findUserByEmailOrFail($email);

        $password = fake()->asciify('********');

        \DB::transaction(function () use ($name, $email, $role, $password, $division) {
            return tap(User::create([
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => $password,
                'division' => $division,
            ]), function (User $user) {
                // $user->ownedTeams()->save(Team::forceCreate([
                //     'user_id' => $user->id,
                //     'name' => explode(' ', $user->name, 2)[0]."'s Team",
                //     'personal_team' => true,
                // ]));
            });
        });

        $newTeamMember = Jetstream::findUserByEmailOrFail($email);

        AddingTeamMember::dispatch($team, $newTeamMember);

        $team->users()->attach(
            $newTeamMember, ['role' => $role]
        );

        TeamMemberAdded::dispatch($team, $newTeamMember);

        Mail::send([], [], function ($message) use ($email, $name, $role, $password) {
            $message->to($email)
                ->subject('Registrasi SILOG - Solo Technopark')
                ->html(
                    "<h1>Selamat datang $name</h1>
                    <p>Anda telah didaftarkan sebagai $role pada SILOG dengan password: <b>$password</b></p>
                    <p>Segera ganti password anda.</p>"
                );
        });
    }

    /**
     * Validate the invite member operation.
     */
    protected function validate(Team $team, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules($team), [
            'email.unique' => __('This user has already been invited to the team.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email)
        )->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for inviting a team member.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function rules(Team $team): array
    {
        return array_filter([
            'email' => [
                'required', 'email',
                Rule::unique(Jetstream::teamInvitationModel())->where(function (Builder $query) use ($team) {
                    $query->where('team_id', $team->id);
                }),
            ],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     */
    protected function ensureUserIsNotAlreadyOnTeam(Team $team, string $email): Closure
    {
        return function ($validator) use ($team, $email) {
            $validator->errors()->addIf(
                $team->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the team.')
            );
        };
    }
}
