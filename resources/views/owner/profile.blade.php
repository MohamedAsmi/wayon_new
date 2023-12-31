@extends('owner.template')
@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('public/js/intl-tel-input-13.0.0/build/css/intlTelInput.css')}}">
@endpush

@section('main')
<div class="margin-top-85">
    <div class="row m-0">
        <!-- sidebar start-->
        @include('owner.common.sidebar')
        <!--sidebar end-->
        <div class="col-lg-10 p-0">
            <div class="container-fluid min-height">
                <div class="col-md-12 mt-5">
                    <div class="main-panel">
                        @include('owner.profile_nav')

                        <!--Success Message -->
                        @if(Session::has('message'))
                            <div class="row mt-5">
                                <div class="col-md-12  alert {{ Session::get('alert-class') }} alert-dismissable fade in top-message-text opacity-1">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ Session::get('message') }}
                                </div>
                            </div>
                        @endif 

                        <div class="row justify-content-center mt-5 border rounded-3 mb-5 pt-2 pb-2">
                            <div class="col-md-12 p-4">
                                <form id='profile_update' method='post' action="{{url('owner/profile')}}" onsubmit="return ageValidate();">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" name="customer_id" id="user_id" value="{{Auth::guard('owner')->user()->id}}">
                                      
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="user_first_name">User Name<span class="text-danger">*</span></label>
                                                <input class='form-control text-16' type='text' name='username' value="{{$profile->username}}" id='username' size='30'>
                                                @if ($errors->has('username')) <p class="error-tag">{{ $errors->first('username') }}</p> @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="user_email"> {{trans('messages.users_profile.email_address')}}   
                                                    <span class="text-danger">*</span>
                                                    <i class="icon icon-lock" data-behavior="tooltip" aria-label="Private"></i>
                                                </label>

                                                <input class='form-control  text-16' type='text' name='email' value="{{$profile->email}}" id='email' size='30'>
                                                    @if ($errors->has('email')) <p class="error-tag">{{ $errors->first('email') }}</p> @endif
                                            </div>
                                        </div>

                                        

                                        <div class="col-md-12 p-0">
                                            <div class="p-4">
                                                <button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-4 pr-4 pt-3 pb-3 float-right pl-4 pr-4 mb-4" id="save_btn"><i class="spinner fa fa-spinner fa-spin d-none"></i>
                                                    <span id="save_btn-text">{{trans('messages.users_profile.save')}}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript"  src="{{ asset('public/js/intl-tel-input-13.0.0/build/js/intlTelInput.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('public/js/isValidPhoneNumber.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('select').on('change', function() {
        var dobError = '';
        var day = document.getElementById("user_birthday_day").value;
        var month = document.getElementById("user_birthday_month").value;
        var y = document.getElementById("user_birthday_year").value;
        var year = parseInt(y);
        var year2 = profile_update.birthday_year;
        var age = 18;
        var setDate = new Date(year + age, month - 1, day);
        var currdate = new Date();
        if (day == '' || month == '' || y == '') {
            $('#dobError').html('<label class="text-danger">' + "{{ __('messages.jquery_validation.required') }}" + '</label>');
            year2.focus();
            return false;
        }
    
        else if (setDate > currdate) {
            $('#dobError').html('<label class="text-danger">' + "{{ __('messages.jquery_validation.age_greater_than_18') }}" + '</label>');
            year2.focus();
            return false;
        } else {
            $('#dobError').html('<span class="text-success"></span>');
            return true;
        }
    });

    function ageValidate() {
        var dobError = '';
        var day = document.getElementById("user_birthday_month").value;
        var month = document.getElementById("user_birthday_day").value;
        var y = document.getElementById("user_birthday_year").value;
        var year = parseInt(y);
        var year2 = profile_update.birthday_year;
        var age = 18;

        var setDate = new Date(year + age, month - 1, day);
        var currdate = new Date();
        if (day == '' || month == '' || y == '') {
            $('#dobError').html('<label class="text-danger">' + "{{ __('messages.jquery_validation.required') }}" + '</label>');
            year2.focus();
            return false;
        }
        //window.alert(setDate);
        else if (setDate > currdate) {
            //window.alert(setDate);
            $('#dobError').html('<label class="text-danger">' + "{{ __('messages.jquery_validation.age_greater_than_18') }}" + '</label>');
            year2.focus();
            return false;
        } else {
            $('#dobError').html('<span class="text-success"></span>');
            return true;
        }
    }
</script>

<script type="text/javascript">
    jQuery.validator.addMethod("laxEmail", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
    }, "{{ __('messages.jquery_validation.email') }}");

    $(document).ready(function() {
        $('#profile_update').validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 255
                },
                last_name: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    laxEmail: true
                }
            },
            submitHandler: function(form)
            {
                $("#save_btn").on("click", function (e)
                {   
                    $("#save_btn").attr("disabled", true);
                    e.preventDefault();
                });

                $(".spinner").removeClass('d-none');
                $("#save_btn-text").text("{{trans('messages.users_profile.save')}} ..");
                return true;
            },
            messages: {
                first_name: {
                    required: "{{ __('messages.jquery_validation.required') }}",
                    maxlength: "{{ __('messages.jquery_validation.maxlength255') }}",
                },
                last_name: {
                    required: "{{ __('messages.jquery_validation.required') }}",
                    maxlength: "{{ __('messages.jquery_validation.maxlength255') }}",
                },
                email: {
                    required: "{{ __('messages.jquery_validation.required') }}",
                    maxlength: "{{ __('messages.jquery_validation.maxlength255') }}",
                },
            }
        });
    });

  // flag for button disable/enable
    var hasPhoneError = false;
    var hasEmailError = false;

  //jquery validation
    $.validator.setDefaults({
        highlight: function(element) {
            $(element).parent('div').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent('div').removeClass('has-error');
        },
        errorPlacement: function(error, element) {
            $('#tel-error').html('').hide();
            error.insertAfter(element);
        }
    });

    /*
    intlTelInput
    */
    $(document).ready(function() {
        $("#phone").intlTelInput({
            separateDialCode: true,
            nationalMode: true,
            preferredCountries: ["us"],
            autoPlaceholder: "polite",
            placeholderNumberType: "MOBILE",
            utilsScript: '{{ URL::to('/') }}/public/js/intl-tel-input-13.0.0/build/js/utils.js'
        });

        var countryData = $("#phone").intlTelInput("getSelectedCountryData");
        $('#default_country').val(countryData.iso2);
        $('#carrier_code').val(countryData.dialCode);

        $("#phone").on("countrychange", function(e, countryData) {
            formattedPhone();
            // log(countryData);
            $('#default_country').val(countryData.iso2);
            $('#carrier_code').val(countryData.dialCode);
            if ($.trim($(this).val()) !== '') {
                //Invalid Number Validation - Add
                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html('Please enter a valid International Phone Number.').css("font-weight", "bold");
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#phone-error').hide();
                } else {
                    $('#tel-error').html('');

                    $.ajax({
                            method: "POST",
                            url: "{{url('duplicate-phone-number-check-for-existing-customer')}}",
                            dataType: "json",
                            cache: false,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'phone': $.trim($(this).val()),
                                'carrier_code': $.trim(countryData.dialCode),
                                'id': $('#user_id').val(),
                            }
                        })
                        .done(function(response) {
                            if (response.status == true) {
                                $('#tel-error').html('');
                                $('#phone-error').show();

                                $('#phone-error').addClass('error').html(response.fail).css("font-weight", "bold");
                                hasPhoneError = true;
                                enableDisableButton();
                            } else if (response.status == false) {
                                $('#tel-error').show();
                                $('#phone-error').html('');

                                hasPhoneError = false;
                                enableDisableButton();
                            }
                        });
                }
            } else {
                $('#tel-error').html('');
                $('#phone-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
        });
    });
    /*
    intlTelInput
    */

  // Validate phone via Ajax
    $(document).ready(function() {
        $("input[name=phone]").on('blur keyup', function(e) {
            formattedPhone();
            if ($.trim($(this).val()) !== '') {
                if (!$(this).intlTelInput("isValidNumber") || !isValidPhoneNumber($.trim($(this).val()))) {
                    $('#tel-error').addClass('error').html('Please enter a valid International Phone Number.').css("font-weight", "bold");
                    hasPhoneError = true;
                    enableDisableButton();
                    $('#phone-error').hide();
                } else {
                    var phone = $(this).val().replace(/-|\s/g, ""); //replaces 'whitespaces', 'hyphens'
                    var phone = $(this).val().replace(/^0+/, ""); //replaces (leading zero - for BD phone number)
                    var token = "{{csrf_token()}}";
                    var customer_id = $('#user_id').val();

                    var pluginCarrierCode = $('#phone').intlTelInput('getSelectedCountryData').dialCode;
                    $.ajax({
                            url: "{{url('duplicate-phone-number-check-for-existing-customer')}}",
                            method: "POST",
                            dataType: "json",
                            data: {
                                'phone': phone,
                                'carrier_code': pluginCarrierCode,
                                '_token': "{{csrf_token()}}",
                                'id': customer_id
                            }
                        })
                        .done(function(response) {
                            if (response.status == true) {
                                if (phone.length == 0) {
                                    $('#phone-error').html('');
                                } else {
                                    $('#phone-error').addClass('error').html("The number has already been taken!").css("font-weight", "bold");
                                    hasPhoneError = true;
                                    enableDisableButton();
                                }
                            } else if (response.status == false) {
                                $('#phone-error').html('');
                                hasPhoneError = false;
                                enableDisableButton();
                            }
                        });
                    $('#tel-error').html('');
                    $('#phone-error').show();
                    hasPhoneError = false;
                    enableDisableButton();
                }
            } else {
                $('#tel-error').html('');
                $('#phone-error').html('');
                hasPhoneError = false;
                enableDisableButton();
            }
        });
    });

    function formattedPhone() {
        if ($('#phone').val != '') {
            var p = $('#phone').intlTelInput("getNumber").replace(/-|\s/g, "");
            $("#formatted_phone").val(p);
        }
    }

    /**
     * [check submit button should be disabled or not]
     * @return {void}
     */
    function enableDisableButton() {
        if (!hasPhoneError && !hasEmailError) {
            $('form').find("button[type='submit']").prop('disabled', false);
        } else {
            $('form').find("button[type='submit']").prop('disabled', true);
        }
    }
</script>
@endpush

