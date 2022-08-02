@php
    $tag_id= basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $tag=\App\Tags::where('tag_id',$tag_id)->first();
    $user_ids=\App\TagMembers::where('tag_id',$tag_id)->pluck('user_id')->all();

@endphp
<form class="form-group" id="assign_tag_to_users" novalidate="novalidate">

    <label class="form-label">Tag Name <span class="form-asterick">&#42;</span></label>
    <input class="form-control btn-circle" type="text" autocomplete="off" name="title" placeholder="Title" value="{{$tag->tag_name}}" disabled><br/>
    <input class="form-control btn-circle" type="hidden" autocomplete="off" name="tag_id" placeholder="Title" value="{{$tag_id}}">
    <br>
    <div class="form-group">
        <label class="form-label">Click on a User’s Name to Add to this Tag <span class="form-asterick">&#42;</span></label>

        <select id="tag_users" class="ms form-control" name="user_ids[]" multiple="multiple">
            <?php $users = \App\Users::with('user_tags.tag')->where('organization_id', session('contact_center_admin.0.organization_id'))->get();?>
            <?php $invitees = \App\Invitees::with('user_tags.tag')->where('organization_id', session('contact_center_admin.0.organization_id'))->get();?>
                @foreach($users as $user)
                    @php $tags=''; @endphp
                    @if($user->user_tags->count()>0)
                        @foreach($user->user_tags as $tag)
                            @php $tags=$tag->tag->tag_name.', '.$tags; @endphp
                        @endforeach
                        @php $tags=' ('.rtrim($tags,', ').' )'; @endphp
                    @endif

                <option value="{{'1,'. $user->user_id }}"  @php if(in_array($user->user_id,$user_ids)) {echo 'selected';} @endphp>
                    {{ $user->first_name.' '.$user->last_name. $tags}}
                </option>
                    @endforeach

                    @foreach($invitees as $invite)
                        @php $tags=''; @endphp
                        @if($invite->user_tags->count()>0)
                            @foreach($invite->user_tags as $tag)
                                @php $tags=$tag->tag->tag_name.', '.$tags; @endphp
                            @endforeach
                            @php $tags=' ('.rtrim($tags,', ').' )'; @endphp
                        @endif
                        <option  value="{{'2,'.  $invite->id }}"  @php if(in_array($invite->id,$user_ids)) {echo 'selected';} @endphp>
                            {{$invite->name. $tags}}
                        </option>
                    @endforeach
        </select>
        <br/>
        <div id="error_group_user"></div>
    </div>
    <button class="btn" id="tagButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Assign Tag</button>
</form>
<script>

    $(document).ready(function(){

        $('#tag_users').multiSelect({
            selectableOptgroup: true,
            selectableHeader: "<a href='#' id='select-all2'>select all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Name or Tag'>",
            selectionHeader: "<a href='#' id='deselect-all2'>deselect all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to unselect'>",
            afterInit: function(ms){
                var that = this,
                    ms = this.$element,
                    values = ms.val(),
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
                console.log($selectableSearch);

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e){
                        if (e.which === 40){
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e){

                        if (e.which == 40){
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function(){
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function(){
                this.qs1.cache();
                this.qs2.cache();
            },
            select_all: function () {
                var that = this,
                    ms = this.$element,
                    values = ms.val(),
                    selectables = this.$selectableUl.find('.ms-elem-selectable').filter(':not(.' + this.options.disabledClass + ')').filter(':visible');
                alert(2);
                ms.find('option:not(":disabled")')
                    .filter(function (index) {
                        var it = this,
                            msValue = selectables
                                .filter(function () {
                                    return $(this).data('ms-value') === it.value;
                                })
                                .data('ms-value');
                        return msValue === this.value;
                    })
                    .prop('selected', true);
                selectables.addClass('ms-selected').hide();
                this.$selectionUl.find('.ms-optgroup-label').show();
                this.$selectableUl.find('.ms-optgroup-label').hide();

                this.$selectionUl
                    .find('.ms-elem-selection')
                    .filter(':not(.' + this.options.disabledClass + ')')
                    .filter(function (index) {
                        return that.$selectableUl.find('#' + $(this).attr('id').replace('-selection', '-selectable') + '.ms-selected' ).length === 1;
                    })
                    .addClass('ms-selected')
                    .show();
                this.$selectionUl.focus();
                ms.trigger('change');
                if (typeof this.options.afterSelect === 'function') {
                    var selectedValues = $.grep(ms.val(), function (item) {
                        return $.inArray(item, values) < 0;
                    });
                    this.options.afterSelect.call(this, selectedValues);
                }
            },
        });
    })
    $(document).on('click','#select-all2',function(){
        $('#tag_users').multiSelect('select_all');
        return false;
    });
    $(document).on('click','#deselect-all2',function(){
        $('#tag_users').multiSelect('deselect_all');
        return false;
    });

    $('#assign_tag_to_users').validate({
        rules: {
            user_ids: {required: true},

        },
        errorClass : 'text-danger',
        submitHandler: function(form) {

            $('#tagButton').attr('disabled', true);
            $('#tagButton').html('Loading ...');
            var formData = new FormData($("#assign_tag_to_users")[0]);
            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/assign_tag",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                success: function(data) {
                    $('#tagButton').attr('disabled', false);
                    $('#tagButton').html('Assign Tag');
                    if (data['msg']==='success') {
                        toastr["success"]('Changes confirmed');
                        window.setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else {
                        toastr["error"](data['msg']);
                    }
                }
            })
        }
    });

</script>
