@extends('layout.main')
@section('content')
    <form method="post" action="{{route('storeMainContract')}}">
        <div class="jumbotron">


            <div class="form-group">
                <label for="exampleFormControlSelect1">Select Contract Type</label>

                <select class="form-control form-control-sm" name="contractType">
                    @foreach($contractTypes as $contractType)
                        <option value="{{$contractType->type}}">{{ $contractType->type }}</option>
                    @endforeach
                </select>

            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Select K Team</label>
                <select class="form-control form-control-sm" name="kteam">
                    <@foreach($KTeams as $KTeam)
                        <option>{{ $KTeam->solution }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect2">Select contract partner</label>
                <select class="form-control form-control-sm" name="partner">
                    @foreach($contractPartners as $contractPartner)
                        <option value="{{$contractPartner->name}}">{{ $contractPartner->name }}</option>
                    @endforeach
                </select>
            </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect2">Select data of initally signed contract
                    </label>
                    <input type="date" name="date">
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">Next</button>
            </div>
    </form>




















































    {{--    <form method="post" action="{{route('storeMainContract')}}">--}}
    {{--        <div class="form-group jumbotron ">--}}

    {{--            <div class="form-group">--}}
    {{--                <label for="exampleFormControlSelect1">Select Contract Type</label>--}}

    {{--                <select name="contractType"  class="form-control form-control-sm">--}}
    {{--                    @foreach($contractTypes as $contractType)--}}
    {{--                        <option value="{{$contractType->type}}">{{ $contractType->type }}</option>--}}
    {{--                    @endforeach--}}
    {{--                </select>--}}

    {{--            </div>--}}
    {{--            <div class="form-group">--}}
    {{--                <label for="exampleFormControlSelect2">Select K Team</label>--}}
    {{--                <select  name="kteam" class="form-control form-control-sm">--}}
    {{--                    <@foreach($KTeams as $KTeam)--}}
    {{--                        <option>{{ $KTeam->solution }}</option>--}}
    {{--                    @endforeach--}}
    {{--                </select>--}}
    {{--            </div>--}}
    {{--            <div class="form-group">--}}
    {{--                <label for="exampleFormControlSelect2">Select contract partner</label>--}}
    {{--                <select class="form-control form-control-sm">--}}
    {{--                    @foreach($contractPartners as $contractPartner)--}}
    {{--                        <option value="{{$contractPartner->name}}">{{ $contractPartner->name }}</option>--}}
    {{--                    @endforeach--}}
    {{--                </select>--}}
    {{--            </div>--}}

    {{--            {{ csrf_field() }}--}}

    {{--            <div class="form-group">--}}
    {{--                <input type="datetime-local">--}}
    {{--                <div class="calend"></div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <button type="submit" class="btn btn-primary">Next</button>--}}
    {{--</form>--}}

@endsection
