@extends('layout.main')
@section('content')
    <form action="{{route('storeChapter')}}" method="post">
        <div class="jumbotron">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck1" name="chapter1" checked  disabled>
                <label class="form-check-label" for="gridCheck1">
                   1. Deﬁnitions and abbbreviations

                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck2" name="chapter2">
                <label class="form-check-label" for="gridCheck1">
                   2. Chapter 2

                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck3" name="chapter3">
                <label class="form-check-label" for="gridCheck1">
                    3. Chapter 3
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck4" name="chapter4">
                <label class="form-check-label" for="gridCheck1">
                   4. Chapter 4

                </label>
            </div>
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Next</button>
        </div>

    </form>










@endsection
