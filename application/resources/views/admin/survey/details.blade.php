@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30 justify-content-center">
    <div class="col-xl-8 col-md-6 mb-30">
        <div class="card p-16 bg--white radius--base br--solid overflow-hidden">
            <h5 class="mb-20">@lang('Survey Form Data')</h5>
       
            @foreach ($survey['form_data']['questions'] as $q)
                <div class="mb-3">
                    
                    <label class="form-label fw-bold">{{ $q['question'] }}</label>
                    <span class="d-block">@lang("Type"): {{ucwords(str_replace('_',' ',$q['type']))}}</span>

                    @if($q['type'] == 'mcq_single' || $q['type'] == 'mcq_multiple')

                        <ul class="list-group list-group-flush">
                            @foreach($q['options'] as $opt)
                                <li class="list-group-item">{{ $opt }}</li>
                            @endforeach
                        </ul>
                    @elseif($q['type'] == 'written_textarea' || $q['type'] == 'written_input')
                        
                    @endif
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
