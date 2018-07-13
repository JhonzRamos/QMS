<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\RiskCategory;
use App\Http\Requests\CreateRiskCategoryRequest;
use App\Http\Requests\UpdateRiskCategoryRequest;
use Illuminate\Http\Request;



class RiskCategoryController extends Controller {

	/**
	 * Display a listing of riskcategory
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $riskcategory = RiskCategory::all();

		return view('admin.riskcategory.index', compact('riskcategory'));
	}

	/**
	 * Show the form for creating a new riskcategory
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.riskcategory.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$riskcategory = RiskCategory::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.riskcategory.show', compact('riskcategory', 'view' ));
	}


	/**
	 * Store a newly created riskcategory in storage.
	 *
     * @param CreateRiskCategoryRequest|Request $request
	 */
	public function store(CreateRiskCategoryRequest $request)
	{
	    
		RiskCategory::create($request->all());

		return redirect()->route('admin'.'.riskcategory.index');
	}

	/**
	 * Show the form for editing the specified riskcategory.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$riskcategory = RiskCategory::find(decrypt($id));
	    
	    
		return view('admin.riskcategory.edit', compact('riskcategory'));
	}

	/**
	 * Update the specified riskcategory in storage.
     * @param UpdateRiskCategoryRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateRiskCategoryRequest $request)
	{
		$riskcategory = RiskCategory::findOrFail(decrypt($id));

        

		$riskcategory->update($request->all());

		return redirect()->route('admin'.'.riskcategory.index');
	}

	/**
	 * Remove the specified riskcategory from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		RiskCategory::destroy(decrypt($id));

		return redirect()->route('admin'.'.riskcategory.index');
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
            RiskCategory::destroy($toDelete);
        } else {
            RiskCategory::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.riskcategory.index');
    }

}
