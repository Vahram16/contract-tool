@extends('layout.main')
@section('content')
    <form method="post" action="{{route('storeSubVariable')}}">
        <div class="jumbotron">


            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Contract Type</label>

                <select class="form-control form-control-sm" name="chapter3_1">
                    @foreach($serviceDays as $serviceDay)
                        <option value="{{$serviceDay->service_day}}">{{ $serviceDay->service_day }}</option>
                    @endforeach
                </select>

            </div>

            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>


@endsection











































