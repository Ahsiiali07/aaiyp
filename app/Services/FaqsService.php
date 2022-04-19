<?php

namespace App\Services;
use App\Forms\IForm;
use App\Helpers\GeneralHelper;
use App\Models\Faqs;
use Dotenv\Exception\ValidationException;

class FaqsService extends BaseService
{
    /**
     * FaqsService constructor.
     */
    public function __construct() {
        $this->model = new Faqs();

        parent::__construct();
    }

    /**
     * @param null $paginate
     *
     * @return mixed
     */
    public function getAll( $paginate = null ) {
        if ( $paginate ) {
            return $this->model->paginate( $paginate );
        }

        return $this->model->get();
    }

    /**
     * @param IForm $form
     *
     * @return mixed
     * @throws ValidationException
     */
    public function store( IForm $form ) {
        $form->validate();
        if ( $form->video_url ) {
            $form->video_url = GeneralHelper::uploadImageManual( $form->video_url, 'video/faqs' );
        }
        $faqs = new Faq();
        $form->loadToModel( $faqs );
        $faqs->save();

        return $faqs;
    }

    /**
     * @param IForm $form
     * @param  $categoryId
     *
     * @return mixed
     * @throws ValidationException
     */
    public function update( IForm $form, $faqsId ) {
        $form->validate();
        if ( $form->video_url ) {
            $form->video_url = GeneralHelper::uploadImageManual( $form->video_url, 'video/faqs', ( ! $form->old_video_url ) ?: true, $form->old_video_url ?? null );
        } else {
            $form->video_url = $form->old_video_url;
        }
        $faqs = $this->findById( $faqsId );
        $form->loadToModel( $faqs);
        $faqs->update();

        return $faqs;
    }

    /**
     * @param $data
     * @param $faqsId
     *
     * @return mixed
     */
    public function updateDetails( $data, $faqsId ) {
        $faqs = $this->findById( $faqsId );
        $faqs->update( $data );

        return $faqs;
    }

    /**
     * @return array
     */
    public static function allWithIdAndName(): array
    {
        return Faqs::all()->pluck( 'faqs_title', 'id' )->all();
    }
}
