<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\RiskLikelihood;
use App\Http\Requests\CreateRiskLikelihoodRequest;
use App\Http\Requests\UpdateRiskLikelihoodRequest;
use Illuminate\Http\Request;



class RiskLikelihoodController extends Controller {

	/**
	 * Display a listing of risklikelihood
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $risklikelihood = RiskLikelihood::all();

		return view('admin.risklikelihood.index', compact('risklikelihood'));
	}

	/**
	 * Show the form for creating a new risklikelihood
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.risklikelihood.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$risklikelihood = RiskLikelihood::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.risklikelihood.show', compact('risklikelihood', 'view' ));
	}


	/**
	 * Store a newly created risklikelihood in storage.
	 *
     * @param CreateRiskLikelihoodRequest|Request $request
	 */
	public function store(CreateRiskLikelihoodRequest $request)
	{
	    
		RiskLikelihood::create($request->all());

		return redirect()->route('admin'.'.risklikelihood.index');
	}

	/**
	 * Show the form for editing the specified risklikelihood.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$risklikelihood = RiskLikelihood::find(decrypt($id));
	    
	    
		return view('admin.risklikelihood.edit', compact('risklikelihood'));
	}

	/**
	 * Update the specified risklikelihood in storage.
     * @param UpdateRiskLikelihoodRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateRiskLikelihoodRequest $request)
	{
		$risklikelihood = RiskLikelihood::findOrFail(decrypt($id));

        

		$risklikelihood->update($request->all());

		return redirect()->route('admin'.'.risklikelihood.index');
	}

	/**
	 * Remove the specified risklikelihood from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		RiskLikelihood::destroy(decrypt($id));

		return redirect()->route('admin'.'.risklikelihood.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));

            foreach($toDelete as $row){
            	$toDelete[$row] = decrypt($row);
            }
            RiskLikelihood::destroy($toDelete);
        } else {
            RiskLikelihood::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.risklikelihood.index');
    }

}
