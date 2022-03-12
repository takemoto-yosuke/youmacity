<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Manual;
use App\Models\User;
use Auth;

class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /*
    public function index()
    {
  $manuals = Manual::getAllOrderByUpdated_at();
  return view('manual.index', [
    'manuals' => $manuals
  ]);        
    }
    */
    public function index()
    {   
  $items = Manual::simplePaginate(2);     
  $manuals = Manual::getAllOrderByUpdated_at();
  return view('manual.index', [
    'manuals' => $manuals
  ], ['items' => $items]);        
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manual.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
  // バリデーション
  $validator = Validator::make($request->all(), [
    'youtube_url' => 'required | max:191',
  //  'user_name_id' => 'required',
  ]);
  // バリデーション:エラー
  if ($validator->fails()) {
    return redirect()
      ->route('manual.create')
      ->withInput()
      ->withErrors($validator);
  }
  // create()は最初から用意されている関数
  // 戻り値は挿入されたレコードの情報
  $data = $request->merge(['user_id' => Auth::user()->id])->all();
  $result = Manual::create($data);
  //$result = Manual::create($request->all());
  // ルーティング「todo.index」にリクエスト送信（一覧ページに移動）
  return redirect()->route('manual.index');        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
  $manual = Manual::find($id);
  return view('manual.edit', ['manual' => $manual]);
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
  //バリデーション
  $validator = Validator::make($request->all(), [
    'youtube_url' => 'required | max:191',
  ]);
  //バリデーション:エラー
  if ($validator->fails()) {
    return redirect()
      ->route('manual.edit', $id)
      ->withInput()
      ->withErrors($validator);
  }
  //データ更新処理
  $result = Manual::find($id)->update($request->all());
  return redirect()->route('manual.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
  $result = Manual::find($id)->delete();
  return redirect()->route('manual.index');
    }
}
