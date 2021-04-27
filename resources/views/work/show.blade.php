@extends('layouts.app')

@section('title', __(' - Project tasks'))

@section('page_specific_scripts')
    <script>
        function delete_work(work, button) {
            axios.delete('/work/' + work.id)
                .then(() => $(button).parent().parent().addClass('grayed'));
        }

        function edit_work(work, button) {
            const work_id = work.id;
            const amount_button = $('tr[work=' + work_id + '] td.amount-field input');

            if (!amount_button.prop('disabled')) {
                work.amount_min = amount_button.val();
                axios.put('/work/' + work.id, work)
                    .then(() => {
                        $(button).text('Edit work');
                        amount_button.removeClass('is-invalid');
                        amount_button.prop('disabled', true);
                    })
                    .catch(() => {
                        amount_button.addClass('is-invalid');
                    })
            } else {
                $(button).text('Submit edit');
                amount_button.prop('disabled', false);
            }
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
                                <th>Amount worked in minutes</th>
                                <th colspan="2">Manage work</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($works as $work)
                                <tr work="{{$work->id}}">
                                    <td class="day-field">{{$work->day}}</td>
                                    <td class="amount-field"><input class="form-control" value="{{$work->amount_min}}"
                                                                    disabled></td>
                                    <td><a class="btn btn-primary" type="button" onclick="edit_work({{$work}}, this)">Edit
                                            work</a></td>
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
