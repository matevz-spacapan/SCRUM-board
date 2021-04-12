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
                <textarea id="documentation" class="form-control" rows="int"
                          name="documentation" autofocus>{{$project->documentation}}</textarea>

                <div class="d-flex mt-2 justify-content-end">

                    <div class="custom-file mr-2">
                        <input type="file" class="custom-file-input" id="file_input" onchange="file_loaded()"
                            {{ Popper::arrow()->position('left')->pop('Upload documentation.') }}>
                        <label class="custom-file-label" for="file_input">Choose a documentation file to import</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
