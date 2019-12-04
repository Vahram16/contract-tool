@extends('layout.main')
@section('content')

    <h3>{{ucfirst($chapter)}}</h3>

    <form action="{{route('storeSubchapter')}}" method="post">
        <div class="jumbotron">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck1" name="chapter2.1">
                <label class="form-check-label" for="gridCheck1">
                    .2       2.1  Subchapter
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck2" name="chapter2.2">
                <label class="form-check-label" for="gridCheck1">
                    .2       2.2  Subchapter
                </label>
            </div>

            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Next</button>
        </div>

    </form>


@endsection
