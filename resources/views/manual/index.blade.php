<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual') }}
        </h2>
    </x-slot>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="js/script.js"></script>
</head>
<div class="max-w-7xl mx-auto" style="display: flex;">
  <!--↓↓ 検索フォーム ↓↓-->
  <div style="padding:20px 0; width: 50%;">
  <form class="form-inline" action="{{url('/manual')}}">
    @csrf
    <div class="form-group">
    <input type="text" name="keyword" value="{{$keyword}}" class="form-control" placeholder="タイトルキーワードを入力">
    <input type="submit" value="検索" class="btn btn-info">
    </div>  
  </form>
  </div>
  <!--↑↑ 検索フォーム ↑↑-->
  <!-- selectによる絞込 -->
  <div id="select_editer" style="width: 50%; text-align: right;">
    <div class="col-sm-4 max-w-7xl mx-auto" style="padding:20px 0; padding-left:0px;"> 
      <form action="">
        <select name="editer" id="editer" onchange="this.form.submit()">
          <option value="1">--- 編集者 ---</option>
          @foreach ($users as $user)            
          <option value="{{$user["name"]}}">{{$user["name"]}}</option>
          @endforeach        
        </select> 
      </form>               
    </div>
  </div> 
</div>

    <div class="max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="bg-white border-b border-gray-200">
          <table class="text-center w-full border-collapse">

      	    	<div id="heading" style="position: relative; display: flex; align-items: center; background-color: #DDDDDD; border-bottom: medium solid #ccc; padding: 10px; text-align: center;">
                  <div id="thumbnail" style="width: 40%;">
                  </div> 
                  <div id="title" style="width: 30%;">
                      <p>タイトル</p>
                  </div>
                  <div id="updated" style="width: 10%;">
                      <p>更新日</p>
                  </div>  
                  <div id="user" style="width: 10%;">
                      <p>編集者</p>
                  </div> 
              </div>                 

            <tbody>
              @foreach ($manuals as $manual)
              @if (isset($editer) && ($manual->user->name != $editer))
              @continue
              @endif
              <tr class="hover:bg-grey-lighter">
                <td class="border-b border-grey-light">
                  <?php
                  $thumbnail_url = $manual->youtube_url;
                  $embedded_url = str_replace("watch?v=", "embed/", $thumbnail_url);
                  $updated_day = substr($manual->updated_at, 0, 10);
                  
                  // oEmebdからメタ情報取得して表示（タイトル取得）
                  $oembed_url = "https://www.youtube.com/oembed?url={$thumbnail_url}&format=json";
                  $ch = curl_init( $oembed_url );
                  curl_setopt_array( $ch, [
                    CURLOPT_RETURNTRANSFER => 1
                  ] );
                  $resp = curl_exec( $ch );
                  $metas = json_decode( $resp, true );
                    
                  if(!isset($metas["title"])){
                    $metas["title"] = $manual->title;
                  }
                  ?>
                  @if (!isset($keyword) || (strpos($metas["title"],$keyword) !== false))
                  <div id='contents' style="position: relative; display: flex; align-items: center; padding: 10px; width: 100%; text-align: center;">            
                    <div id='embedded_thumbnail_view' style="width: 40%;">
                    <iframe width='480' height='270' src={{$embedded_url}} title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                    </div>
                    <div id='title' style="width: 30%; text-align: left;">
                        <p>{{$metas["title"]}}</p>
                    </div> 
                    <div id='updated' style="width: 10%;">
                        <p>{{$updated_day}}</p>
                    </div>                  
                    <div id='user' style="width: 10%;">
                        <p>{{$manual->user->name}}</p>
                    </div>  
                    
                    <!-- 🔽 削除ボタン -->
                    <form action="{{ route('manual.destroy',$manual->id) }}" method="POST" class="text-left" style="width: 5%;">
                      @method('delete')
                      @csrf
                      <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </form> 
                    <!-- 🔽 更新ボタン -->
                    @if ($metas["title"] == $manual->title)
                    <form action="{{ route('manual.edit',$manual->id) }}" method="GET" class="text-left" style="width: 5%;">
                      @csrf
                      <button type="submit" class="mr-2 ml-2 text-sm hover:bg-gray-200 hover:shadow-none text-white py-1 px-2 focus:outline-none focus:shadow-outline">
                        <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="black">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                    </form>  
                    @endif
                   
                  </div>    

                  @endif
                  <div class="flex">
                    <!-- 更新ボタン -->
                    <!-- 削除ボタン -->
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
</x-app-layout>
