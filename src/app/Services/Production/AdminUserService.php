<?php namespace App\Services\Production;

use App\Repositories\AdminUserRepositoryInterface;
use App\Repositories\AdminPasswordResetRepositoryInterface;
use App\Services\AdminUserServiceInterface;

class AdminUserService extends AdminAuthenticatableService implements AdminUserServiceInterface
{

    /** @var string $resetEmailTitle */
    protected $resetEmailTitle = "Reset Password";

    /** @var string $resetEmailTemplate */
    protected $resetEmailTemplate = "legacy.emails.admin.reset_password";

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        AdminPasswordResetRepositoryInterface $adminPasswordResetRepository
    )
    {
        $this->authenticatableRepository = $adminUserRepository;
        $this->passwordResettableRepository = $adminPasswordResetRepository;
    }

    protected function getGuardName()
    {
        return "admins";
    }

}