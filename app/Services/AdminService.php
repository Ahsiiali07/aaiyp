<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Models\Adminfeed;

/**
 * Class CategoryService
 * @package App\Services
 */
class AdminService extends BaseService
{

    /**
     * TestimonialsService constructor.
     */
    public function __construct()
    {
        $this->model = new AdminFeed();

        parent::__construct();
    }
}
