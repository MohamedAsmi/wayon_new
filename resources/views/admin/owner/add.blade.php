@php 
$form_data = [
    'page_title'=> 'Add Hotel Owner User Form',
    'page_subtitle'=> 'Add Owner', 
    'form_name' => 'Owner Add Form',
    'form_id' => 'add_owner',
    'action' => URL::to('/').'/admin/add-owner',
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => 'Username', 'name' => 'username', 'value' => ''],
        ['type' => 'text', 'class' => '', 'label' => 'Email', 'name' => 'email', 'value' => ''],
        ['type' => 'password', 'class' => '', 'label' => 'Password', 'name' => 'password', 'value' => ''],
        ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => ''],
    ]
];
@endphp
@include("admin.common.form.primary", $form_data)

<script type="text/javascript">

    jQuery.validator.addMethod("laxEmail", function(value, element) {
        return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
    }, 'Please enter a valid email address.');

    $(document).ready(function () {
            $('#add_owner').validate({
                rules: {
                    username: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        maxlength: 255,
                        laxEmail: true
                    },
                    password: {
                        required: true,
                        maxlength: 50,
                        minlength: 6
                    }
                }
            });
        });
</script>