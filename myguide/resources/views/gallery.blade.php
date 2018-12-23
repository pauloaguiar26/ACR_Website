@extends('layouts.app')

@section('content')
    <div>
        @if($user = Auth::user())
            @if(Auth::user()->role == 'User' || Auth::user()->role == 'Admin')
                @if(!empty($events))
                    <h1>Share your Experiences with the World!</h1>
                    <form action="/gallery/" method = "POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value ="{{csrf_token()}}">
                        <select name="" id=""> <!--seleciona o evento pretendido para avaliar-->
                            <option value=""selected="selected"> Choose Event </option>
                            @foreach($events as $event)
                                <option value="{{$event->name}}">{{$event->name}}</option>
                                <input type="hidden" name="events_id" value = "{{$event->id}}">
                            @endforeach
                        </select>
                        <input type="file" name = "type_pic" onchange="uploadPic()">
                        <br><br>
                        <img src="" height="200" width="200" alt="Image preview">
                        <br><br>
                        <button type= "submit"> Upload </button>
                    </form>
                @endif
            @endif
        @endif
    </div>
    <script>
        function uploadPic(){
            
        var preview = document.querySelector('img'); 
        var file    = document.querySelector('input[type=file]').files[0]; 
        var reader  = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file); 
        } else {
            preview.src = "";
        }
        }

        uploadPic();  
    </script>
    <hr>
    <div>
        <!--imagens pequenas, quando clicamos ampliam com hipotese de passar para a proxima-->
        <!--for each para cobrir todas as imagens existentes
        <img src="imagem pequena" onclick = "zoom()" height="200" width="200">-->

		@foreach($reviews as $review)  <!--imprimir os eventos existentes junto com as suas imagens-->
			<img src="{{ asset('/images/gallery/'.$review->pic)}}" onclick = "zoom()" height="200" width="200">
		@endforeach
        @foreach($images as $image)
            <img src="{{ asset('/images/gallery/'.$image->name)}}" onclick = "zoom()" height="200" width="200">
        @endforeach
    </div>
@endsection