<script type="text/javascript">
    $(function () {

        ajaxSourceUrl = "<?php echo SITE_ADM_MOD.  $this->module; ?>/ajax.<?php echo $this->module; ?>.php";
        OTable = $('#dt_users').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": ajaxSourceUrl,
            "fnServerData": function (sSource, aoData, fnCallback) {
                $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            },
            "aaSorting" : [],
            "aoColumns": [
                { "sName": "id", 'sTitle' : 'Admin Id', 'bVisible': false},
                {"sName": "a.uName", 'sTitle': 'User Name'},
                {"sName": "a.uEmail", 'sTitle': 'Email Address'},
                { "sName": "a.created_date", 'sTitle' : 'Created Date'}
                <?php if(in_array('status',$this->Permission)){ ?>
                ,{"sName": "status", 'sTitle': 'Status', bSortable: false, bSearchable: false}
                <?php } ?>
                <?php if(in_array('edit',$this->Permission) || in_array('delete',$this->Permission) || in_array('view',$this->Permission) ){ ?>
                ,{"sName": "operation", 'sTitle': 'Operation', bSortable: false, bSearchable: false}
                <?php } ?>
            ],
            "fnServerParams"
                    : function (aoData) {
                        setTitle(aoData, this)
                    },
            "fnDrawCallback"
                    : function (oSettings) {
                        $('.make-switch').bootstrapSwitch();
                        $('.make-switch').bootstrapSwitch('setOnClass', 'success');
                        $('.make-switch').bootstrapSwitch('setOffClass', 'danger');

                    }

        });
        $('.dataTables_filter').css({float: 'right'});
        $('.dataTables_filter input').addClass("form-control input-inline");

        $.validator.addMethod('pagenm', function (value, element) {
            return /^[a-zA-Z0-9][a-zA-Z0-9\_\-]*$/.test(value);
        }, 'Page name is not valid. Only alphanumeric and _ are allowed'
                );
        $(document).on('submit', '#frmCont', function (e) {
            $("#frmCont").on('submit', function () {
                for (var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            })
            $("#frmCont").validate({
                ignore: [],
                errorClass: 'help-block',
                errorElement: 'span',
                rules: {
                    uEmail: {
                        remote: {
                            url: "<?php echo SITE_ADM_MOD . $this->module ?>/ajax.<?php echo $this->module; ?>.php",
                            type: "post",
                            async: false,
                            data: {ajaxvalidate: true,chkType:'email', uEmail: function () {
                                    return $("#uEmail").val();
                                }, id: function () {
                                    return $("#id").val();
                                }},
                            complete: function (data) {
                                return data;
                            }
                        },
                        email:true,
                        required:true,
                    },
                    uName: {
                        remote: {
                            url: "<?php echo SITE_ADM_MOD . $this->module ?>/ajax.<?php echo $this->module; ?>.php",
                            type: "post",
                            async: false,
                            data: {ajaxvalidate: true,chkType:'name', uName: function () {
                                    return $("#uName").val();
                                }, id: function () {
                                    return $("#id").val();
                                }},
                            complete: function (data) {
                                return data;
                            }
                        },
                        required:true,

                    },
                    uPass:{required:true,min:6}
                },
                messages: {
                    uEmail: {remote: 'Email name already exist.',required:"Please enter email address."},
                    uName: {remote: 'User name already exist.',required:"Please enter user name."},
                    uPass:{required:"Please enter password."}
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function (error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            if ($("#frmCont").valid()) {
                return true;
            } else {
                return false;
            }
        });
    });



</script>

<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <?php
        echo $this->breadcrumb;
        ?>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet box blue-dark">
            <div class="portlet-title ">
                <div class="caption"><i class="fa fa-list-alt"></i><?php echo $this->headTitle; ?></div>
                <div class="actions portlet-toggler">
                    <?php if(in_array('add',$this->Permission)){ ?>
                    <a href="<?php echo SITE_ADM_MOD.$this->module.'/';?>ajax.<?php echo $this->module;?>.php?action=add" class="btn blue btn-add">
                        <i class="fa fa-pencil"></i> Add
                    </a>
                    <?php } ?>
                    <div class="btn-group"></div>
                </div>
            </div>
            <div class="portlet-body portlet-toggler">
                <table id="dt_users" class="table table-striped table-bordered table-hover"></table>
            </div>
            <div class="portlet-toggler pageform" style="display:none;"></div>
        </div>
    </div>
</div>