<?php

/**
 * This class is for managing ratings given to user
 * 
 * 
 * @author NGP <corporate.ngp@gmail.com>
 * @package Api
 */

namespace Modules\Api\Http\Controllers;

use \Modules\Api\Repositories\RatingRepository as RatingRepo,    
    App\Libraries\ApiResponse,
    Validator,
    Input;

class RatingController extends Controller {
    
    /**
     * The RatingRepository instance.
     *
     * @var Modules\Api\Repositories\RatingRepository $ratingRepo
     */    
    private $ratingRepo;
        
    
    /**
     * Create a new RatingController instance.     
     * @param  Modules\Api\Repositories\RatingRepository $ratingRepo
     *                 
     * @return void
     */
    public function __construct(RatingRepository $ratingRepo) {
        parent::__construct();
        $this->ratingRepo = $ratingRepo;       
    }
    
    /**
     * List all the data
     * 
     * @return view
     */
    public function index() {
        return view('api::index');
    }
    
    /**
     * Get all airports list with their name and city
     * @return object airports
     */
    public function create() {
        
    }
    
    public function showByTravel(){
       
    }
    
    public function showByUser(){
        
    }
    
    public function averageRatings(){
       
    }
}