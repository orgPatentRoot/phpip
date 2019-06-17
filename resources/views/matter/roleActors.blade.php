<table class="table table-hover table-sm">
    <thead class="thead-light">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Reference</th>
            <th>Company</th>
            <th>Date</th>
            <th>Rate</th>
            <th>Shared</th>
            <th>N</th>
            <th style="width: 24px;">&nbsp;</th>
        </tr>
    </thead>
    <tbody id="sortable">
        @foreach ( $role_group as $actor_item )
        <tr class="reveal-hidden" id="{{ $actor_item->id }}" data-id="{{ $actor_item->id }}">
            <td class="bg-light">&equiv;</td>
            <td class="ui-front"><input type="text" class="form-control noformat" name="actor_id" data-ac="/actor/autocomplete" placeholder="{{ $actor_item->display_name }}"></td>
            <td><input type="text" class="form-control noformat" name="actor_ref" value="{{ $actor_item->actor_ref }}"></td>
            <td class="ui-front"><input type="text" class="form-control noformat" name="company_id" data-ac="/actor/autocomplete" value="{{ $actor_item->company }}"></td>
            <td><input type="text" class="form-control noformat" size="10" name="date" value="{{ $actor_item->date }}"></td>
            <td><input type="text" class="form-control noformat" size="6" name="rate" value="{{ $actor_item->rate }}"></td>
            <td><input type="checkbox" name="shared" {{ $actor_item->shared ? 'checked' : '' }}></td>
            <td><input type="text" class="form-control noformat" size="2" name="display_order" value="{{ $actor_item->display_order }}"></td>
            <td><a href="javascript:void(0);" class="hidden-action text-danger" id="removeActor" title="Remove actor">&CircleMinus;</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $("#sortable").sortable({
        axis: 'y',
        update: function (event, ui) {
            $.each($(this).sortable('toArray'), function (index, value) {
                $.ajax({
                    url: '/actor-pivot/' + value,
                    type: 'PUT',
                    data: {
                        display_order: index + 1
                    }
                });
            });
            $('#ajaxModal').find(".modal-body").delay(100).load(relatedUrl);
        },
    });
</script>
