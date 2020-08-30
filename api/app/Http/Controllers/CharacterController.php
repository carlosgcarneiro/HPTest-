<?php

namespace App\Http\Controllers;

use App\Character;
use App\House;
use App\Patronus;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['characters'] = Character::orderBy('id','asc')->paginate(10);
        return view('character.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['role'] = Role::all(['id', 'name']);
        $data['house'] = House::all(['id', 'name']);
        $data['patronus'] = Patronus::all(['id', 'name']);
        return view('character.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'house_id' => 'required',
            'patronus_id' => 'required',
        ]);

        unset($data['_token']);
        unset($data['_method']);
        $data['role_id'] +=1;
        $data['house_id'] +=1;
        $data['patronus_id'] +=1;

        Character::create($data);

        return Redirect::to('characters')
            ->with('success','Greate! Character created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['character'] = Character::findOrFail($id);
        return view('character.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data['character'] = Character::where($where)->first();
        $data['role'] = Role::all(['id', 'name']);
        $data['house'] = House::all(['id', 'name']);
        $data['patronus'] = Patronus::all(['id', 'name']);

        return view('character.edit', $data);
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
        $data = $request->all();
        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'house_id' => 'required',
            'patronus_id' => 'required',
        ]);

        unset($data['_token']);
        unset($data['_method']);
        $data['role_id'] +=1;
        $data['house_id'] +=1;
        $data['patronus_id'] +=1;

        Character::where('id',$id)->update($data);

        return Redirect::to('characters')
            ->with('success','Great! Character updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Character::where('id',$id)->delete();
        return Redirect::to('characters')->with('success','Character deleted successfully');
    }
}
