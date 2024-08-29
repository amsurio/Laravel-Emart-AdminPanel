@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.providers_plural')}}</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('providers') !!}">{{trans('lang.providers_plural')}}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.providers_create')}}</li>
            </ol>
        </div>

        <div>

            <div class="card-body">

                <div id="data-table_processing" class="dataTables_processing panel panel-default"
                    style="display: none;">{{trans('lang.processing')}}</div>
                <div class="error_top"></div>

                <div class="row vendor_payout_create">
                    <div class="vendor_payout_create-inner">
                        <fieldset>
                            <legend>{{trans('lang.provider_info')}}</legend>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_first_name"
                                        onkeypress="return chkAlphabets(event,'error')" required>
                                    <div id="error" class="err"></div>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_first_name_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.last_name')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_last_name"
                                        onkeypress="return chkAlphabets(event,'error1')">
                                    <div id="error1" class="err"></div>
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_last_name_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.email')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_email">
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_email_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.password')}}</label>
                                <div class="col-7">
                                    <input type="password" class="form-control user_password">
                                    <div class="form-text text-muted">
                                        {{ trans("lang.user_password_help") }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row width-50">
                                <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control user_phone"
                                        onkeypress="return chkAlphabets2(event,'error1')">
                                    <div id="error1" class="err"></div>
                                    <div class="form-text text-muted w-50">
                                        {{ trans("lang.user_phone_help") }}
                                    </div>
                                </div>

                            </div>

                <div class="form-group row width-100">
                    <label class="col-3 control-label">{{trans('lang.user_profile_picture')}}</label>
                    <input type="file" onChange="handleFileSelectowner(event)" class="col-7">
                    <div id="uploding_image_owner"></div>
                    <div class="uploaded_image_owner" style="display:none;"><img id="uploaded_image_owner" src=""
                            width="150px" height="150px;"></div>
                </div>
                </fieldset>

                <fieldset>
                    <legend>{{trans('lang.active')}}</legend>
                    <div class="form-group row width-100">
                        <div class="form-check">
                            <input type="checkbox" class="user_active" id="user_active">
                            <label class="col-3 control-label" for="user_active">{{trans('lang.active')}}</label>

                        </div>
                    </div>

                </fieldset>
                <fieldset>
                    <legend>{{trans('lang.bankdetails')}}</legend>
                    <div class="form-group row width-100" style="display: none;" id="companyDriverShowDiv">
                        <div class="col-12">
                            <h6><a href="#">{{ trans("lang.driver_add_by_company_info") }}</a>
                            </h6>
                        </div>
                    </div>
                    <div class="form-group row" id="companyDriverHideDiv">

                        <div class="form-group row width-100">
                            <label class="col-4 control-label">{{trans('lang.bank_name')}}</label>
                            <div class="col-7">
                                <input type="text" name="bank_name" class="form-control" id="bankName">
                            </div>
                        </div>

                        <div class="form-group row width-100">
                            <label class="col-4 control-label">{{trans('lang.branch_name')}}</label>
                            <div class="col-7">
                                <input type="text" name="branch_name" class="form-control" id="branchName">
                            </div>
                        </div>


                        <div class="form-group row width-100">
                            <label class="col-4 control-label">{{trans('lang.holder_name')}}</label>
                            <div class="col-7">
                                <input type="text" name="holer_name" class="form-control" id="holderName">
                            </div>
                        </div>

                        <div class="form-group row width-100">
                            <label class="col-4 control-label">{{trans('lang.account_number')}}</label>
                            <div class="col-7">
                                <input type="text" name="account_number" class="form-control"
                                    onkeypress="return chkAlphabets2(event,'error5')" id="accountNumber">
                                <div id="error5" class="err"></div>
                            </div>
                        </div>

                        <div class="form-group row width-100">
                            <label class="col-4 control-label">{{trans('lang.other_information')}}</label>
                            <div class="col-7">
                                <input type="text" name="other_information" class="form-control" id="otherDetails">
                            </div>
                        </div>

                    </div>
                </fieldset>

            </div>
        </div>
    </div>

    <div class="form-group col-12 text-center btm-btn">
        <button type="button" class="btn btn-primary  create_vendor_btn"><i class="fa fa-save"></i> {{
            trans('lang.save')}}</button>
        <a href="{!! route('providers') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{
            trans('lang.cancel')}}</a>
    </div>

</div>

</div>

</div>

@endsection

@section('scripts')

<script type="text/javascript">

    var database = firebase.firestore();
    var geoFirestore = new GeoFirestore(database);
    var autoAprroveVendor = database.collection('settings').doc("vendor");
    var photo = "";
    var vendorOwnerId = "";
    var vendorOwnerOnline = false;
    var photocount = 0;
    var restaurnt_photos = [];
    var ownerphoto = '';
    var createdAt = firebase.firestore.FieldValue.serverTimestamp();
    $(".create_vendor_btn").click(function () {
        $(".error_top").hide();
        var latitude = parseFloat(0.01);
        var longitude = parseFloat(0.01);

        var userFirstName = $(".user_first_name").val();
        var userLastName = $(".user_last_name").val();
        var email = $(".user_email").val();
        var password = $(".user_password").val();
        var userPhone = $(".user_phone").val();
        var active = $(".user_active").is(":checked");
        var location = { 'latitude': latitude, 'longitude': longitude };
        var user_name = userFirstName + " " + userLastName;
        var user_id = "<?php echo uniqid(); ?>";


        if (userFirstName == '') {

            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_name_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (email == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_email')}}</p>");
            window.scrollTo(0, 0);
        } else if (password == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_password_error')}}</p>");
            window.scrollTo(0, 0);
        } else if (userPhone == '') {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>{{trans('lang.enter_owners_phone')}}</p>");
            window.scrollTo(0, 0);


        } else {

            var bankName = $("#bankName").val();
            var branchName = $("#branchName").val();
            var holderName = $("#holderName").val();
            var accountNumber = $("#accountNumber").val();
            var otherDetails = $("#otherDetails").val();
            var userBankDetails = {
                'bankName': bankName,
                'branchName': branchName,
                'holderName': holderName,
                'accountNumber': accountNumber,
                'accountNumber': accountNumber,
                'otherDetails': otherDetails,
            };

            firebase.auth().createUserWithEmailAndPassword(email, password)
                .then(function (firebaseUser) {
                    user_id = firebaseUser.user.uid;
                    database.collection('users').doc(user_id).set({

                        'firstName': userFirstName,
                        'lastName': userLastName,
                        'email': email,
                        'phoneNumber': userPhone,
                        'profilePictureURL': ownerphoto,
                        'role': 'provider',
                        'id': user_id,
                        'location': location,
                        'active': active,
                        'isActive': active,
                        createdAt: createdAt,
                        'userBankDetails': userBankDetails,
                        'wallet_amount': 0,
                        'reviewsCount': 0,
                        'reviewsSum': 0,

                    }).then(function (result) {

                        setTimeout(function () {
                            window.location.href = '{{ route("providers")}}';
                        }, 5000);



                    }).catch(function (error) {

                        $(".error_top").show();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + error + "</p>");
                    });


                })

        }
    });



    var storageRef = firebase.storage().ref('images');

    function handleFileSelectowner(evt) {
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
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
                var uploadTask = storageRef.child(filename).put(theFile);
                console.log(uploadTask);
                uploadTask.on('state_changed', function (snapshot) {

                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log('Upload is ' + progress + '% done');
                    jQuery("#uploding_image_owner").text("Image is uploading...");
                }, function (error) {
                }, function () {
                    uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                        jQuery("#uploding_image_owner").text("Upload is completed");
                        ownerphoto = downloadURL;

                        $("#uploaded_image_owner").attr('src', ownerphoto);
                        $(".uploaded_image_owner").show();

                    });
                });

            };
        })(f);
        reader.readAsDataURL(f);
    }
    function chkAlphabets(event, msg) {
        if (!(event.which >= 97 && event.which <= 122) && !(event.which >= 65 && event.which <= 90)) {
            document.getElementById(msg).innerHTML = "Accept only Alphabets";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

    function chkAlphabets2(event, msg) {
        if (!(event.which >= 48 && event.which <= 57)
        ) {
            document.getElementById(msg).innerHTML = "Accept only Number";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

    function chkAlphabets3(event, msg) {
        if (!((event.which >= 48 && event.which <= 57) || (event.which >= 97 && event.which <= 122))) {
            document.getElementById(msg).innerHTML = "Special characters not accepted ";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }
</script>
@endsection