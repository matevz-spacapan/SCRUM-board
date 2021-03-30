<div class="modal fade" id="rejectModal{{ $story->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $story->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel{{ $story->id }}">{{ __('Reject story') }} "{{ $story->title }}"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('story.reject', [$project->id, $story->id]) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment" class="col-form-label">{{ __('Comment for rejection') }} <i class="far fa-question-circle" {{ Popper::arrow()->position('right')->pop('If you wish, write a comment why you\'re rejecting this story.') }}></i></label>
                        <textarea id="comment" class="form-control" name="comment" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-warning">{{ __('Reject') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
