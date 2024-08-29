@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">

            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.vendor_plural')}} <span class="itemTitle"></span></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{!! route('vendors') !!}">{{trans('lang.vendor_plural')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{trans('lang.vendor_details')}}</li>
                </ol>
            </div>

        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="resttab-sec">
                        <div id="data-table_processing" class="dataTables_processing panel panel-default"
                             style="display: none;">
                            {{trans('lang.processing')}}
                        </div>
                        <div class="menu-tab">
                            <ul>
                                <li class="active">
                                    <a href="{{route('vendors.view',$id)}}" >{{trans('lang.tab_basic')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.items',$id)}}">{{trans('lang.tab_items')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.orders',$id)}}">{{trans('lang.tab_orders')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.reviews',$id)}}">{{trans('lang.tab_reviews')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('vendors.coupons',$id)}}">{{trans('lang.tab_promos')}}</a>
                                <li>
                                    <a href="{{route('vendors.payout',$id)}}">{{trans('lang.tab_payouts')}}</a>
                                </li>

                                <li class="dine_in_future" style="display:none;">
                                    <a href="{{route('vendors.booktable',$id)}}">{{trans('lang.dine_in_future')}}</a>
                                </li>
                                <?php if (in_array('wallet-transaction', json_decode(@session('user_permissions')))) { ?>

                                <li>
                                    <a href="{{route('users.walletstransaction',$id)}}"
                                       class="wallet_transaction">{{trans('lang.wallet_transaction')}}</a>
                                </li>

                                <?php }?>

                            </ul>

                        </div>
                        <div class="row daes-top-sec mb-3">

                            <div class="col-lg-3 col-md-6">

                                <div class="card">

                                    <div class="flex-row">

                                        <div class="p-10 bg-info col-md-12 text-center">

                                            <h3 class="text-white box m-b-0"><i class="mdi mdi-cart"></i></h3>
                                        </div>

                                        <div class="align-self-center pt-3 col-md-12 text-center">

                                            <h3 class="m-b-0 text-info" id="total_orders">0</h3>

                                            <h5 class="text-muted m-b-0">{{trans('lang.dashboard_total_orders')}}</h5>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3 col-md-6">

                                <div class="card">

                                    <div class="flex-row">

                                        <div class="p-10 bg-info col-md-12 text-center">

                                            <h3 class="text-white box m-b-0"><i class="mdi mdi-cart"></i></h3>
                                        </div>

                                        <div class="align-self-center pt-3 col-md-12 text-center">

                                            <h3 class="m-b-0 text-info" id="total_items">0</h3>

                                            <h5 class="text-muted m-b-0">{{trans('lang.dashboard_total_items')}}</h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-3 col-md-6">

                                <div class="card">

                                    <div class="flex-row">

                                        <div class="p-10 bg-info col-md-12 text-center">

                                            <h3 class="text-white box m-b-0"><i class="mdi mdi-bank"></i></h3>
                                        </div>

                                        <div class="align-self-center pt-3 col-md-12 text-center">

                                            <h3 class="m-b-0 text-info" id="total_earnings">0</h3>

                                            <h5 class="text-muted m-b-0">{{trans('lang.dashboard_total_earnings')}}</h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-3 col-md-6">

                                <div class="card">

                                    <div class="flex-row">

                                        <div class="p-10 bg-info col-md-12 text-center">

                                            <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                        </div>

                                        <div class="align-self-center pt-3 col-md-12 text-center">

                                            <h3 class="m-b-0 text-info" id="total_payment">0</h3>

                                            <h5 class="text-muted m-b-0">{{trans('lang.dashboard_total_payment')}}</h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-3 col-md-6">

                                <div class="card">

                                    <div class="flex-row">

                                        <div class="p-10 bg-info col-md-12 text-center">

                                            <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                        </div>

                                        <div class="align-self-center pt-3 col-md-12 text-center">

                                            <h3 class="m-b-0 text-info" id="remaining_amount">0</h3>

                                            <h5 class="text-muted m-b-0">{{trans('lang.remaining_payment')}}</h5>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="row vendor_payout_create vendor_details">
                            <div class="vendor_payout_create-inner vendor_detail_div">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addWalletModal"
                                   class="add-wallate btn btn-success"><i class="fa fa-plus"></i>
                                    {{trans('lang.add_wallet_amount')}}</a>
                                <fieldset>
                                    <legend>{{trans('lang.vendor_details')}}</legend>

                                    <div class="form-group row width-50 vendor_image">
                                        <div class="col-7">
                                            <span class="vendor_image" id="vendor_image"></span>
                                        </div>
                                        <div class="col-7 align-items-center justify-content-center d-flex review-box mt-3 mb-3">
                                            <div class="reviewhtml"></div>
                                            <div class="review_count">{{trans('lang.tab_reviews')}}<span
                                                        id="vendor_reviewcount"></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.vendor_name')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_name"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.vendor_phone')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_phone"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.vendor_address')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_address"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.vendor_description')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_description"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.vendor_cuisine')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_cuisines"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.section')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_section"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.wallet_Balance')}}</label>
                                        <div class="col-7">
                                            <span class="wallet"></span>
                                        </div>
                                    </div>

                                </fieldset>

                                <fieldset>
                                    <legend>{{trans('lang.gallery')}}</legend>

                                    <div class="form-group row width-50 vendor_image">
                                        <div class="">
                                            <div id="photos"></div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>{{trans('lang.vendor_details')}}</legend>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.name')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_name"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_email"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50 multivendor_status_div d-none">
                                        <label class="col-3 control-label">{{trans('lang.vendor_status')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_avtive"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row width-50">
                                        <label class="col-3 control-label">{{trans('lang.vendor_phone')}}</label>
                                        <div class="col-7">
                                            <span class="vendor_phoneNumber"></span>
                                        </div>
                                    </div>


                                </fieldset>

                                <fieldset>
                                    <legend>{{trans('lang.services')}}</legend>

                                    <div class="form-group row width-100">
                                        <div class="col-7" id="filtershtml">

                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-group col-12 text-center btm-btn">
                    <a href="{!! route('vendors') !!}" class="btn btn-default"><i
                                class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addWalletModal" tabindex="-1" role="dialog"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered location_modal">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title locationModalTitle">{{trans('lang.add_wallet_amount')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <form class="">

                        <div class="form-row">

                            <div class="form-group row">

                                <div class="form-group row width-100">
                                    <label class="col-12 control-label">{{
                                    trans('lang.amount')}}</label>
                                    <div class="col-12">
                                        <input type="number" name="amount" class="form-control" id="amount">
                                        <div id="wallet_error" style="color:red"></div>
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-12 control-label">{{
                                    trans('lang.note')}}</label>
                                    <div class="col-12">
                                        <input type="text" name="note" class="form-control" id="note">
                                    </div>
                                </div>

                                <div class="form-group row width-100">

                                    <div id="user_account_not_found_error" class="align-items-center"
                                         style="color:red"></div>
                                </div>

                            </div>

                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-wallet-btn">{{trans('submit')}}
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                            {{trans('close')}}
                        </button>

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
        var ref = database.collection('vendors').where("id", "==", id);
        var photo = "";
        var vendorOwnerId = "";
        var vendorOwnerOnline = false;

        var placeholderImage = '';
        var placeholder = database.collection('settings').doc('placeHolderImage');

        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        })

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
        var email_templates = database.collection('email_templates').where('type', '==', 'wallet_topup');

        var emailTemplatesData = null;

        $(document).ready(async function () {

            await email_templates.get().then(async function (snapshots) {
                emailTemplatesData = snapshots.docs[0].data();
            });

            var orders = await getTotalOrders();
            var items = await getTotalItems();
            var earnings = await getTotalEarnings();
            var payment = await getTotalpayment();

            var remaining = earnings - payment;

            if (currencyAtRight) {
                remaining_with_currency = parseFloat(remaining).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                remaining_with_currency = currentCurrency + "" + parseFloat(remaining).toFixed(decimal_degits);
            }

            $("#remaining_amount").text(remaining_with_currency);

            jQuery("#data-table_processing").show();

            ref.get().then(async function (snapshots) {
                if (snapshots.docs.length > 0) {

                    var vendor = snapshots.docs[0].data();

                    var wallet_route = "{{route('users.walletstransaction','id')}}";

                    $(".wallet_transaction").attr("href", wallet_route.replace('id', 'storeID='+vendor.author));


                    $(".vendor_name").text(vendor.title);
                    $(".itemTitle").text(' - ' + vendor.title);
                    if (vendor.dine_in_active == true) {
                        $(".dine_in_future").show();
                    }
                    var rating = 0;
                    if (vendor.hasOwnProperty('reviewsCount') && vendor.reviewsCount != 0) {
                        rating = Math.round(parseFloat(vendor.reviewsSum) / parseInt(vendor.reviewsCount));
                    } else {
                        rating = 0;
                    }

                    const walletBalance = getWalletBalance(vendor.author);

                    var review = '<ul class="rating" data-rating="' + rating + '">';
                    review = review + '<li class="rating__item"></li>';
                    review = review + '<li class="rating__item"></li>';
                    review = review + '<li class="rating__item"></li>';
                    review = review + '<li class="rating__item"></li>';
                    review = review + '<li class="rating__item"></li>';
                    review = review + '</ul>';
                    $("#vendor_reviewcount").text(vendor.reviewsCount);


                    $(".vendor_avtive").html("{{trans('lang.closed')}}");
                    $(".vendor_avtive").addClass('closed');

                    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                    var currentdate = new Date();

                    var currentDay = days[currentdate.getDay()];

                    var hour = currentdate.getHours();

                    var minute = currentdate.getMinutes();
                    if (hour < 10) {
                        hour = '0' + hour
                    }
                    if (minute < 10) {
                        minute = '0' + minute
                    }
                    var currentHours = hour + ':' + minute;

                    if (vendor.hasOwnProperty('workingHours')) {
                        for (i = 0; i < vendor.workingHours.length; i++) {
                            var day = vendor.workingHours[i]['day'];
                            if (vendor.workingHours[i]['day'] == currentDay) {
                                if (vendor.workingHours[i]['timeslot'].length != 0) {
                                    for (j = 0; j < vendor.workingHours[i]['timeslot'].length; j++) {
                                        var timeslot = vendor.workingHours[i]['timeslot'][j];
                                        var TimeslotHourVar = {
                                            'from': timeslot[`from`],
                                            'to': timeslot[`to`],
                                            'closeingType': timeslot[`closeingType`]
                                        };
                                        var [h, m] = timeslot[`from`].split(":");
                                        var from = ((h % 12 ? h % 12 : 12) + ":" + m, h >= 12 ? 'PM' : 'AM');

                                        var [h2, m2] = timeslot[`to`].split(":");
                                        var to = ((h2 % 12 ? h2 % 12 : 12) + ":" + m2, h2 >= 12 ? 'PM' : 'AM');

                                        if (currentHours >= timeslot[`from`] && currentHours <= timeslot[`to`]) {
                                            $(".vendor_avtive").html("{{trans('lang.open')}}");
                                            $(".vendor_avtive").removeClass('close');
                                            $(".vendor_avtive").addClass('open');
                                            $(".vendor_avtive").append(" (" + timeslot[`from`] + ' ' + from + ' - ' + timeslot[`to`] + ' ' + to + ")");

                                        }

                                    }
                                }
                            }
                        }

                    }

                    var photos = '';
                    if (vendor.photos.length > 0) {
                        vendor.photos.forEach((photo) => {
                            photos = photos + '<span class="image-item"><img width="100px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>';
                        })
                    }
                    if (photos) {
                        $("#photos").html(photos);
                    } else {
                        $("#photos").html('<p>photos not available.</p>');
                    }

                    var image = "";
                    if (vendor.photo) {
                        if (vendor.photo) {
                            photo = vendor.photo;
                        } else {
                            photo = placeholderImage;
                        }
                        image = '<img width="200px" id="" height="auto" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
                    } else {
                        image = '<img width="200px" id="" height="auto" src="' + placeholderImage + '">';
                    }
                    $("#vendor_image").html(image);
                    $(".reviewhtml").html(review);

                    filtershtml = '';
                    for (var key in vendor.filters) {
                        filtershtml = filtershtml + '<li>' + key + ': ' + vendor.filters[key] + '</li>';
                    }

                    $("#filtershtml").html(filtershtml);


                    await database.collection('vendor_categories').get().then(async function (snapshots) {
                        snapshots.docs.forEach((listval) => {
                            var data = listval.data();
                            if (data.id == vendor.categoryID) {
                                $(".vendor_cuisines").text(data.title);
                            }
                        })
                    });


                    await database.collection('sections').get().then(async function (snapshots) {
                        snapshots.docs.forEach((listval) => {
                            var data = listval.data();
                            if (data.id == vendor.section_id) {
                                $(".vendor_section").text(data.name);
                                if (data.serviceTypeFlag == "delivery-service") {
                                    $('.multivendor_status_div').removeClass('d-none');
                                } else {
                                    $('.multivendor_status_div').html('');
                                }
                            }
                        })
                    });

                    $(".vendor_address").text(vendor.location);
                    $(".vendor_latitude").text(vendor.latitude);
                    $(".vendor_longitude").text(vendor.longitude);
                    $(".vendor_description").text(vendor.description);
                    vendorOwnerOnline = vendor.isActive;
                    photo = vendor.photo;
                    vendorOwnerId = vendor.author;
                    await database.collection('users').where("id", "==", vendor.author).get().then(async function (snapshots) {
                        snapshots.docs.forEach((listval) => {
                            var user = listval.data();
                            $(".vendor_email").html(user.email);
                            $(".vendor_phoneNumber").html(user.phoneNumber);
                        })
                    });

                    await database.collection('vendor_categories').get().then(async function (snapshots) {
                        snapshots.docs.forEach((listval) => {
                            var data = listval.data();
                            if (data.id == vendor.categoryID) {
                                $('#vendor_cuisines').append($("<option selected></option>")
                                    .attr("value", data.id)
                                    .text(data.title));
                            } else {
                                $('#vendor_cuisines').append($("<option></option>")
                                    .attr("value", data.id)
                                    .text(data.title));
                            }
                        })

                    });

                    if (vendor.hasOwnProperty('phonenumber')) {
                        $(".vendor_phone").text(vendor.phonenumber);
                    }
                } else {
                    $('.vendor_detail_div').html('<h5 class="text-danger text-center font-weight-bold">{{trans("lang.vendor_unknown_deleted")}}</h5>')
                }
                jQuery("#data-table_processing").hide();
            })


            $(".save_vendor_btn").click(function () {
                var vendorname = $(".vendor_name").val();
                var cuisines = $("#vendor_cuisines option:selected").val();
                var address = $(".vendor_address").val();
                var latitude = parseFloat($(".vendor_latitude").val());
                var longitude = parseFloat($(".vendor_longitude").val());
                var description = $(".vendor_description").val();
                var phonenumber = $(".vendor_phone").val();
                var categoryTitle = $("#vendor_cuisines option:selected").text();

                database.collection('vendors').doc(id).update({
                    'title': vendorname,
                    'description': description,
                    'latitude': latitude,
                    'longitude': longitude,
                    'location': address,
                    'photo': photo,
                    'categoryID': cuisines,
                    'phonenumber': phonenumber,
                    'categoryTitle': categoryTitle
                }).then(function (result) {
                    window.location.href = '{{ route("vendors")}}';
                });
            })

        })

        async function getWalletBalance(vendorId) {
            database.collection('users').where('id', '==', vendorId).get().then(async function (snapshot) {
                if (snapshot.docs.length > 0) {
                    restaurant = snapshot.docs[0].data();
                    var wallet_balance = 0;

                    if (restaurant.hasOwnProperty('wallet_amount') && restaurant.wallet_amount != null && !isNaN(restaurant.wallet_amount)) {
                        wallet_balance = restaurant.wallet_amount;
                    }
                    if (currencyAtRight) {
                        wallet_balance = parseFloat(wallet_balance).toFixed(decimal_degits) + "" + currentCurrency;
                    } else {
                        wallet_balance = currentCurrency + "" + parseFloat(wallet_balance).toFixed(decimal_degits);
                    }

                    $('.wallet').html(wallet_balance);

                }
            });

        }

        var storageRef = firebase.storage().ref('images');

        function handleFileSelect(evt) {
            var f = evt.target.files[0];
            var reader = new FileReader();
            reader.onload = (function (theFile) {
                return function (e) {

                    var filePayload = e.target.result;
                    var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                    var val = f.name;
                    var ext = val.split('.')[1];
                    var docName = val.split('fakepath')[1];
                    var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                    var timestamp = Number(new Date());
                    var uploadTask = storageRef.child(filename).put(theFile);
                    console.log(uploadTask);
                    uploadTask.on('state_changed', function (snapshot) {

                        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        console.log('Upload is ' + progress + '% done');
                        jQuery("#uploding_image").text("Image is uploading...");
                    }, function (error) {
                    }, function () {
                        uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                            jQuery("#uploding_image").text("Upload is completed");
                            photo = downloadURL;

                        });
                    });

                };
            })(f);
            reader.readAsDataURL(f);
        }

        async function getTotalOrders() {

            await database.collection('vendor_orders').where('vendorID', '==', '<?php echo $id; ?>').get().then(async function (orderSnapshots) {
                var paymentData = orderSnapshots.docs;
                $("#total_orders").text(paymentData.length);
            })
        }

        async function getTotalItems() {

            await database.collection('vendor_products').where('vendorID', '==', '<?php echo $id; ?>').get().then(async function (orderSnapshots) {
                var itemsData = orderSnapshots.docs;
                $("#total_items").text(itemsData.length);
            })
        }

        async function getTotalEarnings() {
            var totalEarning = 0;
            var adminCommission = 0;
            await database.collection('vendor_orders').where('vendorID', '==', '<?php echo $id; ?>').where('status', 'in', ["Order Completed"]).get().then(async function (orderSnapshots) {
                var paymentData = orderSnapshots.docs;
                paymentData.forEach((order) => {
                    var orderData = order.data();
                    var price = 0;
                    if (orderData.adminCommission != undefined) {
                        var commission = parseInt(orderData.adminCommission);
                        adminCommission = commission + adminCommission;
                    }
                    orderData.products.forEach((product) => {

                        if (product.price && product.quantity != 0) {
                            var productTotal = parseInt(product.price) * parseInt(product.quantity);
                            price = price + productTotal;
                        }
                    })
                    totalEarning = totalEarning + price;
                })

                if (currencyAtRight) {
                    totalEarningwithCurrency = parseFloat(totalEarning).toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    totalEarningwithCurrency = currentCurrency + "" + parseFloat(totalEarning).toFixed(decimal_degits);
                }

                $("#total_earnings").text(totalEarningwithCurrency);

            })
            return totalEarning;
        }


        async function getTotalpayment(driverID) {
            var paid_price = 0;
            var total_price = 0;
            var remaining = 0;
            await database.collection('payouts').where('vendorID', '==', '<?php echo $id; ?>').get().then(async function (payoutSnapshots) {
                payoutSnapshots.docs.forEach((payout) => {
                    var payoutData = payout.data();
                    if (payoutData.amount && parseFloat(payoutData.amount) != undefined && parseFloat(payoutData.amount) != '' && parseFloat(payoutData.amount) != NaN) {
                        paid_price = parseFloat(paid_price) + parseFloat(payoutData.amount);
                    }

                })
            });

            if (currencyAtRight) {
                paid_price_with_currency = parseFloat(paid_price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                paid_price_with_currency = currentCurrency + "" + parseFloat(paid_price).toFixed(decimal_degits);
            }

            $("#total_payment").text(paid_price_with_currency);
            return paid_price;
        }

        $("#add-wallet-btn").click(function () {
            var date = firebase.firestore.FieldValue.serverTimestamp();
            var amount = $('#amount').val();
            if (amount == '' || amount <= 0) {
                $('#wallet_error').text('{{trans("lang.add_wallet_amount_error")}}');
                return false;
            }
            var note = $('#note').val();
            database.collection('users').where('id', '==', vendorOwnerId).get().then(async function (snapshot) {

                if (snapshot.docs.length > 0) {
                    var data = snapshot.docs[0].data();
                    var walletAmount = 0;
                    if (data.hasOwnProperty('wallet_amount') && !isNaN(data.wallet_amount) && data.wallet_amount != null) {
                        walletAmount = data.wallet_amount;
                    }

                    user_id = data.id;
                    var newWalletAmount = parseFloat(walletAmount) + parseFloat(amount);
                    database.collection('users').doc(vendorOwnerId).update({
                        'wallet_amount': newWalletAmount
                    }).then(function (result) {
                        var tempId = database.collection("tmp").doc().id;
                        database.collection('wallet').doc(tempId).set({
                            'amount': parseFloat(amount),
                            'date': date,
                            'isTopUp': true,
                            'id': tempId,
                            'order_id': '',
                            'payment_method': 'Wallet',
                            'payment_status': 'success',
                            'user_id': user_id,
                            'note': note,
                            'transactionUser': "vendor",

                        }).then(async function (result) {
                            if (currencyAtRight) {
                                amount = parseInt(amount).toFixed(decimal_degits) + "" + currentCurrency;
                                newWalletAmount = newWalletAmount.toFixed(decimal_degits) + "" + currentCurrency;
                            } else {
                                amount = currentCurrency + "" + parseInt(amount).toFixed(decimal_degits);
                                newWalletAmount = currentCurrency + "" + newWalletAmount.toFixed(decimal_degits);
                            }

                            var formattedDate = new Date();
                            var month = formattedDate.getMonth() + 1;
                            var day = formattedDate.getDate();
                            var year = formattedDate.getFullYear();

                            month = month < 10 ? '0' + month : month;
                            day = day < 10 ? '0' + day : day;

                            formattedDate = day + '-' + month + '-' + year;

                            var message = emailTemplatesData.message;
                            message = message.replace(/{username}/g, data.firstName + ' ' + data.lastName);
                            message = message.replace(/{date}/g, formattedDate);
                            message = message.replace(/{amount}/g, amount);
                            message = message.replace(/{paymentmethod}/g, 'Wallet');
                            message = message.replace(/{transactionid}/g, tempId);
                            message = message.replace(/{newwalletbalance}/g, newWalletAmount);

                            emailTemplatesData.message = message;

                            var url = "{{url('send-email')}}";
                            if(data.email != '' && data.email != null){
                            var sendEmailStatus = await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [data.email]);

                            if (sendEmailStatus) {
                                window.location.reload();
                            }
                        }else{
                            window.location.reload();
                        }
                        })
                    })
                } else {
                    $('#user_account_not_found_error').text('{{trans("lang.user_detail_not_found")}}');
                }
            });

        });


    </script>
@endsection
