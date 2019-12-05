@extends('layout.main')
@section('content')
    <form method="post" action="{{route('storeSubVariable')}}">
        <div class="jumbotron">


            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Contract Type</label>

                <select class="form-control form-control-sm" name="chapter3_1">
{{--                    @foreach($contractTypes as $contractType)--}}
{{--                        <option value="{{$contractType->type}}">{{ $contractType->type }}</option>--}}
{{--                    @endforeach--}}
                    <option value="three"> 3 </option>
                    <option value="five"> 5 </option>
                    <option value="ten"> 10</option>
                </select>

            </div>

            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>


@endsection











































