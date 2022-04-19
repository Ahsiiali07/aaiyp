<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Forms\IForm;
use App\Helpers\Settings;
use App\Models\Feeds;
use App\Models\FeedReport;
use EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use willvincent\Rateable\Rating;

/**
 * Class ReportedPostService
 * @package App\Services
 */
class ReportedFeedService extends BaseService {

    /**
     * ReportedPostService constructor.
     */
    public function __construct() {
        $this->model = new FeedReport();

        parent::__construct();
    }


    /**
     * @param null $request
     * @param false $paginated
     *
     * @return mixed
     */
    public function getReports( $request = null, $paginated = false ) {
        $items = EloquentBuilder::to( FeedReport::class, $request )
                                   ->orderBy( 'created_at', 'desc' );
        if ( $paginated ) {
            return $items->paginate(
                Settings::getPageSize()
            );
        }

        return $items->get();

    }
}
