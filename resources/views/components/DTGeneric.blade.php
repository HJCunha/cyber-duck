<div id="error-modal-label" class="alert alert-danger alert-dismissible hidden">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    <span id="error-message"></span>
</div>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="box">
                    <div class="box-body">
                        <table id="dt-table-1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                @foreach($header as $colHeader)
                                    <th style="text-align: center;">{{$colHeader}}</th>
                                @endforeach
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                @foreach($header as $colHeader)
                                    <th style="text-align: center;">{{$colHeader}}</th>
                                @endforeach
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-warning fade" id="modal-warning">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete row</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the selected row?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" id="modal-warning-no">No</button>
                    <button type="button" class="btn btn-outline" id="modal-warning-yes">Yes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@if(!empty($form))
    <!-- Form modal -->
        <div class="modal fade" id="modal-form" enctype="multipart/form-data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add/ Edit row</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_data_insert_row">
                            <input type="hidden" name="_token" value='{{ csrf_token() }}'>
                            <input type="hidden" name="type_of_action" id="form_action" value="insert">
                            @foreach($form as $label => $field)
                                <div class="form-group">
                                    <label for="field_{{$field["column"]}}">{{$label}}</label>
                                    @switch($field["type"])
                                        @case("text")
                                        <input class="form-control" type="text" placeholder="{{$label}}" name="{{$field["column"]}}" id="field_{{$field["column"]}}">
                                        @break
                                        @case("image")
                                            <a href="" target="_blank" id="image_link_{{$field["column"]}}">
                                                <img src="" id="image_{{$field["column"]}}" width="400px" height="auto" class="image-modal-edit">
                                            </a>
                                        @case("file")
                                        <input class="form-control" type="file" placeholder="{{$label}}" name="{{$field["column"]}}" id="field_{{$field["column"]}}">
                                        @break
                                        @case("select")
                                        <select name="{{$field["column"]}}" id="field_{{$field["column"]}}"
                                                class="select-box-form form-control"
                                                data-routetodata='{!! route("get.data." . $field["routeSuffix"]) !!}'
                                                data-columnname="{{$field["column"]}}"></select>
                                        @break
                                    @endswitch
                                </div>
                            @endforeach
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning pull-left" id="modal-form-no">Cancel</button>
                        <button type="button" class="btn btn-warning" id="modal-form-yes"  data-routesuffix="{{$routeSuffix}}">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endif

</div>

<script>

    function fillInSelectBox(selectBox, routeToFormData) {
        $.ajax({
            type:'GET',
            url:routeToFormData,
            data: {_token:'{{ csrf_token() }}' },
            success:function(data){
                if(!data.error) {
                    var sel = $(selectBox);
                    console.log("data select box", selectBox);

                    sel.empty();
                    console.log("data: ", data);
                    data = data.data;
                    for (var i=0; i<data.length; i++) {


                        sel.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                    }
                }
            }
        });
    }
    function loadRowToModal(selectedRow) {

        if(typeof selectedRow === "undefined") {
            return false;
        }
        $("#modal-form").removeClass("fade").addClass("show");
        $.each(selectedRow, function(index, val) {
            var type = $("#field_" + index, $("#modal-form")).attr("type");
            if( type !== "file" ) {
                $("#field_" + index, $("#modal-form")).val(val);
            }

            if($("#image_" + index)) {
                $("#image_" + index).attr("src" ,val);
                $("#image_link_" + index).attr("href" ,val);
            }
        });
        //console.log("Selected row", selectedRow );
    }

    var table = null;
    $(document).ready(function(){
        table = $('#dt-table-1').DataTable({
            dom: 'fBrtip',
            select: true,
            buttons: [
                {
                    className: "btn btn-success btn-sm ml1 btn-ripple ripple-set",
                    text: '<i class="fa fa-plus-square-o"></i> <span>Add Row</span>',
                    action: function( e, dt, node, config) {
                        $("#form_action").val("insert");

                        $('#form_data_insert_row').find("input[type=text], textarea").val("");
                        $('#form_data_insert_row').find("select").val(0);
                        $('#form_data_insert_row').find("img").attr("src","");
                        $('#form_data_insert_row').find("a").attr("href","");

                        $("#modal-form").removeClass("fade").addClass("show");
                    },
                },
                {
                    className: "btn btn-warning btn-sm ml1 btn-ripple ripple-set",
                    text: '<i class="fa fa-edit"></i> <span>Edit Row</span>',
                    action: function( e, dt, node, config) {
                        $("#form_action").val("update");
                        loadRowToModal(table.row('.selected').data());
                    },
                },
                {
                    className: "btn btn-danger btn-sm ml1 btn-ripple ripple-set",
                    text: '<i class="fa fa-trash"></i> <span>Delete Row</span>',
                    exportOptions: {
                        modifier: {
                            page: 'all',
                        }
                    },
                    action: function( e, dt, node, config) {
                        $("#modal-warning").removeClass("fade").addClass("show");
                    },
                },
            ],

            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{!! route($routeToData) !!}',
            fnDrawCallback: afterAjaxLoad,
            columns: [
                    @foreach($columns as $colName)
                { data: '{{$colName}}', name: '{{$colName}}' },
                @endforeach
            ]
        });

        var colNum = 0;
        $('#dt-table-1 thead th').each(function () {
            var title = $(this).text();
            $(this).html(title+'<br> <input type="text"  class="col-search-input form-control input-sm column_header_'+ colNum +'" placeholder="Search ' + title + '" />');
            colNum++;
        });

        table.columns().every(function () {
            var table = this;
            $('input', this.header()).on('keyup', function () {
                if (table.search() !== this.value && this.value.length > 3 ) {
                    table.search(this.value).draw();
                }
            });

            $('input', this.header()).on('keypress', function (e) {
                //console.log("Pressed key " + e.key + " CODE: " + e.keyCode );
                /*if (table.search() !== this.value ) {
                    table.search(this.value).draw();
                }*/
                if(e.keyCode == 13) {
                    if (table.search() !== this.value ) {
                        table.search(this.value).draw();
                    }
                }

            });
        });

        $(".col-search-input").on("click", function(e){
            e.preventDefault();
            return false;
        });


        $("#modal-warning-yes").on("click", function(){
            $("#modal-warning").removeClass("show").addClass("fade")

            var rowData = table.row('.selected').data();

            if(typeof rowData !== "undefined" && typeof rowData.id !== "undefined") {
                console.log( "ROW: ", rowData.id);
                $.ajax({
                    type:'GET',
                    url:'{!! route($routeToData . ".delete") !!}' + "?id=" + rowData.id,
                    data: {_token:'{{ csrf_token() }}' },
                    success:function(data){
                        if(!data.error) {
                            table.row('.selected').remove().draw(false);
                        }
                    }
                });
            }
        });

        $("#modal-warning-no").on("click", function(){
            $("#modal-warning").removeClass("show").addClass("fade");
        });

        $(".select-box-form").each(function(){
            var dataSelectBox = $(this).data();
            fillInSelectBox("#field_" + dataSelectBox.columnname, dataSelectBox.routetodata);
        });

        $("#modal-form-yes", $("#modal-form")).on("click", function(){
            $("#modal-form").removeClass("show").addClass("fade");

            var dataFromSelect = $(this).data();
            //var formData = $('#form_data_insert_row').serialize();
            var formData = new FormData($('#form_data_insert_row')[0]);

            if($("#form_action").val() === "insert") {
                $.ajax({
                    type:'POST',
                    url: "{!! route("base_url") !!}/insert-data-" + dataFromSelect.routesuffix + "?suffix=" + dataFromSelect.routesuffix,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        console.log( "Returned data", data);
                        if(!data.error) {
                            $("#error-modal-label").addClass("hidden");
                            table.draw(false);
                        } else {
                            if(data.error) {
                                showError(data.message);
                            }
                        }
                    }
                });
            }

            if($("#form_action").val() === "update") {
                var selectedRow = table.row('.selected').data();
                $.ajax({
                    type:'POST',
                    url: "{!! route("base_url") !!}/update-data-" + dataFromSelect.routesuffix + "/"+ selectedRow.id +"?suffix=" + dataFromSelect.routesuffix,
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        console.log( "Returned data", data);
                        if(!data.error) {
                            $("#error-modal-label").addClass("hidden");
                            table.draw(false);
                        } else {
                            if(data.error) {
                                showError(data.message);
                            }
                        }
                    }
                });
            }

        });

        $("#modal-form-no", $("#modal-form")).on("click", function(){
            $("#modal-form").removeClass("show").addClass("fade");
        });

    });

    function afterAjaxLoad() {
        $('#dt-table-1 tbody').unbind().on( 'click', 'tr', function () {
            console.log("Clicked",$(this));

            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

    }

    function showError(message) {
        $("#error-modal-label").removeClass("hidden");

        var finalMessage = "";
        $.each(message, function (index, value) {
            finalMessage += value.id + ": " + value.message + "<br>";
        })
        $("#error-message").html(finalMessage);
    }
</script>