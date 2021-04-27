@extends('layouts.app')

@section('title', __(' - Project tasks'))

@section('page_specific_scripts')
    <script>
        function delete_work(work, button) {
            console.log(button);
            axios.delete('/work/' + work.id)
                .then(() => $(button).parent().parent().addClass('grayed'));
        }
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-baseline">
                        <div>{{ __('Work done on task: ' . $task->description) }}</div>
                        <div><a class="btn btn-link"
                                href="{{ route('task.task_view', $project->id) }}" {{ Popper::arrow()->position('right')->pop('Return to the task view') }}>{{ __('Go back') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Day</th>
                                <th>Amount worked minutes</th>
                                <th colspan="2">Manage work</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($works as $work)
                                <tr>
                                    <td>{{$work->day}}</td>
                                    <td>{{$work->amount_min}}</td>
                                    <td><a class="btn btn-primary" type="button">Edit work</a></td>
                                    <td><a class="btn btn-danger" type="button" onclick="delete_work({{$work}}, this)">Delete
                                            work</a></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
