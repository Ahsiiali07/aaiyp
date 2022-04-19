<?php

namespace App\Services;

use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Interface IService
 * @package App\Services
 */
interface ISubscription {

    const PRIMARY = 'primary';

    const NO_SUBSCRIPTION = 'no subscription';
    const DEVELOPER_SUBSCRIPTION = 'developer plan';
    const SILVER_SUBSCRIPTION = 'silver plan';
    const GOLD_SUBSCRIPTION = 'gold plan';
    const PLATNIUM_SUBSCRIPTION = 'platinum plan';

    const STATUS_ACTIVE = 'active';
    const STATUS_PAST_DUE = 'past_due';
    const STATUS_UNPAID = 'unpaid';
    const STATUS_CANCELED = 'canceled';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_INCOMPLETE_EXPIRED = 'incomplete_expired';
    const STATUS_TRIALING = 'trialing';
    const STATUS_ALL = 'all';
    const STATUS_ENDED = 'ended';

    const CUSTOM_STATUS_INACTIVE = 'inactive';

}
