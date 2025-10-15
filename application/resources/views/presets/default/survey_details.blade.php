@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="profile-section">
            <div class="container">
                <div class="profile-items">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-12">
                            <div class="profile__wrap card p-4">
                                <h5 class="mb-20">{{ __($survey['title']) }}</h5>
                                <form id="surveyForm" action="{{ route('user.survey.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="survey_id" value="{{ $survey->id }}">

                                    @foreach ($survey['form_data']['questions'] as $index => $q)
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                {{ $index + 1 < 10 ? '0' . ($index + 1) : $index + 1 }}.
                                                {{ $q['question'] }}
                                            </label>

                                            {{-- Hidden meta info --}}
                                            <input type="hidden" name="questions[{{ $index }}][question]"
                                                value="{{ $q['question'] }}">
                                            <input type="hidden" name="questions[{{ $index }}][type]"
                                                value="{{ $q['type'] }}">

                                            {{-- Question types --}}
                                            @if (in_array($q['type'], ['mcq_single', 'mcq_multiple']))
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($q['options'] as $opt)
                                                        <li class="list-group-item">
                                                            <label class="d-flex align-items-center gap-2">
                                                                @if ($q['type'] === 'mcq_single')
                                                                    <input type="radio"
                                                                        name="questions[{{ $index }}][answer]"
                                                                        value="{{ $opt }}">
                                                                @else
                                                                    <input type="checkbox"
                                                                        name="questions[{{ $index }}][answer][]"
                                                                        value="{{ $opt }}">
                                                                @endif
                                                                {{ $opt }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @elseif ($q['type'] === 'written_textarea')
                                                <textarea name="questions[{{ $index }}][answer]" class="form-control" rows="3"></textarea>
                                            @elseif ($q['type'] === 'written_input')
                                                <input type="text" name="questions[{{ $index }}][answer]"
                                                    class="form-control">
                                            @endif
                                        </div>
                                    @endforeach

                                    <button type="submit" class="btn btn--base w-100">@lang('Submit Answers')</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('surveyForm').addEventListener('submit', function(e) {
            const totalQuestions = {{ count($survey['form_data']['questions']) }};
            for (let i = 0; i < totalQuestions; i++) {
                const selector = `[name^="questions[${i}][answer]"]`;
                const elements = document.querySelectorAll(selector);

                if (elements.length) {
                    let answered = false;

                    elements.forEach(el => {
                        if ((el.type === 'radio' || el.type === 'checkbox') && el.checked) {
                            answered = true;
                        } else if ((el.type === 'text' || el.tagName === 'TEXTAREA') && el.value.trim() !==
                            '') {
                            answered = true;
                        }
                    });

                    if (!answered) {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = `questions[${i}][answer]`;
                        hidden.value = '';
                        this.appendChild(hidden);
                    }
                } else {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = `questions[${i}][answer]`;
                    hidden.value = '';
                    this.appendChild(hidden);
                }
            }
        });
    </script>
@endpush
