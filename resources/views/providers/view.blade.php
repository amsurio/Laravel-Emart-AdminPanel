@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.provider_plural')}} <span class="itemTitle"></span></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('providers') !!}">{{trans('lang.provider_plural')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.provider_details')}}</li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">
            <div id="data-table_processing" class="dataTables_processing panel panel-default"
                 style="display: none;">{{trans('lang.processing')}}</div>
            <div class="row">
                <div class="col-12">

                    <div class="resttab-sec">

                        <div class="menu-tab">
                            <ul>
                                <li class="active"><a href="{{route('providers.view', $id)}}">{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li><a href="{{route('ondemand.services.index', $id)}}">{{trans('lang.services')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.workers.index', $id)}}">{{trans('lang.workers')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.bookings.index',$id)}}">{{trans('lang.booking_plural')}}</a></li>
                                <li>
                                <li><a href="{{route('ondemand.coupons', $id)}}">{{trans('lang.coupon_plural')}}</a></li>                                
                                <li>
                                    <a href="{{route('providerPayouts.payout', $id)}}">{{trans('lang.tab_payouts')}}</a>
                                </li>
                                <?php if (in_array('wallet-transaction', json_decode(@session('user_permissions')))) { ?>

                                    <li>
                                        <a href="{{url('walletstransaction/providerID='.$id)}}"
                                           class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                    </li>

                                <?php }?>

                            </ul>
                        </div>

                    </div>

                    <div class="row vendor_payout_create">
                        <div class="vendor_payout_create-inner provider_detail_div">
                            
                            <fieldset>
                                <legend>{{trans('lang.provider_details')}}</legend>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                                    <div class="col-7">
                                        <span class="user_name" id="user_name"></span>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                    <div class="col-7">
                                        <span class="email"></span>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                                    <div class="col-7">
                                        <span class="phone"></span>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.profile_image')}}</label>
                                    <div class="col-7 profile_image">
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.wallet_Balance')}}</label>
                                    <div class="col-7 wallet_balance">
                                    </div>
                                </div>
                               
                            </fieldset>

                        </div>
                    </div>
                    <div class="form-group col-12 text-center btm-btn">
                        <a href="{!! route('providers') !!}" class="btn btn-default"><i
                                    class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">

        var id = "{{$id}}";
        var database = firebase.firestore();
        var ref = database.collection('users').where("id", "==", id);

        var photo = "";
        var placeholderImage = '';
        var placeholder = database.collection('settings').doc('placeHolderImage');

        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        });
        var currency = database.collection('settings');

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
            $(".currentCurrency").text(currencyData.symbol);
        });

        $(document).ready(async function () {

            jQuery("#data-table_processing").show();

            ref.get().then(async function (snapshots) {
                if(snapshots.docs.length>0){
                var user = snapshots.docs[0].data();

                    $(".user_name").text(user.firstName + ' ' + user.lastName);

                if (user.hasOwnProperty('email') && user.email) {
                    $(".email").text(user.email);

                } else {
                    $('.email').html("");

                }

                if (user.hasOwnProperty('phoneNumber') && user.phoneNumber) {
                    $(".phone").text(user.phoneNumber);

                } else {
                    $('.phone').html("");

                }

                var wallet_balance = 0;

                if (user.hasOwnProperty('wallet_amount') && user.wallet_amount != null && !isNaN(user.wallet_amount)) {
                    wallet_balance = user.wallet_amount;
                }
                if (currencyAtRight) {
                    wallet_balance = parseFloat(wallet_balance).toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    wallet_balance = currentCurrency + "" + parseFloat(wallet_balance).toFixed(decimal_degits);
                }

                $('.wallet_balance').html(wallet_balance);

                var image = "";
                if (user.profilePictureURL) {
                    image = '<img width="100px" id="" height="auto" src="' + user.profilePictureURL + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
                } else {
                    image = '<img width="100px" id="" height="auto" src="' + placeholderImage + '">';
                }

                $('.profile_image').html(image);
            }else{
                $('.provider_detail_div').html('<h5 class="text-danger text-center font-weight-bold">{{trans("lang.provider_unknown_deleted")}}</h5>')
            }
                jQuery("#data-table_processing").hide();

            });

        });

    </script>
@endsection