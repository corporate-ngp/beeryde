<?php
/**
 * The repository class for managing faq specific actions.
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>

 
 */

namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Faq;
use Modules\Admin\Models\FaqCategory;
use Exception;
use Route;
use Log;
use Cache;

class FaqRepository extends BaseRepository
{

    /**
     * Create a new FaqRepository instance.
     *
     * @param  Modules\Admin\Models\Faq $model
     * @return void
     */
    public function __construct(Faq $model)
    {
        $this->model = $model;
    }

    /**
     * Get a listing of the resource.
     *
     * @return Response
     */
    public function data($params = [])
    {
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        //Cache::tags not suppport with files and Database
        $response = Cache::tags(FaqCategory::table(), Faq::table())->remember($cacheKey, $this->ttlCache, function() {
            return Faq::with('FaqCategory')->orderBy('faq_category_id')->get();
        });

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Form data posted from ajax $inputs
     * @return $result array with status and message elements
     */
    public function create($inputs)
    {
        try {
            $faq = new $this->model;
            $allColumns = $faq->getTableColumns($faq->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $faq->$key = $value;
                }
            }

            $faqCategory = FaqCategory::find($inputs['faq_category_id']);
            $faq->faqCategory()->associate($faqCategory);

            $save = $faq->save();

            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.added', ['name' => 'FAQ']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-added', ['name' => 'FAQ']);
            }

            return $response;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-added', ['name' => 'FAQ']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-added', ['name' => 'FAQ']), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

    /**
     * Update an FAQ.
     *
     * @param  Form data posted from ajax $inputs, Modules\Admin\Models\Faq $faq
     * @return $result array with status and message elements
     */
    public function update($inputs, $faq)
    {
        try {

            foreach ($inputs as $key => $value) {
                if (isset($faq->$key)) {
                    $faq->$key = $value;
                }
            }

            $faqCategory = FaqCategory::find($inputs['faq_category_id']);
            $faq->faqCategory()->associate($faqCategory);

            $save = $faq->save();

            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.updated', ['name' => 'FAQ']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-updated', ['name' => 'FAQ']);
            }

            return $response;
        } catch (Exception $e) {

            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-updated', ['name' => 'FAQ']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error("FAQ could not be updated.", ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }
}
