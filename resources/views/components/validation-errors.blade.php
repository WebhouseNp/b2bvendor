@if ($errors->any())
<div class="validation-alert">
    <div class="head">
        Form Not Yet Submitted!
    </div>
    <div class="body">
        <p>
            Sorry, but the form was not submitted! Please correct the following errors and try again. 
        </p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
<style>
    .validation-alert {
        border: 1px solid #dc2626;
        border-radius: 2px;
        margin-bottom: 10px;
    }
    .validation-alert .head {
        background-color: #dc2626;
        color: #fefefe;
        padding: 5px 15px;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
    }
    .validation-alert .body {
        padding: 15px;
        background-color: rgba(250, 84, 84, 0.2);
    }
    .validation-alert ul {
        color: #dc2626;
    }
</style>