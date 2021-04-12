@extends('layouts.app')

@section('title', __(' - Edit Documentation'))

@section('page_specific_scripts')
    <script type="text/javascript">
        function file_loaded() {
            const file = document.getElementById("file_input").files[0];
            if (file) {
                const reader = new FileReader();
                reader.readAsText(file, "UTF-8");
                reader.onload = function (evt) {
                    document.getElementById("documentation").value = evt.target.result;
                }
                reader.onerror = function (evt) {
                    console.log("error reading file");
                }
            }
        }
    </script>
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('project.edit_docs', $project->id) }}">
            @csrf
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex flex-row m-auto">
                    <label for="documentation" class="m-0 text-center mr-4">{{ __('Documentation') }}</label>
                    <a class="btn btn-link p-0"
                       href="{{ route('project.docs', [$project->id]) }}" {{ Popper::arrow()->position('right')->pop('Discard the form and return to the documentation.') }}>{{ __('Go back') }}</a>
                </div>
                <textarea id="documentation" type="text" class="form-control documentation-textarea"
                          name="documentation" autofocus>
                    {{$project->documentation}}
                </textarea>

                <div class="d-flex mt-2 justify-content-end">
                    <input id="file_input" type="file" class="btn btn-primary mr-2"
                           {{ Popper::arrow()->position('left')->pop('Upload documentation.') }}
                           onchange="file_loaded()">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Edit documentation') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
