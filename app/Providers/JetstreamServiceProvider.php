<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        // Jetstream::role('admin', 'Administrator', [
        //     'create',
        //     'read',
        //     'update',
        //     'delete',
        // ])->description('Administrator users can perform any action.');

        // Jetstream::role('editor', 'Editor', [
        //     'read',
        //     'create',
        //     'update',
        // ])->description('Editor users have the ability to read, create, and update.');

        Jetstream::role('pengaju', 'Pengaju', [
            'rfq:read',
            'rfq:create',
        ])->description('Pengaju users can read and create RFQs.');

        Jetstream::role('pimpinan-gudang', 'pimpinan-gudang', [
            'rfq:read',
            'rfq:update',
        ])->description('pimpinan-gudang users can read and update RFQs.');

        Jetstream::role('admin-gudang', 'admin-gudang', [
            'rfq:read',
            'rfq:create',
            'rfq:update',
            'rfq:delete',
            'po:read',
            'po:create',
            'po:update',
            'po:delete',
            'payment:read',
            'payment:create',
            'payment:update',
            'payment:delete',
        ])->description('admin-gudang users can perform any action on RFQs, POs, and Payments.');

        Jetstream::role('purchasing', 'purchasing', [
            'po:read',
            'po:create',
            'po:update',
        ])->description('Purchasing users can read, create, and update POs.');

        Jetstream::role('pejabat-teknis', 'Pejabat Teknis', [
            'rfq:read',
            'rfq:update',
            'po:read',
            'po:update',
        ])->description('Pejabat Teknis users can read and update RFQs and POs.');

        Jetstream::role('pimpinan', 'Pimpinan', [
            'rfq:read',
            'rfq:create',
            'rfq:update',
            'rfq:delete',
            'po:read',
            'po:create',
            'po:update',
            'po:delete',
            'payment:read',
            'payment:create',
            'payment:update',
            'payment:delete',
        ])->description('Pimpinan users can perform any action on RFQs, POs, and Payments.');

        Jetstream::role('keuangan', 'Keuangan', [
            'payment:read',
            'payment:update',
        ])->description('Keuangan users can read and update Payments.');
    }
}
