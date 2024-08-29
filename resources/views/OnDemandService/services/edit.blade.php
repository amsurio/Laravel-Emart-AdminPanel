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
                <li class="breadcrumb-item"><a href="{!! route('ondemand.services.index') !!}">{{trans('lang.service_plural')}}</a>
                </li>
                @else
                <li class="breadcrumb-item"><a href="{!! route('ondemand.services.index',@$_GET['id']) !!}">{{trans('lang.service_plural')}}</a>
                </li>
                @endif
                <li class="breadcrumb-item active">{{trans('lang.service_edit')}}</li>
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
                <div class="vendor_payout_create-inner service_detail_div">

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
                                <select id='item_category' name="item_category" class="form-control item_category" required>
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
                                <select id='sub_category' name="sub_category" class="form-control sub_category"
                                    required>
                                    <option value="">{{trans('lang.select_sub_category')}}</option>
                                </select>
                                <div class="form-text text-muted">
                                    {{ trans("lang.sub_category_id_help") }}
                                </div>
                            </div>
                        </div>
                   
                        <div class="form-group row width-50 provider-div">
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
                                <select id='price_unit' name="price_unit" class="form-control price_unit" required>
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
                                <label class="col-3 control-label"
                                    for="item_publish">{{trans('lang.item_publish')}}</label>
                            </div>
                        </div>


                        <div class="form-group row width-100">
                            <label class="col-3 control-label">{{trans('lang.item_description')}}</label>
                            <div class="col-7">
                                <textarea rows="8" class="form-control item_description"
                                    id="item_description"></textarea>
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
                                <input type="time" class="form-control start_Time" id="start_Time" required>
                            </div>
                        </div>

                        <div class="form-group row width-50">
                            <label class="col-3 control-label">{{trans('lang.end_Time')}}</label>
                            <div class="col-7">
                                <input type="time" class="form-control end_Time" id="end_Time" required>
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
                <a href="{!! route('ondemand.services.index') !!}" class="btn btn-default"><i
                        class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                 @else
                  <a href="{!! route('ondemand.services.index',@$_GET['id']) !!}" class="btn btn-default"><i
                        class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
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
    var Id = "<?php echo $id; ?>";
    var authorName = '';
    var photos = [];
    var providers_services = database.collection('providers_services').doc(Id);
    var categories = database.collection('provider_categories').where('publish', '==', true);
    var googleApiKey = '';
    var photos = [];
    var serviceImagesCount = 0;
    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
    var allowed_file_size = '';
    var idOfProviderDetailPage="{{@$_GET['id']}}";
    
    placeholder.get().then(async function (snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    })

    $(document).ready(function () {
        if(idOfProviderDetailPage!=''){
            $('.provider-div').css('display','none');
        }
        providers_services.get().then(async function (snapshots) {
            
            var serviceData =  snapshots.data();
            if(serviceData!=undefined){
            $(".service_name").val(serviceData.title)
            $(".price").val(serviceData.price)
            $(".item_discount").val(serviceData.disPrice)
            $("#item_description").val(serviceData.description);
            $("#address").val(serviceData.address);
            $('#address').val(serviceData.address).attr('data-latitude', serviceData.latitude).attr('data-longitude', serviceData.longitude);
            $("#start_Time").val(serviceData.startTime);
            $("#end_Time").val(serviceData.endTime);
            $("input:checkbox[name=days]").each(function (index) {
                var val = $(this).val();
                if (serviceData.days.includes(val)) {
                    $(this).prop('checked', true);
                }
            });

             if (serviceData.hasOwnProperty('priceUnit')) {
                $('#price_unit').val(serviceData.priceUnit).trigger('change');
            }
            if (serviceData.publish) {
                $("#item_publish").prop('checked', true);
            }
            if (serviceData.photos.length > 0) {
                photos = serviceData.photos;
            }
            if (photos.length > 0) {
                photos.forEach((element, index) => {
                    $(".service_image").append('<span class="image-item" id="photo_' + index + '"><span class="delete-btn" data-id="' + index + '" data-img="' + photos[index] + '"><i class="fa fa-remove"></i></span><img class="rounded" width="50px" id="" height="auto" src="' + photos[index] + '"></span>');
                })
            } else {
                $(".service_image").append('<span class="image-item" id="photo_1"><img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');
            }

            database.collection('sections').where('serviceTypeFlag', '==', 'ondemand-service').get().then(async function (snapshots) {
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    if (serviceData.sectionId == data.id) {
                        $('#section_id').append($("<option selected></option>")
                        .attr("value", data.id)
                        .attr("data-type", data.serviceTypeFlag)
                        .text(data.name + ' (' + data.serviceType + ')'));
                    }else{
                        $('#section_id').append($("<option></option>")
                        .attr("value", data.id)
                        .attr("data-type", data.serviceTypeFlag)
                        .text(data.name + ' (' + data.serviceType + ')'));
                    }
                });
                 $('#section_id').change();
            });

            database.collection('users').where('role','==','provider').get().then(async function(snapshots) {
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    if(serviceData.author == data.id){
                        $('#provider_select').append($("<option selected></option>")
                        .attr("value", data.id)
                        .text(data.firstName+' '+data.lastName)
                        .attr("data-authorName",data.firstName+' '+data.lastName)
                        .attr("data-authorpic",data.profilePictureURL)
                        .attr("data-authorphone",data.phoneNumber));
                    }else{
                        $('#provider_select').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.firstName+' '+data.lastName)
                        .attr("data-authorName",data.firstName+' '+data.lastName)
                        .attr("data-authorpic",data.profilePictureURL)
                        .attr("data-authorphone",data.phoneNumber));
                    }
                })
            });
            
            categories.where('parentCategoryId', '==', null).get().then(async function(snapshots) {
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    $('#item_category').append($("<option></option>")
                    .attr("value", data.id)
                    .text(data.title));
                });
            });

            $('#section_id').on('change', function() {
                var section_id = $(this).val();
                if(section_id){
                    categories.where('parentCategoryId', '==', null).where('sectionId', '==', section_id).get().then(async function(snapshots) {
                        if(snapshots.docs.length > 0){
                            $('#item_category').html('<option value="">{{trans("lang.select_category")}}</option>');
                            snapshots.docs.forEach((listval) => {
                                var data = listval.data();
                                if (serviceData.categoryId == data.id) {
                                    $('#item_category').append($("<option selected></option>")
                                    .attr("value", data.id)
                                    .text(data.title));
                                }else{
                                    $('#item_category').append($("<option></option>")
                                    .attr("value", data.id)
                                    .text(data.title));
                                }
                            });
                            $('#item_category').change();
                        }else{
                            $('#item_category').html('<option value="">{{trans("lang.select_category")}}</option>');        
                        }
                    });
                }else{
                    $('#item_category').html('<option value="">{{trans("lang.select_category")}}</option>');        
                }
                $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');        
            });

            $('#item_category').on('change', function() {
                var categoryId = $(this).val();
                if(categoryId){
                    categories.where('parentCategoryId', '==', categoryId).get().then(async function(snapshots) {
                        if(snapshots.docs.length > 0){
                            $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');
                            snapshots.docs.forEach((listval) => {
                                var data = listval.data();
                                if (serviceData.subCategoryId == data.id) {
                                    $('#sub_category').append($("<option selected></option>")
                                    .attr("value", data.id)
                                    .text(data.title));
                                }else{
                                    $('#sub_category').append($("<option></option>")
                                    .attr("value", data.id)
                                    .text(data.title));
                                }
                            });
                        }else{
                            $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');        
                        }
                    });
                }else{
                    $('#sub_category').html('<option value="">{{trans("lang.select_sub_category")}}</option>');        
                }
            })
        }else{
                $('.create_item_btn').hide();
                $('.service_detail_div').html('<h5 class="text-danger text-center font-weight-bold">{{trans("lang.service_unknown_deleted")}}</h5>')

        }
        });

        function initialize(id) {
            var input = document.getElementById(id);
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                var placeaddress = autocomplete.getPlace().address_components;
                var city = place.address_components.filter(f => JSON.stringify(f.types) === JSON.stringify(['locality', 'political']))[0].long_name;
                var state = place.address_components.filter(f => JSON.stringify(f.types) === JSON.stringify(['administrative_area_level_1', 'political']))[0].long_name;
                var country = place.address_components.filter(f => JSON.stringify(f.types) === JSON.stringify(['country', 'political']))[0].long_name;
                $("#" + id).val(place.formatted_address).attr('data-latitude', place.geometry.location.lat()).attr('data-longitude', place.geometry.location.lng()).attr('data-city', city).attr('data-state', state).attr('data-country', country)
            });
        }

        $(document).on("click", "#address", function () {
            var id = $(this).attr('id');
            initialize(id);
        });

        $(".create_item_btn").click(function () {
            var days=[];
            var name = $(".service_name").val();
            var price = $(".price").val();
            var discount = $(".item_discount").val();
            var category = $("#item_category option:selected").val();
            var sub_category = $("#sub_category option:selected").val();
            var description = $("#item_description").val();
            var itemPublish = $(".item_publish").is(":checked");
            var price_unit = $("#price_unit option:selected").val();
            var address = $("#address").val();
            var selectedOption=$('#provider_select').find("option:selected");
            var authorName=selectedOption.attr("data-authorname");
            var authorProfilePic=selectedOption.attr("data-authorpic");
            var authorPhone=selectedOption.attr("data-authorphone");
            var startTime = $("#start_Time").val();
            var endTime = $("#end_Time").val();
            var longitude = parseFloat($('#address').attr('data-longitude'));
            var latitude = parseFloat($('#address').attr('data-latitude'));
            var providerId = $("#provider_select").val();
            var section_id = $("#section_id").val();
        
            $("input:checkbox[name=days]:checked").each(function () {
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

                geoFirestore.collection('providers_services').doc(Id).update({
                    "address": address,
                    'author':providerId,
                    'authorName': authorName,
                    'authorProfilePic': authorProfilePic,
                    'categoryId': category,
                    'days': days,
                    'description': description,
                    'disPrice': discount,
                    'latitude': latitude,
                    'longitude': longitude,
                    'phoneNumber':authorPhone,
                    'photos': photos,
                    'price': price,
                    'priceUnit': price_unit,
                    'publish': itemPublish,
                    'sectionId': section_id,
                    'startTime': startTime,
                    'endTime': endTime,
                    'subCategoryId': sub_category,
                    'title': name,                   
                    coordinates: new firebase.firestore.GeoPoint(latitude, longitude),
                }).then(function (result) {
                     if(idOfProviderDetailPage!=''){
                        window.location.href = '{{ route("ondemand.services.index",@$_GET['id'])}}';

                     }else{
                       window.location.href = '{{ route("ondemand.services.index")}}';
                     }
                });
            }

        })
    });

    var storageRef = firebase.storage().ref('images');

    function handleFileSelectProduct(evt) {
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

                    $('.service_image').find(".uploding_image_photos").text("Image is uploading...");

                }, function (error) { }, function () {
                    uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
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
            photos.splice(index, 1);
        }
    });
    
    $(document).on("click", ".delete-btn", function () {
        var id = $(this).attr('data-id');
        var photo_remove = $(this).attr('data-img');
        $("#photo_" + id).remove();
        index = photos.indexOf(photo_remove);
        if (index > -1) {
            photos.splice(index, 1);
        }
    });
    
</script>
@endsection