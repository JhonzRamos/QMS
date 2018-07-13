<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Strategies;
use App\Http\Requests\CreateStrategiesRequest;
use App\Http\Requests\UpdateStrategiesRequest;
use Illuminate\Http\Request;



class StrategiesController extends Controller {

	/**
	 * Display a listing of strategies
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $strategies = Strategies::all();

		return view('admin.strategies.index', compact('strategies'));
	}

	/**
	 * Show the form for creating a new strategies
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.strategies.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$strategies = Strategies::find(decrypt($id));
		
		
		$view = "view";
		return view('admin.strategies.show', compact('strategies', 'view' ));
	}


	/**
	 * Store a newly created strategies in storage.
	 *
     * @param CreateStrategiesRequest|Request $request
	 */
	public function store(CreateStrategiesRequest $request)
	{
	    
		Strategies::create($request->all());

		return redirect()->route('admin'.'.strategies.index');
	}

	/**
	 * Show the form for editing the specified strategies.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$strategies = Strategies::find(decrypt($id));
	    
	    
		return view('admin.strategies.edit', compact('strategies'));
	}

	/**
	 * Update the specified strategies in storage.
     * @param UpdateStrategiesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateStrategiesRequest $request)
	{
		$strategies = Strategies::findOrFail(decrypt($id));

        

		$strategies->update($request->all());

		return redirect()->route('admin'.'.strategies.index');
	}

	/**
	 * Remove the specified strategies from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Strategies::destroy(decrypt($id));

		return redirect()->route('admin'.'.strategies.index');
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
            Strategies::destroy($toDelete);
        } else {
            Strategies::whereNotNull('id')->delete();
        }

        return redirect()->route('admin'.'.strategies.index');
    }

}
