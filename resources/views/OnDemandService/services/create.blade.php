@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">

        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.service_plural')}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! route('dashboard') !!}">{{trans('lang.dashboard')}}</a></li>
                 @if(!isset($_GET['id']))
                <li class="breadcrumb-item"><a href="{!! route('ondemand.services.index') !!}">{{trans('lang.service_plural')}}</a></li>
                @else
                <li class="breadcrumb-item"><a href="{!! route('ondemand.services.index',@$_GET['id']) !!}">{{trans('lang.service_plural')}}</a></li>
                @endif
                <li class="breadcrumb-item active">{{trans('lang.service_create')}}</li>
            </ol>
        </div>
    </div>

    <div>
        <div class="card-body">
            <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
                {{trans('lang.processing')}}
            </div>
            <div class="error_top" style="display:none"></div>
            <div class="row vendor_payout_create">
                <div class="vendor_payout_create-inner">

                    <fieldset>
                        <legend>{{trans('lang.service_information')}}</legend>

                        <div class="form-group row width-50">
                            <input type="hidden" class="form-control author_name">
                            <input type="hidden" class="form-control author_profile">

                            <label class="col-3 control-label">{{trans('lang.service_name')}}</label>
                            <div class="col-7">
                                <input type="text" class="form-control service_name" required>
                                <div class="form-text text-muted">
                                    {{ trans("lang.service_name_help") }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row width-50">
                            <label class="col-3 control-label ">{{trans('lang.select_section')}}</label>
                            <div class="col-7">
                                <select name="section_id" class="form-control" id="section_id">
                                    <option value="">{{trans('lang.select_section')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.item_category_id')}}</label>
                            <div class="col-7">
                                <select id='item_category' class="form-control" required>
                                    <option value="">{{trans('lang.select_category')}}</option>
                                </select>
                                <div class="form-text text-muted">
                                    {{ trans("lang.item_category_id_help") }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.sub_category_id')}}</label>
                            <div class="col-7">
                                <select id='sub_category' class="form-control" required>
                                    <option value="">{{trans('lang.select_sub_category')}}</option>
                                </select>
                                <div class="form-text text-muted">
                                    {{ trans("lang.select_sub_category") }}
                                </div>
                            </div>
                        </div>
                        @if(!isset($_GET['id']))
                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.provider')}}</label>
                            <div class="col-7">
                                <select id="provider_select" class="form-control">
                                    <option value="">{{trans('lang.select_provider')}}</option>
                                </select>
                                <div class="form-text text-muted">
                                    {{ trans("lang.provider_help") }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.price')}}</label>
                            <div class="col-7">
                                <input type="number" class="form-control price" required>
                                <div class="form-text text-muted">
                                    {{ trans("lang.item_price_help") }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.item_discount')}}</label>
                            <div class="col-7">
                                <input type="number" class="form-control item_discount">
                                <div class="form-text text-muted">
                                    {{ trans("lang.item_discount_help") }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.price_unit')}}</label>
                            <div class="col-7">
                                <select id='price_unit' name="price_unit" class="form-control" required>
                                <option value="Hourly">{{trans('lang.hourly')}}</option>
                                    <option value="Fixed">{{trans('lang.fixed')}}</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.item_image')}}</label>
                            <div class="col-7">
                                <input type="file" onChange="handleFileSelectProduct(event)">
                                <div class="placeholder_img_thumb service_image"></div>
                                <div id="uploding_image"></div>
                                <div class="form-text text-muted">
                                    {{ trans("lang.item_image_help") }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row width-50">
                            <div class="form-check">
                                <input type="checkbox" class="item_publish" id="item_publish">
                                <label class="col-3 control-label" for="item_publish">{{trans('lang.item_publish')}}</label>
                            </div>
                        </div>


                        <div class="form-group row width-100">
                            <label class="col-3 control-label">{{trans('lang.item_description')}}</label>
                            <div class="col-7">
                                <textarea rows="8" class="form-control item_description" id="item_description"></textarea>
                            </div>
                        </div>
                        <div class="form-group row width-100">
                            <label class="col-3 control-label">{{trans('lang.address')}}</label>
                            <div class="col-7">
                                <input type="text" class="form-control address" id="address" autocomplete="on">

                            </div>
                        </div>
                        <div class="form-group row width-100">
                            <label class="col-3 control-label">{{trans('lang.Days')}}</label>
                            <div class="col-7">
                                <input type="checkbox" class="days" name="days" id="monday" value="Monday">
                                <label class="col-3 control-label" for="monday">{{trans('lang.monday')}}</label>
                                <input type="checkbox" class="days" name="days" id="tuesday" value="Tuesday">
                                <label class="col-3 control-label" for="tuesday">{{trans('lang.tuesday')}}</label>
                                <input type="checkbox" class="days" name="days" id="wednesday" value="Wednesday">
                                <label class="col-3 control-label" for="wednesday">{{trans('lang.wednesday')}}</label>
                                <input type="checkbox" class="days" name="days" id="thursday" value="Thursday">
                                <label class="col-3 control-label" for="thursday">{{trans('lang.thursday')}}</label>
                                <input type="checkbox" class="days" name="days" id="friday" value="Friday">
                                <label class="col-3 control-label" for="friday">{{trans('lang.friday')}}</label>
                                <input type="checkbox" class="days" name="days" id="saturday" value="Saturday">
                                <label class="col-3 control-label" for="saturday">{{trans('lang.saturday')}}</label>
                                <input type="checkbox" class="days" name="days" id="sunday" value="Sunday">
                                <label class="col-3 control-label" for="sunday">{{trans('lang.sunday')}}</label>

                            </div>
                        </div>
                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.start_Time')}}</label>
                            <div class="col-7">
                                <input type="time" class="form-control" id="start_Time" required>
                            </div>
                        </div>

                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.end_Time')}}</label>
                            <div class="col-7">
                                <input type="time" class="form-control" id="end_Time" required>
                            </div>
                        </div>

                    </fieldset>
                </div>
            </div>

            <div class="form-group col-12 text-center btm-btn">
                <button type="button" class="btn btn-primary  create_item_btn"><i class="fa fa-save"></i>
                    {{trans('lang.save')}}
                </button>
                 @if(!isset($_GET['id']))
                <a href="{!! route('ondemand.services.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                @else
                <a href="{!! route('ondemand.services.index',$_GET['id']) !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<script>

    var database = firebase.firestore();
    var days = [];
    var authorName = '';
    var createdAt = firebase.firestore.FieldValue.serverTimestamp();
    var photos = [];
    var author = database.collection('users').orderBy('createdAt', 'desc');
    var categories = database.collection('provider_categories').where('publish', '==', true);
    var googleApiKey = '';
    var photos = [];
    var serviceImagesCount = 0;
    var provider_id="{{@$_GET['id']}}";
    var providerName='';
    var providerPic='';
    var providerPhone='';
    $(document).ready(function() {
        if(provider_id!=''){
            getProviderInfo(provider_id);
        }
        database.collection('sections').where('serviceTypeFlag', '==', 'ondemand-service').get().then(async function (snapshots) {
            snapshots.docs.forEach((listval) => {
                var data = listval.data();
                $('#section_id').append($("<option></option>")
                    .attr("value", data.id)
                    .attr("data-type", data.serviceTypeFlag)
                    .text(data.name + ' (' + data.serviceType + ')'));
            });
        });

        database.collection('users').where('role','==','provider').get().then(async function(snapshots) {
            snapshots.docs.forEach((listval) => {
                var data = listval.data();
                $('#provider_select').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.firstName+' '+data.lastName)
                        .attr("data-authorName",data.firstName+' '+data.lastName)
                        .attr("data-authorpic",data.profilePictureURL)
                        .attr("data-authorphone",data.phoneNumber));
            })
        });
        

        $('#section_id').on('change', function() {
            var section_id = $(this).val();
            if(section_id){
                categories.where('parentCategoryId', '==', null).where('sectionId', '==', section_id).get().then(async function(snapshots) {
                    if(snapshots.docs.length > 0){
                        $('#item_category').html('<option value="">{{trans("lang.select_category")}}</option>');
                        snapshots.docs.forEach((listval) => {
                            var data = listval.data();
                            $('#item_category').append($("<option></option>")
                                .attr("value", data.id)
                                .text(data.title));
                        });
                    }else{
                        $('#item_category').html('<option value="">{{trans("lang.select_category")}}</option>');        
                    }
                });
            }else{
                $('#item_category').html('<option value="">{{trans("lang.select_category")}}</option>');        
            }
            $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');        
        })

        $('#item_category').on('change', function() {
            var categoryId = $(this).val();
            if(categoryId){
                categories.where('parentCategoryId', '==', categoryId).get().then(async function(snapshots) {
                    if(snapshots.docs.length > 0){
                        $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');
                        snapshots.docs.forEach((listval) => {
                            var data = listval.data();
                            $('#sub_category').append($("<option></option>")
                                .attr("value", data.id)
                                .text(data.title));
                        });
                    }else{
                        $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');        
                    }
                });
            }else{
                $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');        
            }
        })

        function initialize(id) {
            var input = document.getElementById(id);
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                var placeaddress = autocomplete.getPlace().address_components;
                var city = place.address_components.filter(f => JSON.stringify(f.types) === JSON.stringify(['locality', 'political']))[0].long_name;
                var state = place.address_components.filter(f => JSON.stringify(f.types) === JSON.stringify(['administrative_area_level_1', 'political']))[0].long_name;
                var country = place.address_components.filter(f => JSON.stringify(f.types) === JSON.stringify(['country', 'political']))[0].long_name;
                $("#" + id).val(place.formatted_address).attr('data-latitude', place.geometry.location.lat()).attr('data-longitude', place.geometry.location.lng()).attr('data-city', city).attr('data-state', state).attr('data-country', country)
            });
        }

        $(document).on("click", "#address", function() {
            var id = $(this).attr('id');
            initialize(id);
        });

        $(".create_item_btn").click(function() {
            var id = database.collection("tmp").doc().id;
            var name = $(".service_name").val();
            var price = $(".price").val();
            var discount = $(".item_discount").val();
            var category = $("#item_category option:selected").val();
            var sub_category = $("#sub_category option:selected").val();
            var description = $("#item_description").val();
            var itemPublish = $(".item_publish").is(":checked");
            var price_unit = $("#price_unit option:selected").val();
            var address = $("#address").val();
            var startTime = $("#start_Time").val();
            var endTime = $("#end_Time").val();
            var longitude = parseFloat($('#address').attr('data-longitude'));
            var latitude = parseFloat($('#address').attr('data-latitude'));
            
            var selectedOption=$('#provider_select').find("option:selected");
            
            if(provider_id!=''){
                var providerId = provider_id;
                var authorName=providerName;
                var authorProfilePic=providerPic;
                var authorPhone=providerPhone;
            }else{
                var providerId = $("#provider_select").val();
                var authorName=selectedOption.attr("data-authorname");
                var authorProfilePic=selectedOption.attr("data-authorpic");
                var authorPhone=selectedOption.attr("data-authorphone");
            }  

            var section_id = $("#section_id").val();

            $("input:checkbox[name=days]:checked").each(function() {
                days.push($(this).val());
            });

            if (discount == '') {
                discount = "0";
            }
            if (photos != '') {
                photo = photos[0]
            }
           
            if (name == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.insert_service_name_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (section_id == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.select_section_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (category == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.select_service_category_error')}}</p>");
                window.scrollTo(0, 0);
            }else if (sub_category == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.select_service_sub_category_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (providerId == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.select_service_provider_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (price == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.insert_service_price_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (parseInt(price) < parseInt(discount)) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.price_should_not_less_then_discount_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (description == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.insert_service_description_error')}}</p>");
                window.scrollTo(0, 0);
            } else if ( isNaN(latitude) || isNaN(longitude)) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.service_select_address_error')}}</p>");
                window.scrollTo(0, 0);
            } else if ( days.length == 0) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.service_select_days_error')}}</p>");
                window.scrollTo(0, 0);
            } else if ( startTime == '' || endTime == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.service_select_time_error')}}</p>");
                window.scrollTo(0, 0);
            } else if ( startTime > endTime ) {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.start_time_grater_than_endtime_error')}}</p>");
                window.scrollTo(0, 0);
            }else {
                
                geoFirestore.collection('providers_services').doc(id).set({
                    "address": address,
                    'author':providerId,
                    'authorName': authorName,
                    'authorProfilePic': authorProfilePic,
                    'categoryId': category,
                    'createdAt': createdAt,
                    'days': days,
                    'description': description,
                    'disPrice': discount,
                    'id': id,
                    'latitude': latitude,
                    'longitude': longitude,
                    'phoneNumber':authorPhone,
                    'photos': photos,
                    'price': price,
                    'priceUnit': price_unit,
                    'publish': itemPublish,
                    'reviewsCount': 0,
                    'reviewsSum': 0,
                    'sectionId': section_id,
                    'startTime': startTime,
                    'endTime': endTime,
                    'subCategoryId': sub_category,
                    'title': name,                   
                    coordinates: new firebase.firestore.GeoPoint(latitude, longitude),

                }).then(function(result) {
                    if(provider_id==''){
                        window.location.href = '{{ route("ondemand.services.index")}}';
                    }else{
                        window.location.href = '{{ route("ondemand.services.index",@$_GET['id'])}}';
                    }
                    
                });
            }

        })
    })
    var storageRef = firebase.storage().ref('images');

    function handleFileSelectProduct(evt) {
        var f = evt.target.files[0];
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {

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
                uploadTask.on('state_changed', function(snapshot) {

                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log('Upload is ' + progress + '% done');

                    $('.service_image').find(".uploding_image_photos").text("Image is uploading...");

                }, function(error) {}, function() {
                    uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                        jQuery("#uploding_image").text("Upload is completed");
                        if (downloadURL) {

                            serviceImagesCount++;
                            photos_html = '<span class="image-item" id="photo_' + serviceImagesCount + '"><span class="remove-btn" data-id="' + serviceImagesCount + '" data-img="' + downloadURL + '"><i class="fa fa-remove"></i></span><img width="100px" id="" height="auto" src="' + downloadURL + '"></span>';
                            $(".service_image").append(photos_html);
                            photos.push(downloadURL);

                        }

                    });
                });

            };
        })(f);
        reader.readAsDataURL(f);
    }

    $(document).on("click", ".remove-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        $("#photo_" + id).remove();
        index = photos.indexOf(photo_remove);
        if (index > -1) {
            photos.splice(index, 1); // 2nd parameter means remove one item only
        }
    });

async function getProviderInfo(provider_id){
    await database.collection('users').where('id','==',provider_id).get().then(async function(snapshot){
        var provider_data=snapshot.docs[0].data();
        providerName=provider_data.firstName+' '+provider_data.lastName;
        providerPic=provider_data.profilePictureURL;
        providerPhone=provider_data.phoneNumber;
    });
}
</script>

@endsection