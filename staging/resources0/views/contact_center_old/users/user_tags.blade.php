@php
    //$user_id= basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $data=explode('/',request()->path());
    $user_id=$data[3];
    $type=$data[4];

    $tag_ids=\App\TagMembers::where('user_id',$user_id)->pluck('tag_id')->all();
    $tags=\App\Tags::where('organization_id',session('contact_center_admin.0.organization_id'))->get();

@endphp
<form class="form-group" id="assign_tag_to_users" novalidate="novalidate">

    <div class="form-group">
        <label class="form-label">Click on a Tag to Add to this User <span class="form-asterick">&#42;</span></label>
        <input type="hidden" name="user_id" value="{{$user_id}}">
        <select id="tag_users" class="ms form-control" name="tag_ids[]" multiple="multiple">
                @foreach($tags as $tag)
                    <option value="{{$type.','. $tag->tag_id }}"  @php if(in_array($tag->tag_id,$tag_ids)) {echo 'selected';} @endphp>
                        {{ $tag->tag_name}}
                    </option>
                @endforeach

        </select>
        <br/>
        <div id="error_group_user"></div>
    </div>
    <button class="btn" id="tagButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Save Changes</button>
</form>
<script>

    $(document).ready(function(){

        $('#tag_users').multiSelect({
            selectableOptgroup: true,
            selectableHeader: "<a href='#' id='select-all1'>select all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Tag'>",
            selectionHeader: "<a href='#' id='deselect-all1'>deselect all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to unselect'>",
            afterInit: function(ms){
                var that = this,
                    ms = this.$element,
                    values = ms.val(),
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
                console.log($selectableSearch);

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString,{
                    'show': function () {
                        // alert('show');
                        $(this).prev(".ms-optgroup-label").show();
                        $(this).show();
                    },
                    'hide': function () {
                        //    alert('hide');
                        $(this).prev(".ms-optgroup-label").hide();
                        $(this).hide();
                    }
                })
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
        });
    })
    $(document).on('click','#select-all1',function(){
        $('#tag_users').multiSelect('select_all');
        return false;
    });
    $(document).on('click','#deselect-all1',function(){
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
                url: "{{url('/')}}/contact_center/ajax/assign_tag_users",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                success: function(data) {
                    $('#tagButton').attr('disabled', false);
                    $('#tagButton').html('Save changes');
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
