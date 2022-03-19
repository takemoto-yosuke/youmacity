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
    public function index(Request $request)
    {   
      #キーワード受け取り
      $keyword = $request->input('keyword');
      $editer = $request->input('editer');
      #クエリ生成
      $query = User::query();

     
      $items = Manual::simplePaginate(2);     
      $manuals = Manual::getAllOrderByUpdated_at();
      $users = User::getAllOrderByUpdated_at();
      
      return view('manual.index', ['manuals' => $manuals], ['items' => $items], ['users' => $users])
      ->with('keyword',$keyword)->with('users',$users)->with('editer',$editer);        
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
      
      $youtube_url = $request->input('youtube_url');
      $title = $request->input('title');
      
      // oEmebdからメタ情報取得して表示（タイトル取得）
      $oembed_url = "https://www.youtube.com/oembed?url={$youtube_url}&format=json";
      $ch = curl_init( $oembed_url );
      curl_setopt_array( $ch, [
      CURLOPT_RETURNTRANSFER => 1
      ] );
      $resp = curl_exec( $ch );
      $metas = json_decode( $resp, true );
      if(!isset($metas["title"]) && !isset($title)){
        return view('manual.check')->with('youtube_url',$youtube_url);
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
//    'youtube_url' => 'required | max:191',
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
    
    public function check(Request $request)
    {    
      //return redirect()->route('manual.store',input($request)); 
      return redirect()->route('manual.store', [$request]);
    }  
      
}
