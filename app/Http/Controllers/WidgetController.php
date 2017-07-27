<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Widget;
use Redirect;

class WidgetController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',
            ['except' => ['index', 'show']]
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $widgets = Widget::withTrashed()->paginate(10);
        return view('widget.index', compact('widgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('widget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name'=> 'required|unique:widgets|string|max:30',
        ]);

        $widget = Widget::create([
            'name' => $request->name,
            'slug' => str_slug($request->name, "-"),
            'user_id'=> Auth::id()
        ]);

        $widget->save();

        alert()->success('Parabéns', 'Widget criado!');

        return redirect('widget');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = '')
    {
        $widget = Widget::withTrashed()->findOrFail($id);

        if ($widget->slug !== $slug){
            return Redirect::route('widget.show', [
                'id' => $widget->id,
                'slug' =>  $widget->slug
            ], 301);
        }

        return view('widget.show', compact('widget'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $widget = Widget::withTrashed()->findOrFail($id);

        return view('widget.edit', compact('widget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:30|unique:widgets,name,'.$id
        ]);

        $widget = Widget::findOrFail($id);

        $slug = str_slug($request->name, "-");
        $widget->update([
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => Auth::id()
        ]);

        alert()->success('Congratulations!','You updated a widget');

        return Redirect::route('widget.show', [
            'widget' => $widget, 'slug' => $slug
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Widget::destroy($id);

        alert()->overlay('Attention!', 'You deleted a widget', 'error');

        return Redirect::route('widget.index');
    }

    public function restore($id)
    {
        $widget = Widget::onlyTrashed()->findOrFail($id);
        $widget->restore();
        
        alert()->overlay('Congratulations!', 'You restored a widget', 'success');

        return Redirect::route('widget.show', [
            'widget' => $widget, 'slug' => $widget->slug
        ]);
    }
}
