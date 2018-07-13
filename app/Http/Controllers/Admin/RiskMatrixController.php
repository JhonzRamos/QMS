<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RiskConsequence;
use App\RiskExposure;
use App\RiskLikelihood;
use Illuminate\Http\Request;

class RiskMatrixController extends Controller {

	/**
	 * Index page
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index()
    {
		$consequence = RiskConsequence::all();
		$likelihood = RiskLikelihood::all();
		$rating = RiskExposure::all();

		return view('admin.riskmatrix.index', compact('consequence','likelihood','rating'));
	}

	public function store(Request $request)
	{
		return $request->all();

		return redirect()->route('admin'.'.risklikelihood.index');
	}

}