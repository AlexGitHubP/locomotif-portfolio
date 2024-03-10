<?php

namespace Locomotif\Portfolio\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Locomotif\Portfolio\Models\Portfolio;
use Locomotif\Media\Controller\MediaController;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['authgate:administrator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Portfolio::with('categories', 'subcategories')->orderBy('ordering', 'desc')->get();
        foreach ($items as $key => $value) {
            $items[$key]->status_nice = mapStatus($value->status);
        }
        return view('items::list')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'url'  => 'required',
            'status'=>'required'
        ]);

        $item = new Portfolio();

        $item->name              = $request->name;
        $item->url               = $request->url;
        $item->description       = $request->description;
        $item->short_description = $request->short_description;
        $item->ordering          = getOrdering($item->getTable(), 'ordering');
        $item->status            = $request->status;


        $item->save();

        return redirect('admin/portfolio/'.$item->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        $associatedMedia      = app(MediaController::class)->mediaAssociations($portfolio->getTable(), $portfolio->id);
        return view('portfolio::edit')->with('item', $portfolio)->with('associatedMedia', $associatedMedia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {

        $request->validate([
            'name' => 'required',
            'url'  => 'required',
            'status' => 'required',
        ]);

        $portfolio->name              = $request->name;
        $portfolio->url               = $request->url;
        $portfolio->description       = $request->description;
        $portfolio->short_description = $request->short_description;
        $portfolio->status            = $request->status;

        $portfolio->save();

        return redirect('admin/portfolio/'.$portfolio->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        //
    }
}
