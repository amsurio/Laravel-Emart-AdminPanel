@extends('layouts.app')

@section('content')

<div class="page-wrapper">


    <div class="row page-titles">


        <div class="col-md-5 align-self-center">


            <h3 class="text-themecolor">{{trans('lang.payout_request')}}</h3>


        </div>


        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.payout_request')}}</li>

            </ol>

        </div>


        <div>


        </div>


    </div>


    <div class="container-fluid">

        <div id="data-table_processing" class="dataTables_processing panel panel-default"
             style="display: none;">{{trans('lang.processing')}}
        </div>
        <div class="row">


            <div class="col-12">

                <div class="card">
                <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link " href="{!! url('payoutRequests/vendor') !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.vendors_payout_request')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{!! url('payoutRequests/drivers') !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.drivers_payout_request')}}</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link active" href="{!! url('payoutRequests/providers') !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.providers_payout_request')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">

                        <div id="data-table_processing" class="dataTables_processing panel panel-default"

                             style="display: none;">{{trans('lang.processing')}}

                        </div>

                    <div class="table-responsive m-t-10">


                        <table id="example24"

                               class="display nowrap table table-hover table-striped table-bordered table table-striped"

                               cellspacing="0" width="100%">


                            <thead>


                            <tr>

                            <?php if ($id == "") { ?>
                                <th>{{ trans('lang.provider')}}</th>
                            <?php } ?>
                            <th>{{trans('lang.paid_amount')}}</th>
                            <th>{{trans('lang.vendors_payout_note')}}</th>
                            <th>{{trans('lang.date')}}</th>
                            <th>{{trans('lang.status')}}</th>
                            <th>{{trans('lang.actions')}}</th>

                            </tr>


                            </thead>


                            <tbody id="append_list1">


                            </tbody>


                        </table>


                    </div>


                </div>


            </div>


        </div>


    </div>


</div>


<div class="modal fade" id="bankdetailsModal" tabindex="-1" role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered location_modal">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title locationModalTitle">{{trans('lang.bankdetails')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">

                <form class="">

                    <div class="form-row">

                        <input type="hidden" name="providerId" id="providerId">

                        <div class="form-group row">

                            <div class="form-group row width-100">
                                <label class="col-12 control-label">{{
                                    trans('lang.bank_name')}}</label>
                                <div class="col-12">
                                    <input type="text" name="bank_name" class="form-control" id="bankName">
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <label class="col-12 control-label">{{
                                    trans('lang.branch_name')}}</label>
                                <div class="col-12">
                                    <input type="text" name="branch_name" class="form-control" id="branchName">
                                </div>
                            </div>


                            <div class="form-group row width-100">
                                <label class="col-4 control-label">{{
                                    trans('lang.holer_name')}}</label>
                                <div class="col-12">
                                    <input type="text" name="holer_name" class="form-control" id="holderName">
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <label class="col-12 control-label">{{
                                    trans('lang.account_number')}}</label>
                                <div class="col-12">
                                    <input type="text" name="account_number" class="form-control" id="accountNumber">
                                </div>
                            </div>

                            <div class="form-group row width-100">
                                <label class="col-12 control-label">{{
                                    trans('lang.other_information')}}</label>
                                <div class="col-12">
                                    <input type="text" name="other_information" class="form-control" id="otherDetails">
                                </div>
                            </div>

                        </div>

                    </div>

                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                        {{trans('close')}}</a>
                    </button>

                </div>
            </div>
        </div>

    </div>

</div>


@endsection


@section('scripts')

<script type="text/javascript">

    var id = '<?php echo $id; ?>';
    var database = firebase.firestore();
  

    var intRegex = /^\d+$/;
    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

    if ('<?php echo $id ?>' != "") {
        var refData = database.collection('payouts').where('vendorID', '==', '<?php echo $id ?>');
    } else {
        var refData = database.collection('payouts').where('paymentStatus', '==', 'Pending').where('role','==','provider');
    }

    var email_templates = database.collection('email_templates').where('type', '==', 'payout_request_status');

    var emailTemplatesData = null;

    var ref = refData.orderBy('paidDate', 'desc');

    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal_degits = 0;

    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });

    var append_list = '';

    $(document).ready(function () {

        email_templates.get().then(async function (snapshots) {

            emailTemplatesData = snapshots.docs[0].data();

        });

        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

       
        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';

            html = await buildHTML(snapshots);

            if (html != '') {
                append_list.innerHTML = html;
            
            }
            $('#example24').DataTable({

                order: [],
                columnDefs: [
                    { orderable: false, targets: (id === "" ? [4, 5] : [3, 4]) },
                ],
                order: [3, "desc"],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });
            
            
            jQuery("#data-table_processing").hide();
        });
    });

    async function buildHTML(snapshots) {
        var html = '';

        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();          
            var getData = await getListData(val);
            html += getData;
        }));
        return html;
    }
   
    async function getListData(val) {
        var html = '';
        var price_val = '';
        var price = val.amount;

        if (intRegex.test(price) || floatRegex.test(price)) {

            price = parseFloat(price).toFixed(decimal_degits);
        } else {
            price = 0;
        }

        if (currencyAtRight) {
            price_val = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;
        } else {
            price_val = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);
        }
        html = html + '<tr>';
        <?php if ($id == '') { ?>
            const provider = payoutProvider(val.vendorID);
            html = html + '<td class="provider_' + val.vendorID + ' redirecttopage" ></td>';
        <?php } ?>
        html = html + '<td>' + price_val + '</td>';
        var date = val.paidDate.toDate().toDateString();
        var time = val.paidDate.toDate().toLocaleTimeString('en-US');
        html = html + '<td>' + val.note + '</td>';
        html = html + '<td>' + date + ' ' + time + '</td>';

        html = html + '<td>' + val.paymentStatus + '</td>';

        html = html + '<td class="action-btn"><a id="' + val.id + '" name="provider_view" data-auth="' + val.vendorID + '" href="javascript:void(0)" data-toggle="modal" data-target="#bankdetailsModal"><i class="fa fa-eye"></i></a><a id="' + val.id + '" name="provider_check" data-auth="' + val.vendorID + '" amount="' + price_val + '" href="javascript:void(0)"><i class="fa fa-check"></i></a><a id="' + val.id + '" data-price="' + price + '" amount="' + price_val + '" name="reject-request" data-auth="' + val.vendorID + '" href="javascript:void(0)"><i class="fa fa-close" ></i></a></td>';

        html = html + '</tr>';
       
        return html;
    }

    async function getProviderBankDetails() {
        var providerId = $('#providerId').val();

        await database.collection('users').where("id", "==", providerId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var user_data = snapshotss.docs[0].data();
                if (user_data.userBankDetails) {

                    $('#bankName').val(user_data.userBankDetails.bankName);
                    $('#branchName').val(user_data.userBankDetails.branchName);
                    $('#holderName').val(user_data.userBankDetails.holderName);
                    $('#accountNumber').val(user_data.userBankDetails.accountNumber);
                    $('#otherDetails').val(user_data.userBankDetails.otherDetails);

                }

            }
        });

    }

    $(document).on("click", "a[name='provider_view']", function (e) {
        $('#bankName').val("");
        $('#branchName').val("");
        $('#holderName').val("");
        $('#accountNumber').val("");
        $('#otherDetails').val("");

        var id = this.id;
        var auth = $(this).attr('data-auth');
        $('#providerId').val(auth);
        getProviderBankDetails();

    });

    $(document).on("click", "a[name='provider_check']", async function (e) {
        var id = this.id;
        var auth = $(this).attr('data-auth');

        var amount = $(this).attr('amount');

        var user = await getUserData(auth);

        jQuery("#data-table_processing").show();
        database.collection('payouts').doc(id).update({ 'paymentStatus': 'Success' }).then(async function (result) {
            if (user && user != undefined) {

                if(user.email){
                    var emailData = await sendMailToProvider(user, id, 'Approved', amount);

                    if (emailData) {
                        window.location.reload();
                    }
                }else{
                    window.location.reload();
                }

            } else {
                window.location.reload();
            }
            
        });
        jQuery("#data-table_processing").hide();
    });

    async function sendMailToProvider(user, id, status, amount) {

        var formattedDate = new Date();
        var month = formattedDate.getMonth() + 1;
        var day = formattedDate.getDate();
        var year = formattedDate.getFullYear();

        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;

        formattedDate = day + '-' + month + '-' + year;

        var subject = emailTemplatesData.subject;

        subject = subject.replace(/{requestid}/g, id);
        emailTemplatesData.subject = subject;

        var message = emailTemplatesData.message;
        message = message.replace(/{username}/g, user.firstName + ' ' + user.lastName);
        message = message.replace(/{date}/g, formattedDate);
        message = message.replace(/{requestid}/g, id);
        message = message.replace(/{status}/g, status);
        message = message.replace(/{amount}/g, amount);
        message = message.replace(/{usercontactinfo}/g, user.phoneNumber);

        emailTemplatesData.message = message;

        var url = "{{url('send-email')}}";

        return await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [user.email]);
    }

    async function getUserData(proivderId) {
        var data = '';

        await database.collection('users').where("id", "==", proivderId).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                data = snapshotss.docs[0].data();
            }
        });

        return data;
    }

    $(document).on("click", "a[name='reject-request']", async function (e) {
        var id = this.id;
        var auth = $(this).attr('data-auth');
        var priceadd = $(this).attr('data-price');

        var user = await getUserData(auth);

        var amount = $(this).attr('amount');

        jQuery("#data-table_processing").show();
        database.collection('users').where("id", "==", auth).get().then(function (resultprovider) {
            if (resultprovider.docs.length) {
                var provider = resultprovider.docs[0].data();
                var wallet_amount = 0;
                if (isNaN(provider.wallet_amount) || provider.wallet_amount == undefined) {
                    wallet_amount = 0;
                } else {
                    wallet_amount = provider.wallet_amount;
                }
                price = parseFloat(wallet_amount) + parseFloat(priceadd);
                if (!isNaN(price)) {
                    database.collection('payouts').doc(id).update({ 'paymentStatus': 'Reject' }).then(function (result) {
                        database.collection('users').doc(provider.id).update({ 'wallet_amount': price }).then(async function (result) {
                            if (user && user != undefined) {

                                if(user.email){
                                    var emailData = await sendMailToProvider(user, id, 'Disapproved', amount);

                                    if (emailData) {
                                        window.location.reload();
                                    }
                                }else{
                                    window.location.reload();
                                }

                            } else {
                                window.location.reload();
                            }
                        });
                    });
                }
            } else {
                jQuery("#data-table_processing").hide();
                alert('Provider not found.');
            }
        });
    });


    async function payoutProvider(provider) {
        var payoutProvider = '';
        var route = '{{route("providers.view",":id")}}';
        route = route.replace(':id', provider);
        await database.collection('users').where("id", "==", provider).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {
                var provider_data = snapshotss.docs[0].data();
                payoutProvider = provider_data.firstName+' '+ provider_data.lastName;
                jQuery(".provider_" + provider).attr("data-url", route).html(payoutProvider);
            } else {
                jQuery(".provider_" + provider).attr("data-url", route).html('');
            }
        });
        return payoutProvider;
    }

</script>



@endsection
