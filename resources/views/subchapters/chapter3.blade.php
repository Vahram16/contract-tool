@extends('layout.main')
@section('content')

    <h3> Chapter 3</h3>

    <form action="{{route('storeSubchapter')}}" method="post">
        <div class="jumbotron">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck1" name="chapter3.1">
                <label class="form-check-label" for="gridCheck1">
                    .2       3.1  Subchapter
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck2" name="chapter3.2">
                <label class="form-check-label" for="gridCheck1">
                    .2       3.2  Subchapter
                </label>
            </div>

            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Next</button>
        </div>

    </form>













@endsection
