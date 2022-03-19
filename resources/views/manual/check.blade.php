<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
          <form class="mb-6" action="{{ route('manual.store') }}" method="POST">
            @csrf
            <div class="flex flex-col mb-4">
              非公開動画は任意のタイトルを入力してください
              <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="title">タイトル</label>
              <input class="border py-2 px-3 text-grey-darkest" type="text" name="title" id="title">
            </div>            
            <input type="hidden" name="youtube_url" id="youtube_url" value="{{$youtube_url}}">
            <button type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-white uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
              Create
            </button>
          </form>                    
<!--                     
    {{ Form::open(['route' => 'manual.store']) }}    
      <div class="form-group">
        {!! Form::label('user_label', 'youtube URL', ['class' => '']) !!}
      </div>            
                     
      <div class="col-sm-2">
        {!! Form::submit('投稿する', ['class' => 'form-control', 'id' => 'btn btn-primary']) !!}
      </div>
    {!! Form::close() !!}
-->    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
