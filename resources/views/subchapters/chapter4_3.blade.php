@extends('layout.main')
@section('content')
    <form method="post" action="{{route('storeWordDocument')}}">
        <div class="jumbotron">

            @if(isset($subChapterOptions))
            <div class="form-group">
                <label for="exampleFormControlSelect1">Please select Option A or B</label>

                <select class="form-control form-control-sm" name="chapter4_3">
                    @foreach($subChapterOptions as $subChapterOption)
                        <option value="{{ $subChapterOption->option }}">{{ $subChapterOption->option }}</option>
                    @endforeach
                </select>

            </div>
            @endif

            @if(isset($serviceDays))
                <div class="form-group">
                    <label for="exampleFormControlSelect1"> Please select max number service days

                    </label>

                    <select class="form-control form-control-sm" name="chapter4_2">
                        @foreach($serviceDays as $serviceDay)
                            <option value="{{$serviceDay->service_day}}">{{ $serviceDay->service_day }}</option>
                        @endforeach
                    </select>

                </div>

        </div>
        @endif
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>


@endsection









