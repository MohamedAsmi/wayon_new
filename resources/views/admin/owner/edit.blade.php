@php 
$form_data = [
    'page_title'=> 'Edit Hotel Owner User Form',
    'page_subtitle'=> 'Edit Owner', 
    'form_name' => 'Owner Edit Form',
    'form_id' => 'edit_owner',
    'action' => URL::to('/').'/admin/edit-owner/'.$result->id,
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => 'Username', 'name' => 'username', 'value' => $result->username],
        ['type' => 'text', 'class' => '', 'label' => 'Email', 'name' => 'email', 'value' => $result->email],
        ['type' => 'password', 'class' => '', 'label' => 'Password', 'name' => 'password', 'value' => '', 'hint' => 'Enter new password only. Leave blank to use existing password.'],
        ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => $result->status],
    ]
];
@endphp
@include("admin.common.form.primary", $form_data)

<script type="text/javascript">

    jQuery.validator.addMethod("laxEmail", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
    }, 'Please enter a valid email address.');

    $(document).ready(function () {
            $('#edit_owner').validate({
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
                        maxlength: 50,
                        minlength: 6,
                    }
                }
            });
        });
</script>